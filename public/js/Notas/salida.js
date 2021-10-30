$(document).ready(function () {


    $(document).on("click","#btn-pagar-nota", pagar_nota);

    $(document).on("click","#btnInsertFila", insertfila);
    $(document).on("click","#btnEliminarFila", eliminarFila);


    $(document).on("click","#btn-addEnvio", addenvio);
    $(document).on("click","#btn-remove-envio", removeenvio);
    $(document).on("click","#btn-modal-envio", modal_edit_envio);
    $(document).on("click","#btn-save-envio", save_edit_envio);

    $(document).on("click","#guardar-nota", guardar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);

    //BUSCAR CONTRATO

        $('#numcontrato').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                    method: "POST",
                    url:"/nota/salida/search_contrato",
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
                url: "/nota/data_contrato/"+numcontrato[0],
                data: {'_token': $('input[name=_token]').val(),},
            })
            .done(function(msg) {
                $('#contrato_id').val(msg.contrato.contrato_id)
                $('#num_contrato').val(msg.contrato.num_contrato)
                if(msg.contrato.nombre == null){
                    $('#nombre_cliente').val('------')
                }else{
                    $('#nombre_cliente').val(msg.contrato.nombre+' '+msg.contrato.apPaterno+' '+msg.contrato.apMaterno)
                };  
                $('#nombre_empresa').val(msg.contrato.empresa)
                $('#tipo_contrato').val(msg.contrato.tipo_contrato)
                $('#tablelistaTanques').empty();

                show_nota_lista_tanques(msg.contrato.contrato_id, 'tbody-tanques-nota');
                show_table_asignaciones(msg.contrato.contrato_id, 'tableasignaciones', 'content-asignaciones');
            })

            $("#InputsFilaSalida").prop("disabled", false);

            $('#numcontrato').val('');
            
            if($("#input-group-envio").length){
                removeenvio(); 
            }
            
        }); 

        function show_nota_lista_tanques(contrato_id, tbody) {
            
            $.get('/nota/entrada/tanques_pendientes/' + contrato_id, function(data) {
                var columnas='';
                $.each(data, function (key, value) {
                    columnas+='<tr class="class-tanques-nota"><td>'+
                    value.num_serie+'</td><td>'+
                    value.tanque_desc+'</td><td>'+
                    value.tapa_tanque+'</td><td>'+
                    value.fecha+ '</td><td>' +
                    value.nota_id+'</td><td>'+
                    '<a type="button" href="/pdf/nota/'+value.nota_id+'" target="_blank" class="btn btn-sm btn-grisclaro btn-nota-id" ><i class="fas fa-sticky-note"></i></a></td></tr>';
                });
                $('.class-tanques-nota').remove();
                $('#'+tbody).append(columnas);
            });
        }
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

        var campo= ['serie_tanque','cantidad','unidad_medida','precio_unitario','tapa_tanque'];
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


        $.get('/tanque/show_numserie/' + numserie, function(msg) { 
            
            if(msg != ''){
                $.get('/tanque/validar_ph/' + msg.ph, function(respuesta) {
                    if(respuesta.alert){
                        //detener 
                        mensaje("error","PH: "+msg.ph, "Prueba Hidrostática  proximo a VENCER o VENCIDO", null, null);
                        return false;
                    }else{
                        if(msg.estatus == 'LLENO-ALMACEN'){
                            $.ajax({
                                method: "post",
                                url: "/nota/salida/validar_tanqueasignacion",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'contrato_id': $('#contrato_id').val(),
                                    'num_serie': $('#serie_tanque').val(),
                                    },
                            })
                            .done(function(msgasignacion){
                                if(msgasignacion.mensaje){
                                    
                                    var precio_importe= $('#precio_unitario').val() * $('#cantidad').val();
                                    var iva =0;
                                    
                                    if( msg.tipo_tanque == 'Industrial'){
                                        iva = precio_importe * 0.16;
                                    }
            
                                    $('#tablelistaTanques').append(
                                        "<tr class='classfilatanque'>"+
                                        "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                                        "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                                        "<td>"+msg.tipo_gas +"</td>"+ "<input type='hidden' name='input_tipo_gas[]' value='"+msg.tipo_gas +"'></input>"+
                                        "<td>"+$('#cantidad').val() +"</td>"+ "<input type='hidden' name='input_cantidad[]' value='"+$('#cantidad').val() +"'></input>"+
                                        "<td>"+$('#unidad_medida').val() +"</td>"+ "<input type='hidden' name='input_unidad_medida[]' value='"+$('#unidad_medida').val() +"'></input>"+
                                        "<td>"+$('#precio_unitario').val() +"</td>"+ "<input type='hidden' name='input_precio_unitario[]' value='"+$('#precio_unitario').val() +"'></input>"+
                                        "<td>"+precio_importe +"</td>"+ "<input type='hidden' name='input_importe[]' value='"+precio_importe +"'></input>"+
                                        "<td>"+iva +"</td>"+ "<input type='hidden' name='input_iva_particular[]' value='"+iva +"'></input>"+    
                                        "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                                        "</tr>");
        
                                        actualizar_subtotal()
                                        limpiar_inputs_fila();
        
                                        return false;
                                }else{
                                    $("#serie_tanqueError").text('No tiene asignado en contrato este tipo de tanque');
                                }
                            }); 
                        }else{
                            $("#serie_tanqueError").text('Error Tanque - estatus: '+ msg.estatus);
                        }
                    }
                });
                
            
            }else{
                $("#serie_tanqueError").text('Número de serie no existe');
            }
            
        });
        return false;
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
        actualizar_subtotal();
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

        var sumimporte = 0;

        $(".classfilatanque").each(function(){
            var preciotanque=$(this).find("td")[6].innerHTML;
            sumimporte=sumimporte+parseFloat(preciotanque);
        })

        actualizar_ivageneral();
        var subtotal = sumimporte -  $('#input-ivaGen').val();

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
    }

    function actualizar_total(){
        var importe = 0;

        $(".classfilatanque").each(function(){
            var preciotanque=$(this).find("td")[6].innerHTML;
            importe=importe+parseFloat(preciotanque);
        })
        var total=parseFloat($("#precio_envio").val()) + importe;
        
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
            method: "get",
            url: "/contrato/envio/show/"+$("#contrato_id").val(),
            data: {'_token': $('input[name=_token]').val(),},
        })
        .done(function(msg) {
            $('#btn-addEnvio').remove();

            if($("#input-group-envio").length){
                return false;
            }else{
                $('#row-envio').append(
                    '<div class="row mr-3" id="input-group-envio">'+
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
                                    '<label id="label_precio_envio">$ '+ Intl.NumberFormat('es-MX').format(msg.contratos.precio_transporte) +'</label>'+
                                '</div>'+
                                
                            '</div>'+
                        '</div>'+

                    '</div>'
                )
                $('#precio_envio').val(msg.contratos.precio_transporte);
                $('#precio_transporte').val(msg.contratos.precio_transporte);
                $('#direccion').val(msg.contratos.direccion);
                $('#referencia').val(msg.contratos.referencia);
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
            url: "/nota/salida/save_envio/"+$('#num_contrato').val(),
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


        //SI no hay tanques agregados manda error
        if($('input[id=idInputNumSerie]').length === 0) {
            mostrar_mensaje("#msg-tanques",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }


        if(parseFloat($('#monto_pago').val()) <= 0) {
            $("#metodo_pagoError").text('Monto debe ser mayor a 0');
            return false;
        }

        $("#ingreso-efectivoError").empty();
        if($("#metodo_pago").val()=='Efectivo'){
            if(parseFloat($("#ingreso-efectivo").val()) == 0){
                $("#ingreso-efectivoError").text('Campo ingreso de efectivo obligatorio');
                return false;
            }
            if(parseFloat($("#ingreso-efectivo").val()) < parseFloat($("#monto_pago").val())){
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
            $("#metodo_pagoError").empty();
        }


        if(parseFloat($("#monto_pago").val()) > parseFloat($("#input-total").val())){
            $("#ingreso-efectivoError").text('Monto de pago no puede ser mayor al total de la nota');
            return false;
        }else{
            $("#ingreso-efectivoError").empty();
        }


        $('#static-modal-pago').modal("show");

        var adeudo = parseFloat($("#input-total").val())- parseFloat($("#monto_pago").val());
        
        
        $("#label-adeudo").replaceWith(
            "<label id='label-adeudo'>"+Intl.NumberFormat('es-MX').format(adeudo)+"</label>"
        );
    
        var cambio = 0;
        if($("#metodo_pago").val() == "Efectivo"){
            cambio = parseFloat($("#ingreso-efectivo").val())-parseFloat($("#monto_pago").val());
            $("#label-cambio").replaceWith(
                "<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
            );
        }else{
            $("#label-cambio").replaceWith(
                "<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
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
            url: "/nota/salida/save",
            data: $("#form-salida-nota").serialize(), 
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

    function show_table_asignaciones(contrato_id, idTabla, idDiv) {
        
        $.get('/asignaciones/show/' + contrato_id, function(data) {

            var columnas='';
            $.each(data.asigTanques, function (key, value) {
                columnas+='<tr><td>'+
                value.cilindros+'</td><td>'+
                value.nombreGas+'</td><td>'+
                value.tipo_tanque+'</td><td>'+
                value.material+'</td><td> $'+
                value.precio_unitario+'</td><td>'+
                value.unidad_medida+'</td></tr>';
            });

            $('#'+idTabla).remove();
            $('#'+idDiv).append(
                '<div id="'+idTabla+'" class="table-responsive">'+
                    '<table class="table table-sm" style="font-size:12px;">'+
                        '<tbody>'+
                            columnas+
                        '</tbody>'+
                    '</table>'+
                '</div>'
            );



        })
    }

    

    
  // FIN FUNCIONES DE ASIGNACION DE TANQUES



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

    function mensaje(icono,titulo, mensaje, tiempo, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: tiempo,
            width: 300,
        })
    }

    $('.numero-entero-positivo').keypress(function (event) {
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

    //Cancelar nota
    function cancelarnota(){
        Swal.fire({
            title: 'CANCELAR',
            text: "¿Estas seguro de cancelar esta venta?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Continuar!'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        })
    }

});




