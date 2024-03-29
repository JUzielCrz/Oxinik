$(document).ready(function () {

    var listtabla = $('#tablecruddata').DataTable({
        language: {"url": "js/language_dt_spanish.json"},
        processing: true,
        serverSider: true,
        ajax: '/transporte/filter',
        columns:[
            {data: 'id'},
            {data: 'car'},
            {data: 'driver'},
            {data: 'fecha'},
            {
                data: null, 
                render: function(data, type, row) {
                    return '<a class="btn btn-sm btn-amarillo mx-1" href="/transporte/bitacora/' + data.id + '"><i class="far fa-newspaper"></i></a>'+
                    '<a class="btn btn-sm btn-amarillo mx-1" href="/transporte/bitacora/pdf/' + data.id + '"><i class="fas fa-file-pdf"></i></a>'+
                    '<button class="btn btn-sm btn-amarillo btnDestroy mx-1" data-id="'+data.id+'"><i class="fas fa-trash"></i></a>';
                }
            },
        ]
    });
    
    $(document).on("click","#filtro", function (){
            $.ajax({
                url: '/transporte/filter', // Reemplaza con la ruta correcta
                method: 'GET',
                data: $("#formFilter").serialize(),
                success: function(response) {
                    // Actualiza la tabla con los datos filtrados
                    $('#tablecruddata').DataTable().clear().rows.add(response.data).draw();
                },
                error: function(xhr, status, error) {
                    // Manejo de errores si es necesario
                }
            });
    });

    $(document).on("click","#btn_save", function (){
        if($("#id").val() == "" ){
            save("POST", "transporte")
        }else{
            var link = "transporte/" + $("#id").val()
            save("PUT", link)
        }
    });

    function save(method, link) {
        $.ajax({
            method: method,
            url: link,
            data: $("#form_create").serialize(),
        })
        .done(function (msg) {
            // listtabla.ajax.reload(null,false);
            mensaje(msg.type_alert, msg.alert_type, "Los datos se guardaron correctamente", "", "#modalCreate");
            clean_inputs()
            listtabla.ajax.reload(null,false);
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
    }

    function clean_inputs() {
        $("#fecha").val("");
        $("#car_id").val("");
        $("#driver_id").val("");
    }

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
                    url: "/transporte/destroy/"+$(this).data('id'),
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