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
        if($("#pago_realizado2").val()== ''){
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
        }).done(function(){
            window.location = "/nota/"+ $('#num_contrato').val();
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

    
    function insertfila() {
        metodo_limpiar_span("Error");

        if($('#serie_tanque').val() == ''){
            $("#serie_tanqueError").text('Número de serie necesario');
            return false;
        }

        if($('#tapa_tanque').val() == ''){
            $("#tapa_tanqueError").text('campo necesario');
            return false;
        }

        var boolRepetido=false;
        $(".classfilatanque").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == $('#serie_tanque').val()){
                boolRepetido=true;
            }
        })

        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a esta nota');
                return false;
        }


        $.ajax({
            method: "post",
            url: "/insertfila/"+$('#serie_tanque').val()+'',
            data: {
                '_token': $('input[name=_token]').val(),
                },
        })
            .done(function (msg) {

                if(msg.alert){
                    $('#tablelistaTanques').append(
                        "<tr class='classfilatanque'>"+
                        "<td>"+msg.tanque.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.tanque.num_serie +"'></input>"+
                        "<td>"+msg.tanque.ph +"</td>"+ 
                        "<td>"+msg.tanque.capacidad +"</td>"+
                        "<td>"+msg.tanque.material +"</td>"+
                        "<td>"+msg.tanque.fabricante +"</td>"+
                        "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                        "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                        "</tr>");
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
        return false;
    }

    function limpiar_input_numserie() {
        $("#serie_tanque").val("");
    }

    function metodo_limpiar_span(nombreerror) {
        $("#serie_tanque"+ nombreerror).empty();
        $("#tapa_tanque"+ nombreerror).empty();
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
        } else {
            $("#pago_realizado2").prop("disabled", true);
            $("#pago_realizado2").val('');
        }
    });



    function eliminarFila( index, val){
        $(this).closest('tr').remove();
    }



    function cancelarnota(){
        window.location = "/nota/"+ $('#num_contrato').val();
    }
});




