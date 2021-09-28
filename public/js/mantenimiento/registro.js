$(document).ready(function () {

    $(document).on("click","#btn-InsertFila", insert_fila);
    $(document).on("click","#btn-EliminarFila", eliminar_fila);


    $(document).on("click","#btn-save", guardar_registros);

    var contador=0;

    function insert_fila(){
        $('#serie_tanqueError').empty();

        var numserie= $('#serie_tanque').val().replace(/ /g,'');

        if(numserie ==''){
            $('#serie_tanqueError').text('Número de serie obligatorio');
            return false;
        }

        var boolRepetido=false;
        $(".trFilaTanque").each(function(){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == numserie){
                boolRepetido=true;
            }
        })
        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a lista');
                return false;
        }

        var valdiar_estatus="";
        if($("#incidencia").val() == 'ENTRADA'){
            valdiar_estatus='MANTENIMIENTO'
        }else{
            valdiar_estatus='VACIO-ALMACEN'
        }
        

        $.get('/tanque/show_numserie/'+numserie, function(msg) {
            if(msg==''){
                $('#serie_tanqueError').text('Error, No exite registro de tanque con este número de serie');
                return false;
            }
            if(msg.estatus==valdiar_estatus){
                $("#tbodyfilaTanques").append(
                    "<tr class='trFilaTanque'>"+
                        "<td>"+msg.num_serie+"</td>"+"<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                        "<td>"+msg.capacidad+"</td>"+
                        "<td>"+msg.material+"</td>"+
                        "<td>"+msg.ph+"</td>"+
                        "<td>"+msg.fabricante+"</td>"+
                        "<td>"+ "<button type='button' class='btn btn-naranja' id='btn-EliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                    "</tr>"
                );

                contador= contador+1;
                $("#contador").replaceWith(
                    "<h1 id='contador' class='display-1' style='font-size: 6rem;'>"+ contador+"</h1>"
                );
                
                $('#serie_tanque').val('');
            }else{
                $('#serie_tanqueError').text('Error, estatus tanque: '+ msg.estatus);
                return false;
            }
        });
    }

    function eliminar_fila(){
        $(this).closest('tr').remove();

        contador= contador-1;
        $("#contador").replaceWith(
            "<h1 id='contador' class='display-1' style='font-size: 6rem;'>"+ contador+"</h1>"
        );
                
    }


    function guardar_registros(){
        //SI no hay tanques agregados manda error
        if($('input[id=idInputNumSerie]').length === 0) {
            mensaje('error','Error','No hay tanques en lista',null);
            return false;
        }

        var dataForm= $("#formCreateMantenimiento").serialize()+'&cantidad=' + contador;

        $.ajax({
            method: "post",
            url: "/mantenimiento/registro_save",
            data: dataForm,
        }).done(function(msg){
            limpiar_campos();
            mensaje('success','Exito','Registro creado correctamente', 1500);
        })
        .fail(function (jqXHR, textStatus) {
            //Si existe algun error entra aqui
            mensaje('error','Error','Verifica tus datos', null);
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key + "Error";
                    $(idError).text(value);
                });
            }
        });
    }


    //funciones generales
    function mensaje(icono,titulo, mensaje, timer){
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: timer,
            width: 300,
        })
    }



    function limpiar_campos(){
        $('.trFilaTanque').remove();
        contador= 0;
        $("#contador").replaceWith(
            "<h1 id='contador' class='display-1' style='font-size: 6rem;'>"+ contador+"</h1>"
        );
    }

});