$(document).ready(function () {

    $(document).on("click","#btn-InsertFila", insert_fila);
    $(document).on("click","#btn-EliminarFila", eliminar_fila);


    $(document).on("click","#btn-SaveAll", save_all);

    var contador=0;

    function insert_fila(){
        $('#serie_tanqueError').empty();

        if($('#serie_tanque').val()==''){
            $('#serie_tanqueError').text('Número de serie obligatorio');
            return false;
        }

        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a devoluciones');
                return false;
        }

        var boolRepetido=false;
        $(".trFilaTanque").each(function(){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == $('#serie_tanque').val()){
                boolRepetido=true;
            }
        })

        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a devoluciones');
                return false;
        }

        $.ajax({
            method: "post",
            url: "/buscartanqueinfra/"+$('#serie_tanque').val(),
            data: {
                '_token': $('input[name=_token]').val(),
            }
        }).done(function(msg){
            if(msg.tanque == 'NO ENCONTRADO'){
                
                $('#serie_tanqueError').text('Tanque no registrado como vacio en almacén');
                
            }else{
                $("#tbodyfilaTanques").append(
                    "<tr class='trFilaTanque'>"+
                        "<td>"+msg.tanque.num_serie+"</td>"+"<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.tanque.num_serie +"'></input>"+
                        "<td>"+msg.tanque.capacidad+"</td>"+
                        "<td>"+msg.tanque.material+"</td>"+
                        "<td>"+msg.tanque.ph+"</td>"+
                        "<td>"+ "<button type='button' class='btn btn-naranja' id='btn-EliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+

                    "</tr>"
                );

                contador= contador+1;
                $("#contador").replaceWith(
                    "<h1 id='contador' class='display-1' style='font-size: 6rem;'>"+ contador+"</h1>"
                );
                
                $('#serie_tanque').val('');
            }
        })
    }

    function eliminar_fila(){
        $(this).closest('tr').remove();

        contador= contador-1;
        $("#contador").replaceWith(
            "<h1 id='contador' class='display-1' style='font-size: 6rem;'>"+ contador+"</h1>"
        );
                
    }


    function save_all(){
        limpiar_errores();
        //SI no hay tanquies agregados manda error
        if($('input[id=idInputNumSerie]').length === 0) {
            mostrar_mensaje("#divmsgtanque",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }

        var cantidad=contador;
        var dataForm= $("#formCreateInfra").serialize()+'&cantidad=' + cantidad;

        $.ajax({
            method: "post",
            url: "/savenoteinfra",
            data: dataForm,
        }).done(function(msg){
            limpiar_campos();
            mostrar_mensaje("#divmsgindex", 'Registro creado correctamente', "alert-primary","#modalactualizar");
        })
        .fail(function (jqXHR, textStatus) {
            //Si existe algun error entra aqui
            mostrar_mensaje("#divmsgnota",'Error, Verifica tus datos', "alert-danger",null);
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key + "Error";
                    $(idError).text(value);
                });
            }
        });
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

    function limpiar_errores(){
        $('#fechaError').empty();
        $('#incidenciaError').empty();
    }

    function limpiar_campos(){
        $('#fecha').val('');
        $('#incidencia').val('');
        $('.trFilaTanque').remove();
        contador= 0;
        $("#contador").replaceWith(
            "<h1 id='contador' class='display-1' style='font-size: 6rem;'>"+ contador+"</h1>"
        );
    }

});