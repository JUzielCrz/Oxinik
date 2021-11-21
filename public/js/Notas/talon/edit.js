$(document).ready(function () {
    $(document).on("click","#btn-insert-fila-salida", insertar_fila_salida);
    $(document).on("click","#btnEliminarFila", eliminarFila);
    

    //Nota General
    $(document).on("click","#btnCancelar", cancelarnota);
    $(document).on("click","#guardar-nota", guardar_nota);


    $('#serie_tanque').keypress(function (event) {
        // console.log(event.charCode);
        if (event.charCode == 13 ){
            event.preventDefault();
            insert_fila();
        } 
    });

    if($(".classfilatanque_salida").length == $(".classfilatanque_entrada").length){
        $('#guardar-nota').prop('disabled', true);
    }

    //FUNCIONES INSERTAR FILA SALIDA

    function insertar_fila_salida() {

        //limpiar span input
        $('#serie_tanqueError').empty();
        $('#tapa_tanqueError').empty();
        //Eliminar espacios
        var numserie= $('#serie_tanque').val().replace(/ /g,'');
        //validar campos vacios
        if(numserie == ''){
            $('#serie_tanque').addClass('is-invalid');
            $('#serie_tanqueError').text('Necesario');
            return false;
        }
        
        if($('#tapa_tanque').val() == ''){
            $('#tapa_tanque').addClass('is-invalid');
            $('#tapa_tanqueError').text('Necesario');
            return false;
        }

        //validar campos repetidos
        var boolRepetido=false;
        $(".classfilatanque_salida").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == numserie){
                boolRepetido=true;
            }
        })
        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a esta nota');
                return false;
        }

        //validar si tanque pertenece a cliente
        var boolPertenencia=true;
        $(".classfilatanque_entrada").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == numserie){
                boolPertenencia=false;
            }
        })
        if(boolPertenencia){
            $("#serie_tanqueError").text('Tanque no pertenece a cliente');
            return false;
        }

        // if($(".classfilatanque_salida").length == $(".classfilatanque_entrada").length){
        //     $("#serie_tanqueError").text('No puedes revasar cantidad de cilindros');
        //     return false;
        // }

        $.get('/tanque/show_numserie/' + numserie, function(msg) { 
            if(msg != ''){
                if(msg.estatus == 'LLENO-ALMACEN'){

                    $('#tablelistaTanques').append(
                        "<tr class='classfilatanque_salida' style='font-size: 13px'>"+
                            "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie_salida[]' id='idInputNumSerie_salida' value='"+msg.num_serie +"'></input>"+
                            "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                            "<td>"+msg.material+", "+msg.fabricante+", "+msg.tipo_tanque+", PH: "+msg.ph +"</td>"+ 

                            "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                        "</tr>");

                        limpiar_campos_tanque()

                }else{
                    $("#serie_tanqueError").text('Error Tanque - estatus: '+ msg.estatus);
                }
            }else{
                $("#serie_tanqueError").text('Número de serie no existe en almacén');
            }

        });

        return false;
    }

    function limpiar_campos_tanque(){
        $('#serie_tanque').val("");
        $("#tapa_tanque").val('');
    }




    //Funciones finales de Nota General

    function guardar_nota(){

        
        //SI no hay tanques agregados en salida manda error
        if($('#idInputNumSerie_salida').length === 0) {
            mensaje('error','Error', 'No hay registro de tanques de salida', null, null);
            return false;
        }

        // envio al controlador
        $.ajax({
            method: "post",
            url: "/nota/talon/edit/save/"+$("#idnota").val(),
            data: $("#idFormNewVenta").serialize(), 
        }).done(function(msg){
            if(msg.alert =='success'){  
                window.open("/pdf/nota/talon/"+ msg.notaId, '_blank');
                location.reload();
            }
            if(msg.alert =='error'){  
                mensaje('error','Error', msg.mensaje , null, null);
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

    }

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
                window.location= '/nota/talon/index';
            }
        })
    }


    
    //funciones generales
    function mensaje(icono,titulo, mensaje, timer, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: timer,
            width: 300,
        })
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
    }

    $('.numero-entero-positivo').keypress(function (event) {
        // console.log(event.charCode);
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
        // console.log(event.charCode);
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

    $('.solo-texto').keypress(function (event) {
        // console.log(event.charCode);
        if (event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122 || 
            event.charCode ==  32 ||
            event.charCode == 193 || 
            event.charCode == 201 ||
            event.charCode == 205 || 
            event.charCode == 211 || 
            event.charCode == 218 || 
            event.charCode == 225 || 
            event.charCode == 233 ||
            event.charCode == 237 || 
            event.charCode == 243 ||
            event.charCode == 250 ||
            event.charCode == 241 ||
            event.charCode == 209  ){
            return true;
        } 
        return false;
    });

    $('.lenght-telefono').keypress(function (event) {
        if (this.value.length === 10) {
            return false;
        }
    });

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