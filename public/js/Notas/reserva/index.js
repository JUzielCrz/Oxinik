$(document).ready(function () {

    // Data Tables
    var listtabla = $('#tablecruddata').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        processing: true,
        serverSider: true,
        ajax: '/nota/reserva/data',
        columns:[
            {data: 'id'},   
            {data: 'name'},
            {data: 'created_at'},
            {data: 'incidencia'},
            {data: 'btnShow'},
            {data: 'btnDelete'},
            
        ]
    });

    $(document).on("click","#btn-insertar-cilindro", insertar_cilindro);
    $(document).on("click","#btnEliminarFila", eliminarFila);

    $(document).on("click","#btn-save-nota", nota_save);

    $(document).on("click",".btn-show", nota_show);
    $(document).on("click",".btn-delete", nota_delete);

    $('#serie_tanque').keypress(function (event) {
        // console.log(event.charCode);
        if (event.charCode == 13 ){
            event.preventDefault();
            insertar_cilindro();
        } 
    });

    $("#incidencia").change( function() {
        if ($(this).val() == "") {
            $("#serie_tanque").prop("disabled", true);
            $("#tbody-reserva-tanques").empty();
        } else {
            $("#serie_tanque").prop("disabled", false);
            $("#tbody-reserva-tanques").empty();
        }
    });

    function insertar_cilindro() {
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


    function nota_save(){
        $("#incidencia").removeClass('is-invalid');
        if($("#incidencia").val()==""){
            $("#incidencia").addClass('is-invalid');
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
            url: "/nota/reserva/create",
            data: $("#idFormReserva").serialize(), 
        }).done(function(msg){
            if(msg.alert =='success'){  
                mensaje('success','Exito', 'Guardadoo corectamente' , 1000, "#modal-create");
                $("#tbody-reserva-tanques").empty();
                listtabla.ajax.reload(null,false);
                $("#serie_tanqueError").empty();   
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

    function nota_show() {
        $("#tbody-reserva-show").empty();
        $.get('/nota/reserva/show/' + $(this).data('id'), function(msg) { 
            $("#modal-show").modal("show");
            $("#nota_id").replaceWith("<h5 id='nota_id'>Nota id: "+msg.nota.id+"</h5>");
            $("#span-incidencia").replaceWith('<span id="span-incidencia">Incidencia: '+msg.nota.incidencia+'</span>');
            $.each(msg.tanques, function (key, value) {
                $("#tbody-reserva-show").append(
                    "<tr><td>"+value.num_serie+"</td><td>"+value.tipo_gas+", "+value.capacidad+", "+value.material+", "+value.fabricante+", "+value.nombre+", "+value.tipo_tanque+", PH: "+value.ph +"</td></tr>"
                );
            });
        });
    }


    function mensaje(icono,titulo, mensaje, tiempo, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: tiempo,
            width: 300,
        })
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
    }

    function nota_delete(){
        var estatus
        if($(this).parents("tr").find("td")[3].innerHTML == "SALIDA"){
            estatus="LLENO-ALMACEN";
        }else{
            estatus="TANQUE-RESERVA";
        }

        Swal.fire({
            title: 'ELIMINAR',
            text: "Al eliminar esta nota los tanques cambiaran de estatus a "+estatus,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#2F4858',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Continuar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get('/nota/reserva/delete/' + $(this).data('id'), function(msg) { 
                    mensaje("success","EXITO", "Eliminado Correctamente", "1000", null)
                    listtabla.ajax.reload(null,false);
                });
            }
        })
    }
});
