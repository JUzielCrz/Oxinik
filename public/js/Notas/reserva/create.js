$(document).ready(function () {
    $("#incidencia").change( function() {
        if ($(this).val() == "") {
            $("#serie_tanque").prop("disabled", true);
            $("#tbody-reserva-tanques").empty();
        } else {
            $("#serie_tanque").prop("disabled", false);
            $("#tbody-reserva-tanques").empty();
        }
    });

    $(document).on("click","#btn-insertar-cilindro", insert_cilindro);
    $('#serie_tanque').keypress(function (event) {
        if (event.charCode == 13 ){
            event.preventDefault();
            insert_cilindro();
        } 
    });

    function insert_cilindro(){
        $("#serie_tanqueError").empty();
        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();

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
            $("#serie_tanque").val("");
            return false;
        }

        var estatus="";
        if($("#incidencia").val()=="ENTRADA"){
            estatus="TANQUE-RESERVA"
        }
        if($("#incidencia").val()=="SALIDA"){
            estatus="LLENO-ALMACEN"
        }

        $.get('/tanque/show_numserie/' + numserie, function(msg) { 
            if(msg != ''){
                $.get('/tanque/validar_talon/' + numserie, function(rsta) {
                    if(rsta){
                        $("#serie_tanqueError").text('Cilindro se encuentra en nota talon');
                        return false;
                    }
                    $.get('/tanque/validar_ph/' + msg.ph, function(respuesta) {
                        if(respuesta.alert=='vencido'){
                            //detener 
                            mensaje("error","PH: "+msg.ph, respuesta.mensaje, null, null);
                            return false;
                        }
                        if(respuesta.alert){
                            mensaje("warning","PH: "+msg.ph, respuesta.mensaje, null, null);
                        }
                        if(msg.estatus == estatus){                                
                            $('#tbody-reserva-tanques').append(
                            "<tr class='classfilatanque'>"+
                            "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                            "<td>"+msg.tipo_gas+", "+msg.capacidad+", "+msg.material+", "+msg.fabricante+", "+msg.gas_nombre+", "+msg.tipo_tanque+", PH: "+msg.ph +"</td>"+
                            "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                            "</tr>");
                            $("#serie_tanque").val("");
                            return false;
                        }else{
                            $("#serie_tanqueError").text('Error Tanque - estatus: '+ msg.estatus);
                            $("#serie_tanque").val("");
                            return false;
                        }
                    });
                });
            }else{
                $("#serie_tanqueError").text('Número de serie no existe');
                $("#serie_tanque").val("");
                return false;
            }
            
        });
        return false;
    }

    $(document).on("click","#btn-save-nota", function(){
        $("#incidencia").removeClass('is-invalid');
        if($("#incidencia").val()==""){
            $("#incidencia").addClass('is-invalid');
            mensaje('error','Error', 'Faltan campos por rellenar', null, null);
            return false;
        }
        $("#driver").removeClass('is-invalid');
        if($("#driver").val()==""){
            $("#driver").addClass('is-invalid');
            mensaje('error','Error', 'Faltan campos por rellenar', null, null);
            return false;
        }
        //SI no hay tanques agregados en entrada manda error
        if($('#idInputNumSerie').length === 0) {
            mensaje('error','Error', 'No hay registro de tanques', null, null);
            return false;
        }
        // envio al controlador
        $.ajax({
            method: "post",
            url: "/nota/reserva/save",
            data: $("#idFormReserva").serialize(), 
        }).done(function(msg){
            if(msg.alert =='success'){  
                window.open("/nota/reserva/pdf/"+ msg.notaId, '_blank');
                window.location = '/nota/reserva/index';
            }
        })
        .fail(function (jqXHR, textStatus) {
            //Si existe algun error entra aqui
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key + "Error";
                    //$(idError).removeClass("d-none");
                    $(idError).text(value);
                });
            }
        });
    });

    $(document).on("click","#btnEliminarFila", function (){
        $(this).closest('tr').remove();
    });
    
    function mensaje(icono,titulo, mensaje, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,

            width: 300,
        })
    }
});