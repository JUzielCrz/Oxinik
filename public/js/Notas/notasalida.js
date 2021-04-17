$(document).ready(function () {


    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);


    $(document).on("click","#btnInsertFila", insertfila);
    $(document).on("click","#btnEliminarFila", eliminarFila);


    $(document).on("click","#btn-addEnvio", addenvio);
    $(document).on("click","#btn-remove-envio", removeenvio);
    $(document).on("click","#btn-modal-envio", modal_edit_envio);
    $(document).on("click","#btn-save-envio", save_edit_envio);

    $(document).on("click","#guardar-nota", guardar_nota);


                // $('.select-search').select2();
    //BUSCAR CONTRATO

        $('#numcontrato').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                    method: "POST",
                    url:"notasalida/searchcontrato",
                    data:{'query':query,'_token': $('input[name=_token]').val(),},
                    success:function(data){

                        $('#listarcontratos').fadeIn();  
                        $('#listarcontratos').html(data);

                    }
                });
            }
        });

        $(document).on('click', 'li', function(){  
            $('#listarcontratos').fadeOut();  
            const numcontrato = $(this).text().split(', ');

            $.ajax({
                method: "post",
                url: "/datacontrato/"+numcontrato[0],
                data: {'_token': $('input[name=_token]').val(),},
            })
            .done(function(msg) {
                $('#contrato_id').val(msg.contrato.contrato_id)
                $('#num_contrato').val(msg.contrato.num_contrato)
                $('#nombre_cliente').val(msg.contrato.nombre+' '+msg.contrato.apPaterno+' '+msg.contrato.apMaterno)
                $('#tipo_contrato').val(msg.contrato.tipo_contrato)
                // $('#asignacion_tanques').val(msg.num_asignacion.num_asignacion)

                show_table_asignaciones(msg.contrato.contrato_id, 'tableasignaciones', 'content-asignaciones');
            })

            $("#InputsFilaSalida").prop("disabled", false);

            $('#numcontrato').val('');
            
            if($("#input-group-envio").length){
                removeenvio(); 
            }
            
        }); 
    //FIN BUSCAR CONTRATO



//Funciones para insertar fila de tanque

    
    $("#unidad_medida").change( function() {
        if ($(this).val() == "CARGA") {
            $("#cantidad").prop("readonly", true);
            $("#cantidad").val(1);

        }else{
            $("#cantidad").prop("readonly", false);
        } 
    });


    function insertfila() {

        var numserie= $('#serie_tanque').val().replace(/ /g,'');

        var campo= ['serie_tanque','cantidad','unidad_medida','precio_unitario','tapa_tanque','iva_particular'];
        var campovacio = [];

        $.each(campo, function(index){
            $('#'+campo[index]+'Error').empty();
            $('#'+campo[index]).removeClass('is-invalid');
        });

        $.each(campo, function(index){
            if($("#"+campo[index]).val()=='' || $("#"+campo[index]).val()<=0    ){
                campovacio.push(campo[index]);
            }
        });

        if(campovacio.length != 0){
            $.each(campovacio, function(index){
                $("#"+campovacio[index]).addClass('is-invalid');
                $("#"+campovacio[index]+'Error').text('Necesario');
            });
            return false;
        }

        var boolRepetido=false;
        var deleteespacio=$.trim(numserie);
        $(".classfilatanque").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;

            if(valores == deleteespacio){
                boolRepetido=true;
            }
        })

        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a esta nota');
                return false;
        }

        //validar que tanque no ha sido registrado en almacene o no ha sido registrado como lleno.
        $.ajax({
            method: "post",
            url: "../venta_exporadica/validar_existencia_salida/"+numserie+'',
            data: {
                '_token': $('input[name=_token]').val(),
                },
        }).done(function(msg){
            
            if(msg.mensaje){
                //Insertar fila
                $.ajax({
                    method: "get",
                    url: "/insertfila/"+numserie+'',
                    // data: {
                    //     '_token': $('input[name=_token]').val(),
                    //     },
                })
                    .done(function (msg) {


                        var precio_importe= $('#precio_unitario').val() * $('#cantidad').val();
                        console.log(precio_importe);
                        var iva =0;
                        if( $('#iva_particular').val() == 'SI'){
                            iva = precio_importe * 0.16;
                        }
        
                        if(msg.alert){
                            $('#tablelistaTanques').append(
                                "<tr class='classfilatanque'>"+
                                "<td>"+msg.tanque.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.tanque.num_serie +"'></input>"+
                                "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                                "<td>"+msg.tanque.tipo_gas +"</td>"+ "<input type='hidden' name='input_tipo_gas[]' value='"+msg.tanque.tipo_gas +"'></input>"+
                                "<td>"+$('#cantidad').val() +"</td>"+ "<input type='hidden' name='input_cantidad[]' value='"+$('#cantidad').val() +"'></input>"+
                                "<td>"+$('#unidad_medida').val() +"</td>"+ "<input type='hidden' name='input_unidad_medida[]' value='"+$('#unidad_medida').val() +"'></input>"+
                                "<td>"+$('#precio_unitario').val() +"</td>"+ "<input type='hidden' name='input_precio_unitario[]' value='"+$('#precio_unitario').val() +"'></input>"+
                                "<td>"+precio_importe +"</td>"+ "<input type='hidden' name='input_importe[]' value='"+precio_importe +"'></input>"+
                                "<td>"+iva +"</td>"+ "<input type='hidden' name='input_iva_particular[]' value='"+iva +"'></input>"+

                                "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                                "</tr>");

                                actualizar_subtotal()
                                actualizar_ivageneral()

                                limpiar_inputs_fila();
                        }else{
                            $("#serie_tanqueError").text('Número de serie no existe');
                        }
        
                        return false;
                        
                    })
                        
                    .fail(function (jqXHR, textStatus) {
                        mostrar_mensaje("#divmsg",'Error al insertar', "alert-danger",null);
                        var status = jqXHR.status;
                        if (status === 422) {
                            $.each(jqXHR.responseJSON.errors, function (key, value) {
                                var idError = "#" + key + "Error";
                                //$(idError).removeClass("d-none");
                                $(idError).text(value);
                            });
                        }
                    });
            }else{
                $("#serie_tanqueError").text('Tanque no registrado en almacén o tanque vacio');
            }
        }).fail(function(){
            $("#serie_tanqueError").text('tanque no registrado');
            }
            
        );
        return false;
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
        actualizar_subtotal();
        actualizar_total();
    }

    function limpiar_inputs_fila() {
        $("#serie_tanque").val("");
        $("#tapa_tanque").val("");
        $("#cantidad").val("");
        $("#unidad_medida").val("");
        $("#precio_unitario").val("");
        $("#iva").val("");
    }

    function actualizar_subtotal(){

        var subtotal = 0;

        $(".classfilatanque").each(function(){
            var preciotanque=$(this).find("td")[6].innerHTML;
            subtotal=subtotal+parseFloat(preciotanque);
        })
        $('#label-subtotal').replaceWith( 
            "<label id='label-subtotal'>"+Intl.NumberFormat('es-MX').format(subtotal) +"</label>"
        );
        $('#input-subtotal').val(subtotal);

        actualizar_total();
    }

    function actualizar_ivageneral(){

        var ivaGen = 0;
        $(".classfilatanque").each(function(){
            var preciotanque=$(this).find("td")[7].innerHTML;
            ivaGen=ivaGen+parseFloat(preciotanque);
        })
        $('#label-ivaGen').replaceWith( 
            "<label id='label-ivaGen'>"+Intl.NumberFormat('es-MX').format(ivaGen) +"</label>"
        );
        $('#input-ivaGen').val(ivaGen);

        actualizar_total();
    }

    function actualizar_total(){
        var total=parseFloat($("#precio_envio").val())+parseFloat($("#input-ivaGen").val())+parseFloat($("#input-subtotal").val());
        $('#label-total').replaceWith( 
            "<label id='label-total'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );
        $('#input-total').val(total);
        $("#monto_pago").val(total);
    }

    

  // FUNCIONES DE ENVIO
    function addenvio(){
        if($('#num_contrato').val() == ''){
            return false;
        }
        $.ajax({
            method: "post",
            url: "/datacontrato/"+$('#num_contrato').val(),
            data: {'_token': $('input[name=_token]').val(),},
        })
        .done(function(msg) {
            
            $('#btn-addEnvio').remove();

            if($("#input-group-envio").length){
                return false;
            }else{
                $('#row-envio').append(
                    '<div class="row" id="input-group-envio">'+
                        '<div class="col-auto mr-auto">'+
                            '<div  class="input-group input-group-sm  mb-3">'+
                                '<div class="input-group-prepend ">'+
                                    '<button id="btn-remove-envio" class="btn btn-sm btn-amarillo" type="button"><span class="fas fa-minus"></span></button>'+
                                '</div>'+
                                '<div class="input-group-prepend ">'+
                                        '<button id="btn-modal-envio" class="btn btn-amarillo btn-sm " type="button"><span class="fas fa-edit"></span></button>'+
                                '</div>'+
                                '<div class="input-group-append">'+
                                    '<label class="ml-2">Envío: </label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-auto">'+
                            '<div  class="input-group input-group-sm  mb-3">'+
                                '<div class="input-group-prepend ">'+
                                    '<label id="label_precio_envio">$ '+ Intl.NumberFormat('es-MX').format(msg.contrato.precio_transporte) +'</label>'+
                                '</div>'+
                                
                            '</div>'+
                        '</div>'+

                    '</div>'
                )
                $('#precio_envio').val(msg.contrato.precio_transporte);
                $('#precio_transporte').val(msg.contrato.precio_transporte);
                $('#direccion').val(msg.contrato.direccion);
                $('#referencia').val(msg.contrato.referencia);
                actualizar_total();
            }
        })
        
        
    }

    function removeenvio(){
        $('#input-group-envio').remove();
        $('#row-envio').append(
            '<button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>'
        )
        $('#precio_envio').val(0);
        actualizar_total();
    }

    function modal_edit_envio(){
        $('#modal-edit-evio').modal("show");
    }

    function save_edit_envio(){

        $.ajax({
            method: "post",
            url: "/notasalida/save_edit_envio/"+$('#num_contrato').val(),
            data: $('#form-edit-envio').serialize(),
        }).done(function(msg){
            $('#precio_envio').val(msg.precio_transporte);
            actualizar_total();
            mostrar_mensaje('#msg-envio-save','editado correctamente','alert-primary' ,'#modal-edit-evio');
            $('#label_precio_envio').replaceWith('<label id="laber_envio">$ '+ Intl.NumberFormat('es-MX').format(msg.precio_transporte) +'</label>');
        })  
    }
  // FIN FUNCIONES DE ENVIO

    function pagar_nota(){

        if($('#num_contrato').val() == '') {
            mostrar_mensaje("#msg-contrato",'Error, falta información de contrato', "alert-danger",null);
            return false;
        }

        if($('#folio_nota').val() == '') {
            $("#folio_notaError").text('campoo folio nota necesario');
            return false;
        }

        //SI no hay tanques agregados manda error
        if($('input[id=idInputNumSerie]').length === 0) {
            mostrar_mensaje("#msg-tanques",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }

        if($("#inp_total").val() < $("#monto_pago").val()){
            $("#ingreso-efectivoError").text('"Monto a pagar" no puede ser mayor a "Total"');
            return false;
        }

        if($('#monto_pago').val() <= 0) {
            $("#metodo_pagoError").text('Monto debe ser mayor a 0');
            return false;
        }

        $("#ingreso-efectivoError").empty();
        if($("#metodo_pago").val()=='Efectivo'){
            if($("#ingreso-efectivo").val() == 0){
                $("#ingreso-efectivoError").text('Campo ingreso de efectivo obligatorio');
                return false;
            }
            if($("#ingreso-efectivo").val() < parseFloat($("#monto_pago").val())){
                $("#ingreso-efectivoError").text('INGRESI EFECTIVO no puede ser menor a MONTO A PAGAR');
                return false;
            }
        }

        if($("#metodo_pago").val()==''){
            $("#metodo_pago").addClass('is-invalid');
            $("#metodo_pagoError").text('Selecciona un metodo de pago');
            return false;
        }else{
            $("#metodo_pago").removeClass('is-invalid');
        }


        $('#static-modal-pago').modal("show");

        var adeudo = $("#input-total").val()-$("#monto_pago").val();
        var cambio = $("#ingreso-efectivo").val()-$("#monto_pago").val();


        $("#label-adeudo").replaceWith(
            "<label id='label-adeudo'>"+Intl.NumberFormat('es-MX').format(adeudo)+"</label>"
        );
    
        if($("#metodo_pago").val() == "Efectivo"){
            $("#label-cambio").replaceWith(
                "<label id='label-cambio'>"+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
            );
        }

    }

    $("#metodo_pago").change( function() {
        if ($(this).val() == "Efectivo") {
            $("#ingreso-efectivo").prop("disabled", false);

        }else{
            $("#ingreso-efectivo").prop("disabled", true);
            $("#ingreso-efectivo").val(0);

        } 
    });

    function guardar_nota(){
        // envio al controlador
        $.ajax({
            method: "post",
            url: "/save_notasalida",
            data: $("#form-entrada-nota").serialize(), 
        }).done(function(msg){
            window.open("/pdf/nota/"+ msg.notaId, '_blank');
            location.reload();
        })
        .fail(function (jqXHR, textStatus) {
            //Si existe algun error entra aqui
            mostrar_mensaje("#divmsgnota",'Error, Verifica tus datos', "alert-danger",null);
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key + "Error";
                    //$(idError).removeClass("d-none");
                    $(idError).text(value);
                });
            }
        });

    }


      // FUNCIONES DE ASIGNACION DE TANQUES

    $(document).on("click","#btn-save-asignacion", save_asignacion);
    $(document).on("click","#btn-modal-asignacion-minus", modal_edit_asignacion_minus);
    $(document).on("click","#btn-modal-asignacion-plus", modal_edit_asignacion_plus);

    function modal_edit_asignacion_plus(){
        if($('#num_contrato').val() == ''){
            return false;
        }
        limpiarasignacion();
        $("#h5-title-modal").replaceWith('<h5 class="modal-title" id="h5-title-modal">Aumento</h5>');
        $('#modal-edit-asignacion').modal("show");
        $('#incidencia-asignacion').val("AUMENTO");
    }

    function modal_edit_asignacion_minus(){
        if($('#num_contrato').val() == ''){
            return false;
        }
        limpiarasignacion();
        var contrato_id= $("#contrato_id").val();
        show_table_asignaciones(contrato_id, 'table-show-asignaciones', 'show-asignaciones')
        $("#h5-title-modal").replaceWith('<h5 class="modal-title" id="h5-title-modal">Disminución</h5>');
        $('#modal-edit-asignacion').modal("show");
        $('#incidencia-asignacion').val("DISMINUCION");
        
    }

    function limpiarasignacion(){
        $.ajax({
            method: "get",
            url: "/catalogo_gases",
        }).done(function(msg){
            $(".trasignacion").remove();

            var opciones;
            opciones = '<option value="" selected>SELECCIONA</option>';
            $(msg).each(function(index, value){
                opciones += '<option value="'+value.id+'">'+ value.nombre +'</option>';
            });
            
            $("#tbody-tr-asignacion1").append(
                '<tr class="trasignacion">'+
                '<td>'+
                    '<input name="cantidadtanques[]" id="cantidadtanques" type="number" class="form-control form-control-sm"  placeholder="#">'+
                '</td>'+
                '<td>'+
                    '<select name="tipo_gas[]" id="tipo_gas" class="form-control form-control-sm">'+opciones +'</select>'+
                '</td>'+
                '<td>'+
                    '<button type="button" class="btn btn-amarillo btn-sm" id="btn-anadir-asignacion"><span class="fas fa-plus"></span></button>'+
                '</td>'+
            '</tr>'
            );  
        })
        
    }

    function save_asignacion(){

        // &&falta validar que los campos no esten vacios al enviarlo y cuando regresen limpiar los campos
        $.ajax({
            method: "post",
            url: "/asignacion/"+$('#incidencia-asignacion').val()+"/"+$('#contrato_id').val(),
            data: $('#form-edit-asignacion').serialize(),
        }).done(function(msg){
            
            if(msg.alert == 'alert-danger'){
                mostrar_mensaje('#msg-modal-asignacion', msg.mensaje,'alert-danger' , null);
            }else{

                var contrato_id = $("#contrato_id").val();
                show_table_asignaciones(contrato_id, 'tableasignaciones', 'content-asignaciones');
                mostrar_mensaje('#msg-asignacion-save','editado correctamente','alert-primary' ,'#modal-edit-asignacion');
                limpiarasignacion();
                window.open("/pdf/asignacion_tanque/"+ msg.nota_id, '_blank');

            }
            
        })  
    }

    function show_table_asignaciones(contrato_id, idTabla, idDiv) {
        
        $.get('/showasignaciones/' + contrato_id, function(data) {

            var columnas='';
            $.each(data.asigTanques, function (key, value) {
                columnas+='<tr><td>'+value.cantidad+'</td><td>'+value.nombre+'</td></tr>';
            });

            $('#'+idTabla).remove();
            $('#'+idDiv).append(
                '<div id="'+idTabla+'">'+
                    '<table class="table table-sm">'+
                        '<tbody>'+
                            columnas+
                        '</tbody>'+
                    '</table>'+
                '</div>'
            );
        })
    }

    
  // FIN FUNCIONES DE ASIGNACION DE TANQUES



    ///rescatar

    function cancelarnota(){
        window.location = "/contrato/"+ $('#idcliente').val();
    }

    // function metodo_limpiar_span_nota(nombreerror) {
    //     $("#folio_nota"+ nombreerror).empty();
    //     $("#fecha"+ nombreerror).empty();
    //     $("#pago_realizado"+ nombreerror).empty();
    //     $("#metodo_pago"+ nombreerror).empty();
    // }
    
    //variable donde guarda todo el data que se envia al controllador
        // var dataFormulario=$("#idFormNewNota").serialize()+'&pago_realizado=' + pagoRealizado;

        

    //Generales

    function mostrar_mensaje(divmsg,mensaje,clasecss,modal) {
        if(modal !== null){
            $(modal).modal("hide");
        }
        $(divmsg).empty();
        $(divmsg).addClass(clasecss);
        $(divmsg).append("<p>" + mensaje + "</p>");
        $(divmsg).show(500);
        $.when($(divmsg).hide(5000)).done(function () {
            $(divmsg).removeClass(clasecss);
        });
    }


    $('.numero-entero-positivo').keypress(function (event) {
        // console.log(event.charCode);
        if (
            event.charCode == 43 || //+
            event.charCode == 45 || //-
            event.charCode == 69 || //E
            event.charCode == 101|| //e
            event.charCode == 46    //.
            ){
            return false;
        } 
        return true;
    });

    $('.numero-decimal-positivo').keypress(function (event) {
        // console.log(event.charCode);
        if (
            event.charCode == 43 || //+
            event.charCode == 45 || //-
            event.charCode == 69 || //E
            event.charCode == 101 //e
            ){
            return false;
        } 
        return true;
    });

});




