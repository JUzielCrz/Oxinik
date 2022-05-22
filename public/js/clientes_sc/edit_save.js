$(document).ready(function () {
    //Editar Cliente
    $(document).on("click","#btn-editar-cliente", editar_show);
    $(document).on("click","#btn-cliente-edit-save", editar_save);

        //BUSCAR CLIENTE Y RELLENAR CAMPOS SHOW
        $('#search_cliente').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                    method: "POST",
                    url:"/clientes_sc/search",
                    data:{'query':query,'_token': $('input[name=_token]').val(),},
                    success:function(data){
                        $('#listarclientes').fadeIn();  
                        $('#listarclientes').html(data);
                    }
                });
            }
        });
    
        $(document).on('click', 'li', function(){  
            $('#listarclientes').fadeOut();  
            const clientes_sc = $(this).text().split(', ');
            show_datos(clientes_sc[0]);
            $("#search_cliente").val("");
        }); 

        function show_datos(id) {
            $.ajax({
                method: "get",
                url: "/clientes_sc/show/"+id,
                data: {'_token': $('input[name=_token]').val(),},
            })
            .done(function(msg) {
                $.each(msg, function(index, value){
                    $("#"+index+"_show").val(value);
                });
            })
        }

        
    //crear Cliente
    $(document).on("click","#btn-cliente-create-save", create_save);
    //CREATE CLIENTE
    function create_save() {
        $.ajax({
            method: "POST",
            url: "/clientes_sc/create",
            data: {
                '_token': $('input[name=_token]').val(),
                'tipo_persona': $('#tipo_persona').val(),
                'nombre': $('#nombre').val(),
                'apPaterno': $('#apPaterno').val(),
                'apMaterno': $('#apMaterno').val(),
                'telefono': $('#telefono').val(),
                'email': $('#email').val(),
                'direccion': $('#direccion').val(),
                'cfdi': $('#cfdi').val(),
                'rfc': $('#rfc').val(),
                'direccion_factura': $('#direccion_factura').val(),
                'direccion_envio': $('#direccion_envio').val(),
                'referencia_envio': $('#referencia_envio').val(),
                'link_ubicacion_envio': $('#link_ubicacion_envio').val(),
                'precio_envio': $('#precio_envio').val(),
                }
        })
        .done(function (msg) {
            show_datos(msg.cliente_id);
            mensaje_modal('success','Exito', "Guardado Correctamente", 1500,'#modal-create-cliente');
            limpiar_cliente_sc();
        })
        .fail(function (jqXHR, textStatus) {
            
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key ;
                    $(idError).addClass('is-invalid');
                });
            }

            mensaje_modal("error","Error", "Error al actualizar, verifique sus datos.", null, null);
        });
    }

    function limpiar_cliente_sc(){
        $('#tipo_persona').val("");
        $('#nombre').val("");
        $('#apPaterno').val("");
        $('#apMaterno').val("");
        $('#telefono').val("");
        $('#email').val("");
        $('#direccion').val("");
        $('#cfdi').val("");
        $('#rfc').val("");
        $('#direccion_factura').val("");
        $('#direccion_envio').val("");
        $('#referencia_envio').val("");
        $('#link_ubicacion_envio').val("");
        $('#precio_envio').val("");
    }
    //EDITAR CLIENTE
    function editar_show() {
        $.get('/clientes_sc/show/' + $("#id_show").val(), function(data) {
            $.each(data, function (key, value) {
                var variable = "#" + key + "_edit";
                $(variable).val(value);
                
            });
            $("#nombre_edit").removeClass("is-invalid");
            $("#apPaterno_edit").removeClass("is-invalid");
            $("#apMaterno_edit").removeClass("is-invalid");

            const nombre_separado = data.nombre.split(' ');
            $("#nombre_edit").val(nombre_separado[0]);
            $("#apPaterno_edit").val(nombre_separado[1]);
            $("#apMaterno_edit").val(nombre_separado[2]);
            $("#modalmostrar").modal("show");
        })
        
    }
    function editar_save() {
        $.ajax({
            method: "POST",
            url: "/clientes_sc/update",
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#id_edit').val(),
                'tipo_persona': $('#tipo_persona_edit').val(),
                'nombre': $('#nombre_edit').val(),
                'telefono': $('#telefono_edit').val(),
                'email': $('#email_edit').val(),
                'direccion': $('#direccion_edit').val(),
                'cfdi': $('#cfdi_edit').val(),
                'rfc': $('#rfc_edit').val(),
                'direccion_factura': $('#direccion_factura_edit').val(),
                'direccion_envio': $('#direccion_envio_edit').val(),
                'referencia_envio': $('#referencia_envio_edit').val(),
                'link_ubicacion_envio': $('#link_ubicacion_envio_edit').val(),
                'precio_envio': $('#precio_envio_edit').val(),
                }
        })
        .done(function (msg) {
            show_datos(msg.cliente_id);
            mensaje_modal('success','Exito', "Guardado Correctamente", 1500,'#modal-editar-cliente')
        })
        .fail(function (jqXHR, textStatus) {
            
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key ;
                    $(idError).addClass('is-invalid');
                });
            }

            mensaje_modal("error","Error", "Error al actualizar, verifique sus datos.", null, null);
        });
    }
});
    
function mensaje_modal(icono,titulo, mensaje, timer, modal){
    $(modal).modal("hide");
    Swal.fire({
        icon: icono,
        title: titulo,
        text: mensaje,
        timer: timer,
        width: 300,
    })
}