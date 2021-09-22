$(document).ready(function () {


    $(document).on("click","#btnGuardar", insertnota);
    $(document).on("click","#btnCancelar", cancelarnota);


    $(document).on("click","#btnInsertFila", insertfila);
    $(document).on("click","#btnEliminarFila", eliminarFila);





            
    function insertnota(){

        metodo_limpiar_span_nota("Error");

        //Concatena las variables dependiendo el select que seleccione
        var pagoRealizado;
        if($("#pago_realizado1").val() == "SI"){
            pagoRealizado = $("#pago_realizado1").val()+' '+ $("#pago_realizado2").val();
        }else{
            pagoRealizado = $("#pago_realizado1").val();
        }

        //Valida si en el campo fecha de Pago realizado esta vacio y manda error
        if($($("#pago_realizado1").val()== 'SI' && "#pago_realizado2").val()== ''){
            mostrar_mensaje("#divmsgnota",'Error, Verifica tus datos', "alert-danger",null);

            $("#pago_realizadoError").text('Selecciona fecha en que se realizo el pago');
            return false;
        }

        //SI no hay tanquies agregados manda error
        if($('input[id=idInputNumSerie]').length === 0) {
            mostrar_mensaje("#divmsgtanque",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }

        
        //variable donde guarda todo el data que se envia al controllador
        var dataFormulario=$("#idFormNewNota").serialize()+'&pago_realizado=' + pagoRealizado;

        //envio al controlador
        $.ajax({
            method: "post",
            url: "/createnota",
            data: dataFormulario, 
        }).done(function(msg){
            window.location = "/contrato/"+  $('#idcliente').val();
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

    var preciototal = 0;
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
                    url: "/tanque/show_numserie/"+numserie+'',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        },
                })
                    .done(function (msg) {
        
                        if(msg != ''){
                            $('#tablelistaTanques').append(
                                "<tr class='classfilatanque'>"+
                                "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                                "<td>"+msg.capacidad+' '+msg.material+' '+msg.fabricante +
                                "<td>"+$('#precio').val() +"</td>"+ "<input type='hidden' name='inputPrecio[]' value='"+$('#precio').val() +"'></input>"+
                                "<td>"+$('#regulador').val() +"</td>"+ "<input type='hidden' name='inputRegulador[]' value='"+$('#regulador').val() +"'></input>"+
                                "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                                "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                                "</tr>");

                                preciototal=preciototal+Number($('#precio').val());
                                $('#total').remove();
                                $('#preciototal').append( 
                                    "<label id='total'>"+Intl.NumberFormat('es-MX').format(preciototal) +"</label>"
                                );
                                $('#inputTotal').val(preciototal);

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

    function metodo_limpiar_span_nota(nombreerror) {
        $("#folio_nota"+ nombreerror).empty();
        $("#fecha"+ nombreerror).empty();
        $("#pago_realizado"+ nombreerror).empty();
        $("#metodo_pago"+ nombreerror).empty();
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

    $("#pago_realizado1").change( function() {
        if ($(this).val() == "SI") {
            $("#pago_realizado2").prop("disabled", false);

            $("#metodo_pago").prop("disabled", false);
        } else {
            $("#pago_realizado2").prop("disabled", true);
            $("#pago_realizado2").val('');

            $("#metodo_pago").prop("disabled", true);
            $("#metodo_pago").val('');
        }
    });

    function eliminarFila(){
        $(this).closest('tr').remove();
        preciototal = 0;
        $(".classfilatanque").each(function(){
            preciototal=preciototal+parseFloat($(this).find("td")[2].innerHTML);
        })

        $('#total').remove();
        $('#preciototal').append( 
            "<label id='total'>"+Intl.NumberFormat('es-MX').format(preciototal) +"</label>"
            
        );
        $('#inputTotal').val(preciototal);
    }

    function cancelarnota(){
        window.location = "/contrato/"+ $('#idcliente').val();
    }
});




