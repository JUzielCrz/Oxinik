$(document).ready(function () {
    
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
        ajax: '/user/data',
        columns:[
            {data: 'name'},
            {data: 'email'},
            {data: 'btnShow'},
            {data: 'btnEdit'},
            {data: 'btnDelete'},
        ]
    });



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
            url: "/user/create",
            data: $("#idFormUser").serialize(),
        })
            .done(function (msg) {
                listtabla.ajax.reload(null,false);
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalinsertar");
                metodo_limpiar_campos();
            })
                
            .fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsg",'Error al crear Usuario, verifique sus datos.', "alert-danger",null);
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
        $("#nombre"+ nombreerror).empty();
        $("#email"+ nombreerror).empty();
        $("#roleid"+ nombreerror).empty();
        $("#password"+ nombreerror).empty();
        $("#password_confirmation"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos() {
        $("#nombre").val("");
        $("#email").val("");
        $("#roleid").val("");
        $("#password").val("");
        $("#password_confirmation").val("");
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
        $.get('/user/show/' + $(this).data('id') + '', function(data) {
            $.each(data.user, function (key, value) {
                var variable = "#" + key + "info";
                $(variable).val(value);
            });

        $('#roleidinfo').val(data.rolid);

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
        if($(this).data('id') == 1){
            alert('Administrador no se puede editar');
            return false;
        }

        $.get('/user/show/' + $(this).data('id') + '', function(data) {
            $.each(data.user, function (key, value) {
                var variable = "#" + key + "edit";
                $(variable).val(value);
            });

            $('#roleidedit').val(data.rolid);

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
            url: "/user/update/"+$('#idedit').val()+'',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#idedit').val(),
                'name': $('#nameedit').val(),
                'email': $('#emailedit').val(),
                'roles': $('#roleidedit').val()
                },
        })
            .done(function (msg) {
                listtabla.ajax.reload(null,false); 
                    mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalactualizar");        

            }).fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsgedit",'Error al actualizar administrativo, verifique sus datos.', "alert-danger",null);
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
            if($(this).data('id') == 1){
                alert('Administrador no se puede eliminar');
                return false;
            }else{
                $("#modaleliminar").modal("show");
                $('#ideliminar').html($(this).data('id'));
            }
    }
    
    function metodo_eliminar() {
        $.ajax({
            method: "POST",
            url: "/user/delete/"+$('#ideliminar').text()+'',
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



    $('#telefono').keypress(function (event) {
        if (this.value.length === 10) {
            return false;
        }
    });

    $('#telefonoedit').keypress(function (event) {
        if (this.value.length === 10) {
            return false;
        }
    });

    $('.solo-text').keypress(function (event) {
        console.log(event.charCode);
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



    // Mostrar Contraseñas
    $(document).on("click",".mostrarpassword2", password);
    $(document).on("click",".mostrarpassword3", password_confirmation);
    
    function password(){ mostrarPassword('password','.icon2')}
    function password_confirmation(){ mostrarPassword('password_confirmation','.icon3')}

    function mostrarPassword(idelement, spanclass){
        var cambio = document.getElementById(idelement);
        if(cambio.type == "password"){
            cambio.type = "text";
            $(spanclass).removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
            cambio.type = "password";
            $(spanclass).removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
    }
});
