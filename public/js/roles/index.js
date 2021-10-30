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
        ajax: '/rol/data',
        columns:[
            {data: 'name'},
            {data: 'slug'},
            {data: 'description'},
            // {data: 'btnShow'},
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
        var campo=$('#slug').val();
        if(campo.includes(' ')){
            mostrar_mensaje("#divmsg",'campo slug no debe contener espacios', "alert-danger",null);
            return false;
        }

        if ($('input[type=checkbox]:checked').length === 0) {
            mostrar_mensaje("#divmsg",'Debes seleccionar al menos un permiso', "alert-danger",null);
            return false;
        }

        $.ajax({
            method: "POST",
            url: "/rol/create",
            data: $("#idformRole").serialize(),
            
        })
            .done(function (msg) {
                mostrar_mensaje("#divmsg",msg.mensaje, "alert-warning",null);
                metodo_limpiar_campos();
                listtabla.ajax.reload(null,false);      
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalinsertar");
            })
                
            .fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsg",'Error al crear rol, verifique sus datos.', "alert-danger",null);
                var status = jqXHR.status;
                if (status === 422) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        var idError = "#" + key + "Error";
                        $(idError).text(value);
                    });
                }
            });
        return false;
    }
    
    function metodo_limpiar_span(nombreerror) {
        $("#name"+ nombreerror).empty();
        $("#slug"+ nombreerror).empty();
        $("#description"+ nombreerror).empty();
        $("#fullaccess"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos() {
        $("#name").val("");
        $("#slug").val("");
        $("#description").val("");
        $("#fullaccess").val("");
        $("#permission").val("");
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
        $.get('/rol/show/' + $(this).data('id') + '', function(data, msg) {
            $.each(data.rol, function (key, value) {
                var variable = "#" + key + "info";
                $(variable).val(value);
            });
            var elementos = document.getElementsByName("permissioninfo[]");
            $.each(elementos,function(indice){ 
                elementos[indice].checked=false;
            });
            $.each(data.permisosroles, function (key, valor) {
                $.each(elementos,function(i){
                    if(elementos[i].value==valor.permission_id){
                        elementos[i].checked=true;
                    } 
                });

            });
        }).done(function (msg) {
            if(msg.accesso){
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-warning",null);
            }else{
                $("#modalmostrar").modal("show");
            }
            
        });
        
    }

    function metodo_detalle_edit() {
        if($(this).data('id') ==1){
            return false;
        }
        metodo_limpiar_span("editError");
        $.get('/rol/show/' + $(this).data('id') + '', function(data, msg) {
            $.each(data.rol, function (key, value) {
                var variable = "#" + key + "edit";
                $(variable).val(value);
            });
            var elementos = document.getElementsByName("permissionedit[]");
            $.each(elementos,function(indice){ 
                elementos[indice].checked=false;
            });
            $.each(data.permisosroles, function (key, valor) {
                $.each(elementos,function(i){
                    if(elementos[i].value==valor.permission_id){
                        elementos[i].checked=true;
                    } 
                });
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

        if ($('input[type=checkbox]:checked').length === 0) {
            mostrar_mensaje("#divmsgedit",'Debes seleccionar al menos un permiso', "alert-danger",null);
        }
        
        var elementos = document.getElementsByName("permissionedit[]");
        var idpermisos=[];
        
        $.each(elementos,function(indice){ 
            if(elementos[indice].checked){
                idpermisos.push(elementos[indice].value);
            }
        });
        $.ajax({
            method: "POST",
            url: "/rol/update/"+$('#idedit').val()+'',
            data: 
                {
                '_token': $('input[name=_token]').val(),
                'name': $('#nameedit').val(),
                'slug': $('#slugedit').val(),
                'description': $('#descriptionedit').val(),
                'fullaccess': $('#fullaccessedit').val(),
                'permission': idpermisos
                },
        })
            .done(function (msg) {
                    listtabla.ajax.reload(null,false);  
                    mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalactualizar");        

            }).fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsgedit",'Error al actualizar ciclo escolar, verifique sus datos.', "alert-danger",null);
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

    function metodo_detalle_delete(msg) {
        if ($(this).data('id') != 1) {
            $("#modaleliminar").modal("show");
            $('#ideliminar').html($(this).data('id'));
        }else{
            mostrar_mensaje("#divmsgindex",'No puedes elimiar Rol',"alert-warning",null);
        }
    }
    
    function metodo_eliminar(){
        $.ajax({
            method: "POST",
            url: "/rol/delete/"+$('#ideliminar').text()+'',
            data: {
                '_token': $('input[name=_token]').val()
                }
        }).done(function (msg) {
            listtabla.ajax.reload(null,false); 
            mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modaleliminar");
        }).fail(function (jqXHR, textStatus){
            mostrar_mensaje("#divmsgindex",'Error al eliminar.', "alert-danger",null);
        });       
    }

    $('#slug').keypress(function (event) {
        if (event.charCode == 32){
            return false;
        }
    });
});
