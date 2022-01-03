$(document).ready(function () {

    $(document).on("click","#btn-InsertFila", insert_fila);
    $(document).on("click","#btn-EliminarFila", eliminar_fila);
    $(document).on("click","#btn-save", guardar_registros);


    $('#serie_tanque').keypress(function (event) {
        // console.log(event.charCode);
        if (event.charCode == 13 ){
            event.preventDefault();
            insert_fila();
        } 
    });

    $("#ph_anio").val(new Date().getFullYear());
    var contador=0;

    function insert_fila(){
        $('#serie_tanqueError').empty();
        $('#serie_tanque').removeClass('is-invalid');
        $('#folio_talonError').empty();
        $('#folio_talon').removeClass('is-invalid');

        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();
        
        if(numserie ==''){
            $('#serie_tanqueError').text('Número de serie obligatorio');
            $('#serie_tanque').addClass('is-invalid');
            return false;
        }
        
        if($("#folio_talon").val() ==''){
            $('#folio_talon').addClass('is-invalid');
            $('#folio_talonError').text('Folio Talón obligatorio');
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


        $.get('/tanque/show_numserie/'+numserie, function(msg) {
            if(msg==''){
                $('#serie_tanqueError').text('Error, No exite registro de tanque con este número de serie');
                return false;
            }

            if(msg.estatus=="VACIO-ALMACEN"|| msg.estatus == "INFRA"){
                $("#tbodyfilaTanques").append(
                    "<tr class='trFilaTanque'>"+
                        "<td>"+msg.num_serie.toUpperCase()+"</td>"+"<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie.toUpperCase() +"'></input>"+
                        "<td>"+msg.gas_nombre+", "+msg.capacidad+", "+ msg.fabricante+", "+msg.material+"</td>"+
                        "<td>"+msg.ph+"</td>"+"<input type='hidden' name='inputPH[]' id='idInputPH' value='"+msg.ph+"'></input>"+
                        "<td>"+$("#folio_talon").val()+"</td>"+"<input type='hidden' name='inputTalon[]' id='idInputTalon' value='"+$("#folio_talon").val()+"'></input>"+
                        "<td>"+ "<button type='button' class='btn btn-naranja' id='btn-EliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                    "</tr>"
                );
                contador= contador+1;
                $("#contador").replaceWith(
                    "<h1 id='contador' class='display-1' style='font-size: 6rem;'>"+ contador+"</h1>"
                );
                $('#serie_tanque').val('');
                if($('#mantener_folio').is(':checked') == false){
                    $('#folio_talon').val("");
                }
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
            url: '/mantenimiento/registro_salida',
            data: dataForm,
        }).done(function(msg){
            limpiar_campos();
            mensaje('success','Exito','Registro creado correctamente', 1500);
            window.open("/pdf/mantenimiento/nota/"+ msg.notaId, '_blank');
            window.location = "/mantenimiento/index";
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
        $('#ph_mes').val('');
        $('#folio_talon').val('');
        $('#mantener_folio').prop('checked', false);
    }


    $('.anio_format').keypress(function (event) {
        if (this.value.length === 4||
            event.charCode == 43 || //+
            event.charCode == 45 || //-
            event.charCode == 69 || //E
            event.charCode == 101|| //e
            event.charCode == 46    //.
            ) {
            return false;
        }
    });
});