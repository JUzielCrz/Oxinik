$(document).ready(function () {


    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);


    $(document).on("click","#btnInsertFila", insertfila);
    $(document).on("click","#btnEliminarFila", eliminarFila);


    $(document).on("click","#btn-addEnvio", addenvio);
    $(document).on("click","#btn-remove-envio", removeenvio);

    $(document).on("click","#guardar-nota", guardar_nota);


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
        metodo_limpiar_span("Error");

        var numserie= $('#serie_tanque').val().replace(/ /g,'');

        var campo= [];
        var texterror = [];

        if(numserie == ''){
            campo.push('#serie_tanque');
            texterror.push('Número de serie necesario');
        }
        if($('#precio').val() == ''){
            campo.push('#precio');
            texterror.push('Precio de serie necesario');
        }
        if($('#tapa_tanque').val() == ''){
            campo.push('#tapa_tanque');
            texterror.push('Tapa tanque de serie necesario');
        }
        if($('#regulador').val() == ''){
            campo.push('#regulador');
            texterror.push('Regulador de serie necesario');
        }

        if(campo.length != 0){
            $.each(campo, function(index){
                $(campo[index]+'Error').text(texterror[index]);
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
        
                        if(msg.alert){
                            $('#tablelistaTanques').append(
                                "<tr class='classfilatanque'>"+
                                "<td>"+msg.tanque.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.tanque.num_serie +"'></input>"+
                                "<td>"+msg.tanque.capacidad+' '+msg.tanque.material+' '+msg.tanque.fabricante +
                                "<td>"+$('#precio').val() +"</td>"+ "<input type='hidden' name='inputPrecio[]' value='"+$('#precio').val() +"'></input>"+
                                "<td>"+$('#regulador').val() +"</td>"+ "<input type='hidden' name='inputRegulador[]' value='"+$('#regulador').val() +"'></input>"+
                                "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
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

    function limpiar_input_numserie() {
        $("#serie_tanque").val("");
        $("#tapa_tanque").val("");
        $("#precio").val("");
        $("#regulador").val("");
    }

    function metodo_limpiar_span(nombreerror) {
        $("#serie_tanque"+ nombreerror).empty();
        $("#tapa_tanque"+ nombreerror).empty();
        $("#precio"+ nombreerror).empty();
        $("#regulador"+ nombreerror).empty();
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
                        '<div class="col-md-6">'+
                            '<div  class="input-group input-group-sm  mb-3">'+
                                '<div class="input-group-prepend ">'+
                                    '<button id="btn-remove-envio" class="btn btn-amarillo" type="button"><span class="fas fa-minus"></span></button>'+
                                '</div>'+
                                '<div class="input-group-append">'+
                                    '<label id="subtotal" class="ml-1">Envío</label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-5 text-right">'+
                            '<label id="subtotal">'+msg.contrato.precio_transporte+'</label>'+
                        ' </div>'+
                    '</div>'
                )
                $('#precio-envio').val(msg.contrato.precio_transporte);
                actualizar_total();
            }
        })
        
        
    }

    function actualizar_total(){
        var total=parseFloat($("#precio-envio").val())+parseFloat($("#inp-subtotal").val());
        $('#labeltotal').replaceWith( 
            "<label id='labeltotal'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );
        $('#inp-total').val(total);
        $("#monto-pago").val($("#inp-total").val());
    }


    function removeenvio(){
        $('#input-group-envio').remove();
        $('#row-envio').append(
            '<button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>'
        )
        $('#precio-envio').val(0);
        actualizar_total();
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
        actualizar_subtotal();
        actualizar_total();
    }

    

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

        if($("#inp-total").val() < $("#monto-pago").val()){
            $("#ingreso-efectivoError").text('"Monto a pagar" no puede ser mayor a "Total"');
            return false;
        }

        $("#ingreso-efectivoError").empty();
        if($("#metodo_pago").val()=='Efectivo'){
            if($("#ingreso-efectivo").val() == 0){
                $("#ingreso-efectivoError").text('Campo ingreso de efectivo obligatorio');
                return false;
            }
            if($("#ingreso-efectivo").val() < $("#monto-pago").val()){
                $("#ingreso-efectivoError").text('INGRESI EFECTIVO no puede ser menor a MONTO A PAGAR');
                return false;
            }
        }


        $('#static-modal-pago').modal("show");

        var adeudo = $("#inp-total").val()-$("#monto-pago").val();
        var cambio = $("#ingreso-efectivo").val()-$("#monto-pago").val();

        console.log( $("#ingreso-efectivo").val());
        console.log( $("#monto-pago").val());

        $("#labeladeudo").replaceWith(
            "<label id='labeladeudo'>"+Intl.NumberFormat('es-MX').format(adeudo)+"</label>"
        );
    
        $("#labelcambio").replaceWith(
            "<label id='labelcambio'>"+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
        );

        

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
            // window.location = "/contrato/"+  $('#idcliente').val();
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




