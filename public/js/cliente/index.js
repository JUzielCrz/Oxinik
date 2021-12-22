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
            ajax: '/cliente/data',
            columns:[
                {data: 'id'},
                {data: 'apPaterno'},
                {data: 'apMaterno'},
                {data: 'nombre'},
                {data: 'empresa'},
                {data: 'direccion'},
                {data: 'btnContrato'},
                {data: 'btnShow'},
                {data: 'btnEdit'},
                {data: 'btnDelete'},
            ]
        });
    
    // CRUD

    metodo_limpiar_span("Error");

    // $("input").focusout(function () {
    //     var value = $(this).val();
    //     if (value.length == 0) {
    //         $(this).addClass("is-invalid");
    //     } else {
    //         $(this).removeClass("is-invalid");
    //     }
    // });
    

    $(document).on("click","#btnaccept",metodo_insertar);
    $(document).on("click",".btn-show-modal",metodo_detalle);
    $(document).on("click",".btn-edit-modal",metodo_detalle_edit);
    $(document).on("click","#btnactualizar",metodo_actualizar);
    $(document).on("click",".btn-delete-modal", eliminar);


    $("#tipo-clienteedit").change( function() {
        tipo_cliente('edit');
    });
    $("#tipo-cliente").change( function() {
        tipo_cliente($(this).val(),'');
    });

    function tipo_cliente(valor, edit) {
        console.log(valor+edit);
        $("#empresa-cliente"+edit).empty();
        if (valor == "PERSONA" ) {
            $("#empresa-cliente"+edit).append(
                '<label for="">Nombre: </label>'+
                '<div class="form-row">'+                
                    '<div class="form-group col-md-4">'+
                        '<input type="text" name="apPaterno'+edit+'" id="apPaterno'+edit+'" class="form-control form-control-sm solo-text" placeholder="Apellido">'+
                    '<span  id="apPaterno'+edit+'Error" class="text-danger"></span>'+
                    '</div>'+
                    '<div class="form-group col-md-4">'+
                        '<input type="text" name="apMaterno'+edit+'" id="apMaterno'+edit+'" class="form-control form-control-sm solo-text" placeholder="Apellido">'+
                        '<span  id="apMaterno'+edit+'Error" class="text-danger"></span>'+
                    '</div>'+
                    '<div class="form-group col-md-4">'+
                        '<input type="text" name="nombre'+edit+'" id="nombre'+edit+'" class="form-control form-control-sm solo-text" placeholder="Nombre">'+
                        '<span  id="nombre'+edit+'Error" class="text-danger"></span>'+
                    '</div>'+
                '</div>'
            );
        } 
        if(valor == "EMPRESA"){
            $("#empresa-cliente"+edit).append(
                '<div class="form-row">'+
                    '<div class="form-group col">'+
                        '<label for="">Empresa</label>'+
                        '<input type="text" name="empresa'+edit+'" id="empresa'+edit+'" class="form-control form-control-sm solo-text" placeholder="Empresa">'+
                    '<span  id="empresa'+edit+'Error" class="text-danger"></span>'+
                    '</div>'+
                '</div>'+
                '<label for=""> Representante Legal </label>'+
                '<div class="form-row">'+
                    '<div class="form-group col-md-4">'+
                        
                        '<input type="text" name="apPaterno'+edit+'" id="apPaterno'+edit+'" class="form-control form-control-sm solo-text" placeholder="Ap. paterno">'+
                    '<span  id="apPaterno'+edit+'Error" class="text-danger"></span>'+
                    '</div>'+
                    '<div class="form-group col-md-4">'+
                        '<input type="text" name="apMaterno'+edit+'" id="apMaterno'+edit+'" class="form-control form-control-sm solo-text" placeholder="Ap. Materno">'+
                        '<span  id="apMaterno'+edit+'Error" class="text-danger"></span>'+
                    '</div>'+
                    '<div class="form-group col-md-4">'+
                        '<input type="text" name="nombre'+edit+'" id="nombre'+edit+'" class="form-control form-control-sm solo-text" placeholder="Nombre">'+
                        '<span  id="nombre'+edit+'Error" class="text-danger"></span>'+
                    '</div>'+
                '</div>'
            );
        }
    }
    
    function metodo_insertar() {

        metodo_limpiar_span("Error");

        $.ajax({
            method: "POST",
            url: "/cliente/create",
            data: $("#idFormCliente").serialize(),
        })
            .done(function (msg) {
                if(msg.mensaje == 'Sin permisos'){
                    mensaje("error","Sin permisos", "No tienes los permisos suficientes para realizar esta acción.", null, null);
                    return false;
                }
                metodo_limpiar_campos();
                listtabla.ajax.reload(null,false);      
                mensaje("success","Exito", "Registrado correctamente.", 1800, "#modalinsertar");  
            })
                
            .fail(function (jqXHR, textStatus) {
                mensaje("error","Error", "Error al registrar, verifique sus datos.", null, null);
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
        $("#empresa"+ nombreerror).empty();
        $("#rfc"+ nombreerror).empty();
        $("#email"+ nombreerror).empty();
        $("#telefono"+ nombreerror).empty();
        $("#telefonorespaldo"+ nombreerror).empty();
        $("#direccion"+ nombreerror).empty();
        $("#referencia"+ nombreerror).empty();
        $("#estatus"+ nombreerror).empty();
        $("#tipo-cliente"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos() {
        $("#apPaterno").val("");
        $("#apMaterno").val("");
        $("#nombre").val("");
        $("#empresa").val("");
        $("#rfc").val("");
        $("#email").val("");
        $("#telefono").val("");
        $("#telefonorespaldo").val("");
        $("#direccion").val("");
        $("#referencia").val("");
        $("#estatus").val("");
        $("#tipo-cliente").val("");
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
    
    
    function metodo_detalle() {
        $.get('/cliente/show/' + $(this).data('id') + '', function(data) {
            $.each(data.clientes, function (key, value) {
                var variable = "#" + key + "info";
                $(variable).val(value);
            });
            $("#modalmostrar").modal("show");
        })
        
    }
    
    function metodo_detalle_edit() {
        metodo_limpiar_span("editError");
        $.get('/cliente/show/' + $(this).data('id') + '', function(data) {

            if(data.clientes.empresa != null){
                tipo_cliente('EMPRESA', 'edit');
                $("#tipo-clienteedit").val('EMPRESA');
            }else{
                tipo_cliente('PERSONA', 'edit');
                $("#tipo-clienteedit").val('PERSONA');
            }
            
            $.each(data.clientes, function (key, value) {
                var variable = "#" + key + "edit";
                $(variable).val(value);
            });
            $("#modalactualizar").modal("show");
        })
    }
    
    function metodo_actualizar(){
        metodo_limpiar_span("editError");
        $.ajax({
            method: "POST",
            url: "/cliente/update/"+$('#idedit').val()+'',
            data: {
                '_token': $('input[name=_token]').val(),
                'tipo-cliente': $('#tipo-clienteedit').val(),
                'id': $('#idedit').val(),
                'apPaterno': $('#apPaternoedit').val(),
                'apMaterno': $('#apMaternoedit').val(),
                'nombre': $('#nombreedit').val(),
                'empresa': $('#empresaedit').val(),
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
                if(msg.mensaje == 'Sin permisos'){
                    mensaje("error","Sin permisos", "No tienes los permisos suficientes para realizar esta acción.", null, null);
                    return false;
                }

                listtabla.ajax.reload(null,false); 
                mensaje("success","Exito", "Actualizado correctamente.", 1800, "#modalactualizar");     

            }).fail(function (jqXHR, textStatus) {
                mensaje("error","Error", "Error al actualizar, verifique sus datos.", null, null);
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
    
    function eliminar() {
        Swal.fire({
            title: 'Estas seguro?',
            text: "Se eliminara todo lo que este relacionado a este cliente definitivamente (Contratos, notas, pagos, etc.)",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "get",
                    url: "/cliente/delete/"+$(this).data('id'),
                }).done(function (msg) {
                    if(msg.mensaje == 'Sin permisos'){
                        mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
                        return false;
                    }
                    Swal.fire(
                        'Exito',
                        'Eliminado correctamente.',
                        'success'
                    )
                }).fail(function (){
                    Swal.fire(
                        'Error',
                        'Verifica tus datos',
                        'error'
                    )
                });
            }
        })
    }


    //Para Validar Campos

        $('.telefono').keypress(function (event) {
            if (this.value.length === 10) {
                return false;
            }
        });

        $('.solo-numero').keypress(function (event) {
            // console.log(event.charCode);
            if (
                event.charCode == 43 ||
                event.charCode == 45 || 
                event.charCode == 69 ||
                event.charCode == 101||
                event.charCode == 46    
                ){
                return false;
            } 
            return true;
        });

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
