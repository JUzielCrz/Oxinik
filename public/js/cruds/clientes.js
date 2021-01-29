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
            ajax: '/dt_cliente',
            columns:[
                {data: 'apPaterno'},
                {data: 'apMaterno'},
                {data: 'nombre'},
                {data: 'telefono'},
                {data: 'telefonorespaldo'},
                {data: 'btnContrato'},
                {data: 'btnShow'},
                {data: 'btnEdit'},
                {data: 'btnDelete'},
            ]
        });
    
    // CRUD

    metodo_limpiar_span("Error");

    $("input").focusout(function () {
        var value = $(this).val();
        if (value.length == 0) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    $(document).on("click","#btnaccept",metodo_insertar);
    $(document).on("click",".btn-show-modal",metodo_detalle);
    $(document).on("click",".btn-edit-modal",metodo_detalle_edit);
    $(document).on("click",".btn-delete-modal", metodo_detalle_delete);
    $(document).on("click","#btneliminar",metodo_eliminar);
    $(document).on("click","#btnactualizar",metodo_actualizar);
    
    function metodo_insertar() {
        metodo_limpiar_span("Error");
        $.ajax({
            method: "POST",
            url: "/newcliente",
            data: $("#idFormCliente").serialize(),
        })
            .done(function (msg) {
                mostrar_mensaje("#divmsg",msg.mensaje, "alert-warning",null);
                metodo_limpiar_campos();
                listtabla.ajax.reload(null,false);      
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalinsertar");
            })
                
            .fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsg",'Error, verifique sus datos.', "alert-danger",null);
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
    
    function metodo_limpiar_span(nombreerror) {
        $("#apPaterno"+ nombreerror).empty();
        $("#apMaterno"+ nombreerror).empty();
        $("#nombre"+ nombreerror).empty();
        $("#rfc"+ nombreerror).empty();
        $("#email"+ nombreerror).empty();
        $("#telefono"+ nombreerror).empty();
        $("#telefonorespaldo"+ nombreerror).empty();
        $("#direccion"+ nombreerror).empty();
        $("#referencia"+ nombreerror).empty();
        $("#estatus"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos() {
        $("#apPaterno").val("");
        $("#apMaterno").val("");
        $("#nombre").val("");
        $("#rfc").val("");
        $("#email").val("");
        $("#telefono").val("");
        $("#telefonorespaldo").val("");
        $("#direccion").val("");
        $("#referencia").val("");
        $("#estatus").val("");
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
    
    
    function metodo_detalle() {
        $.get('/showcliente/' + $(this).data('id') + '', function(data) {
            $.each(data.clientes, function (key, value) {
                var variable = "#" + key + "info";
                $(variable).val(value);
            });
        }).done(function (msg) {
            if(msg.accesso){
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-warning",null);
            }else{
                $("#modalmostrar").modal("show");
            }
        });;
        
    }
    
    function metodo_detalle_edit() {
        metodo_limpiar_span("editError");
        $.get('/showcliente/' + $(this).data('id') + '', function(data) {
            $.each(data.clientes, function (key, value) {
                var variable = "#" + key + "edit";
                $(variable).val(value);
            });
        }).done(function (msg) {
            if(msg.accesso){
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-warning",null);
            }else{
                $("#modalactualizar").modal("show");
            }
        });
    }
    
    function metodo_actualizar(){
        metodo_limpiar_span("editError");
        $.ajax({
            method: "POST",
            url: "updatecliente/"+$('#idedit').val()+'',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#idedit').val(),
                'apPaterno': $('#apPaternoedit').val(),
                'apMaterno': $('#apMaternoedit').val(),
                'nombre': $('#nombreedit').val(),
                'rfc': $('#rfcedit').val(),
                'email': $('#emailedit').val(),
                'telefono': $('#telefonoedit').val(),
                'telefonorespaldo': $('#telefonorespaldoedit').val(),
                'direccion': $('#direccionedit').val(),
                'referencia': $('#referenciaedit').val(),
                'estatus': $('#estatusedit').val()
                },
        })
            .done(function (msg) {
                listtabla.ajax.reload(null,false); 
                    mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalactualizar");        

            }).fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsgedit",'Error al actualizar, verifique sus datos.', "alert-danger",null);
                var status = jqXHR.status;
                if (status === 422) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        var idError = "#" + key + "editError";
                        $(idError).text(value);
                    });
                }
            });
        return false;
    }

    function metodo_detalle_delete() {
                $("#modaleliminar").modal("show");
                $('#ideliminar').html($(this).data('id'));
    }
    
    function metodo_eliminar() {
        $.ajax({
            method: "POST",
            url: "deletecliente/"+$('#ideliminar').text()+'',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#ideliminar').text()
                }
        }).done(function (msg) {
            listtabla.ajax.reload(null,false); 
            mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modaleliminar");
        }).fail(function (jqXHR, textStatus){
            mostrar_mensaje("#divmsgindex",'Error al eliminar.', "alert-danger",null);
        });       
    }


    //Para Validar Campos

        $('.telefono').keypress(function (event) {
            if (this.value.length === 10) {
                return false;
            }
        });

        // $('.telefonoedit').keypress(function (event) {
        //     if (this.value.length === 10) {
        //         return false;
        //     }
        // });

        $('.solo-text').keypress(function (event) {
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

});
