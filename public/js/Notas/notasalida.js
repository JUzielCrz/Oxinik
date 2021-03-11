const { tail } = require("lodash");

$(document).ready(function () {


    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);


    $(document).on("click","#btnInsertFila", insertfila);
    $(document).on("click","#btnEliminarFila", eliminarFila);


    $(document).on("click","#btn-addEnvio", addenvio);
    $(document).on("click","#btn-remove-envio", removeenvio);
    $(document).on("click","#btn-modal-envio", modal_edit_envio);
    $(document).on("click","#btn-save-envio", save_edit_envio);
    
    $(document).on("click","#btn-save-asignacion", save_asignacion);
    $(document).on("click","#btn-modal-asignacion", modal_edit_asignacion);

    $(document).on("click","#guardar-nota", guardar_nota);

    tail.select('#selectprueba', {
        search: true,
    });

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
            
            $('#num_contrato').val(msg.contrato.num_contrato)
            $('#nombre_cliente').val(msg.contrato.nombre+' '+msg.contrato.apPaterno+' '+msg.contrato.apMaterno)
            $('#tipo_contrato').val(msg.contrato.tipo_contrato)
            $('#asignacion_tanques').val(msg.contrato.asignacion_tanques)
        })


        $('#numcontrato').val('');
        
        if($("#input-group-envio").length){
            removeenvio(); 
        }
        
    });  
    
    function insertfila() {

        var numserie= $('#serie_tanque').val().replace(/ /g,'');

        var campo= ['serie_tanque','cantidad','unidad_medida','precio_unitario','tapa_tanque','iva'];
        var campovacio = [];

        $.each(campo, function(index){
            $('#'+campo[index]+'Error').empty().removeClass('is-invalid');
            $('#'+campo[index]).removeClass('is-invalid');
        });

        $.each(campo, function(index){
            if($("#"+campo[index]).val()==''){
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
            url: "/validventasalida/"+numserie+'',
            data: {
                '_token': $('input[name=_token]').val(),
                },
        }).done(function(msg){
            
            if(msg.mensaje){
                //Insertar fila
                $.ajax({
                    method: "post",
                    url: "/insertfila/"+numserie+'',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        },
                })
                    .done(function (msg) {


                        var precio_importe= $('#precio_unitario').val() * $('#cantidad').val();
                        var iva =0;
                        if( $('#iva').val() == 'SI'){
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

                                limpiar_input_numserie();
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

    function limpiar_input_numserie() {
        $("#serie_tanque").val("");
        $("#tapa_tanque").val("");
        $("#cantidad").val("");
        $("#unidad_medida").val("");
        $("#precio_unitario").val("");
        $("#iva_particular").val("");
    }

    function actualizar_subtotal(){

        var subtotal = 0;

        $(".classfilatanque").each(function(){
            var preciotanque=$(this).find("td")[2].innerHTML;
            subtotal=subtotal+parseFloat(preciotanque);
        })
        $('#labelsubtotal').replaceWith( 
            "<label id='labelsubtotal'>"+Intl.NumberFormat('es-MX').format(subtotal) +"</label>"
        );
        $('#inp-subtotal').val(subtotal);

        actualizar_total();
    }

    

    function actualizar_total(){
        var total=parseFloat($("#precio_envio").val())+parseFloat($("#inp-subtotal").val());
        $('#labeltotal').replaceWith( 
            "<label id='labeltotal'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );
        $('#inp_total').val(total);
        $("#monto_pago").val($("#inp_total").val());
    }

    

  // FUNCIONES DE ENVIO
    function addenvio(){

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

  // FUNCIONES DE ASIGNACION DE TANQUES

    function modal_edit_asignacion(){
        if($('#asignacion_tanques').val() == ''){
            return false;
        }
        $('#modal-edit-asignacion').modal("show");
    }

    function save_asignacion(){
        if($("#contidadtanques").val()=='' ){
            $("#contidadtanquesError").text('Campo cantidad necesario') 
            return false;
        }
        if($("#incidencia").val()==''){
            $("#incidenciaError").text('Campo incidencia necesario')
            return false;
        }

        $.ajax({
            method: "post",
            url: "/notasalida/save_edit_asignacion/"+$('#num_contrato').val(),
            data: $('#form-edit-asignacion').serialize(),
        }).done(function(msg){
            if(msg.alert == 'alert-danger'){
                mostrar_mensaje('#msg-modal-asignacion', msg.mensaje,'alert-danger' , null);
            }else{
                $('#asignacion_tanques').val(msg.num_asignacion);
                mostrar_mensaje('#msg-asignacion-save','editado correctamente','alert-primary' ,'#modal-edit-asignacion');
                window.open("/pdf/asignacion_tanque/"+ msg.id_asignacion, '_blank');
            }
            
        })  
    }

  // FIN FUNCIONES DE ASIGNACION DE TANQUES

    function pagar_nota(){

        if($('#num_contrato').val() == '') {
            mostrar_mensaje("#msg-contrato",'Error, falta información de contrato', "alert-danger",null);
            return false;
        }

        if($('#folio_nota').val() == '') {
            $("#folio_notaError").text('canpoo folio nota necesario');
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

        $("#ingreso-efectivoError").empty();
        if($("#metodo_pago").val()=='Efectivo'){
            if($("#ingreso-efectivo").val() == 0){
                $("#ingreso-efectivoError").text('Campo ingreso de efectivo obligatorio');
                return false;
            }
            if($("#ingreso-efectivo").val() < $("#monto_pago").val()){
                $("#ingreso-efectivoError").text('INGRESI EFECTIVO no puede ser menor a MONTO A PAGAR');
                return false;
            }
        }

        if($("#metodo_pago").val()==''){
            $("#metodo_pago").addClass('is-invalid');
            return false;
        }else{
            $("#metodo_pago").removeClass('is-invalid');
        }


        $('#static-modal-pago').modal("show");

        var adeudo = $("#inp_total").val()-$("#monto_pago").val();
        var cambio = $("#ingreso-efectivo").val()-$("#monto_pago").val();


        $("#labeladeudo").replaceWith(
            "<label id='labeladeudo'>"+Intl.NumberFormat('es-MX').format(adeudo)+"</label>"
        );
    
        if($("#metodo_pago").val() == "Efectivo"){
            $("#labelcambio").replaceWith(
                "<label id='labelcambio'>"+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
            );
        }

    }

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
            url: "/createnota",
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



    ///rescatar

    function cancelarnota(){
        // window.location = "/contrato/"+ $('#idcliente').val();
    }

    // function metodo_limpiar_span_nota(nombreerror) {
    //     $("#folio_nota"+ nombreerror).empty();
    //     $("#fecha"+ nombreerror).empty();
    //     $("#pago_realizado"+ nombreerror).empty();
    //     $("#metodo_pago"+ nombreerror).empty();
    // }
    
    //variable donde guarda todo el data que se envia al controllador
        // var dataFormulario=$("#idFormNewNota").serialize()+'&pago_realizado=' + pagoRealizado;

        

    

});




