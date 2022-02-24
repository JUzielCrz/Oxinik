$(document).ready(function () {

    $(document).on("click","#btn-InsertFila", insert_fila);
    $(document).on("click","#btn-EliminarFila", eliminar_fila);


    $(document).on("click","#btn-save", guardar_registros);

    var contador=0;

    $('#serie_tanque').keypress(function (event) {
        // console.log(event.charCode);
        if (event.charCode == 13 ){
            event.preventDefault();
            insert_fila();
        } 
    });

    function insert_fila(){
        
        $('#serie_tanqueError').empty();

        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();

        if(numserie ==''){
            $('#serie_tanqueError').text('Número de serie obligatorio');
            $('#serie_tanque').val('');
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
            $("#tbody_errores").append('<tr><td>'+numserie+'</td><td>Repetido</td></tr>');
            $('#serie_tanque').val('');
            return false;
        }

        $.get('/tanque/show_numserie/'+numserie, function(msg) {
            if(msg==''){
                $('#serie_tanqueError').text('Error, No exite registro de tanque con este número de serie');
                $("#tbody_errores").append('<tr><td>'+numserie+'</td><td>Sin Registrar</td></tr>');
                $('#serie_tanque').val('');
                return false;
            }
            if(msg.estatus=='VACIO-ALMACEN'){
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
                $("#tbody_errores").append('<tr><td>'+numserie+'</td><td>Estatus: '+msg.estatus+'</td></tr>');
                $('#serie_tanque').val('');
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

        var dataForm= $("#formCreateInfra").serialize()+'&cantidad=' + contador;

        $.ajax({
            method: "post",
            url: "/infra/salida_save",
            data: dataForm,
        }).done(function(msg){
            limpiar_campos();
            mensaje('success','Exito','Registro creado correctamente', 1500);
            window.open("/pdf/infra/nota/"+ msg.notaId, '_blank');
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
        $('#tbody_errores').empty();
    }

    
});