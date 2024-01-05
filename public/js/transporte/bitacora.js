$(document).ready(function () {

    var listtabla = $('#tablecruddata').DataTable({
        language: {"url": "/js/language_dt_spanish.json"},
        processing: true,
        serverSider: true,
        ajax: '/transporte/bitacora/data/'+bitacora_id.value,
        columns:[
            {data: 'lugar_salida'},
            {data: 'lugar_llegada'},
            {data: 'hora_salida'},
            {data: 'hora_entrada'},
            {data: 'descarga'},
            {data: 'carga'},
            {data: 'total'},
            {data: 'observaciones'},
            {
                data: null, 
                render: function(data, type, row) {
                    return '<button class="btn btn-sm btn-amarillo btnDestroy mx-1" data-id="'+data.id+'"><i class="fas fa-trash"></i></a>';
                }
            },
        ]
    });

    $(document).on("click","#guardar_nota", function (){
        $.ajax({
            method: 'POST',
            url: '/transporte/update/'+bitacora_id.value,
            data: $("#formDatosGenerales").serialize(),
        })
        .done(function (msg) {
            mensaje(msg.type_alert, msg.titulo, "Los datos se guardaron correctamente", "", "#modalCreate");

        }).fail(function (jqXHR, textStatus, errorThrown) {
            var errorMessage = 'Error al procesar la solicitud';
            if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                errorMessage = ''; // Reiniciar el mensaje de error
                var errors = jqXHR.responseJSON.errors;
                $.each(errors, function (key, value) {
                    errorMessage += value + '<br>'; // Puedes modificar el formato según tu necesidad
                });
            }
            // Mostrar el mensaje de error
            mensaje('error', 'ERROR', '', errorMessage, '');
        });
        return false;
    });

    $(document).on("click","#guardar_incidencia", function (){
        $.ajax({
            method: 'POST',
            url: '/transporte/bitacora/create/'+bitacora_id.value,
            data: $("#formIncidencia").serialize(),
        })
        .done(function () {
            listtabla.ajax.reload(null,false);
            limpiar_inputs();
        }).fail(function (jqXHR, textStatus, errorThrown) {
            var errorMessage = 'Error al procesar la solicitud';
            if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                errorMessage = ''; // Reiniciar el mensaje de error
                var errors = jqXHR.responseJSON.errors;
                $.each(errors, function (key, value) {
                    errorMessage += value + '<br>'; // Puedes modificar el formato según tu necesidad
                });
            }
            // Mostrar el mensaje de error
            mensaje('error', 'ERROR', '', errorMessage, '');
        });
        return false;
    });

    function mensaje(icono,titulo, mensaje,mensaje_html, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            html: mensaje_html,
            // timer: 2300,
            width: 300,
        })
    }

    function limpiar_inputs(){
        $("#lugar_salida").val('');
        $("#lugar_llegada").val('');
        $("#hora_salida").val('');
        $("#hora_entrada").val('');
        $("#descarga").val('');
        $("#carga").val('');
        $("#total").val('');
        $("#observaciones").val('');
    }

    $(document).on("click",".btnDestroy", function () {
        Swal.fire({
            title: 'Estas seguro?',
            text: "Se eliminara este registro",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "delete",
                    url: "/transporte/bitacora/destroy/"+$(this).data('id'),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Obtener el token CSRF del meta tag
                    },
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
                    listtabla.ajax.reload(null,false);
                }).fail(function (){
                    Swal.fire(
                        'Error',
                        'Verifica tus datos',
                        'error'
                    )
                });
            }
        })
    });
});