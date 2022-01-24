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
            ajax: '/tanque/lista_bajas/data',
            columns:[
                {data: 'num_serie'},
                {data: 'ph'},
                {data: 'fabricante'},
                {data: 'estatus'}, //aqui va estatus
                {data: 'btnHistory'},
                {data: 'btnRestablecer'},
                {data: 'btnDelete'},
            ]
        });
    
    // CRUD
    $(document).on("click",".btn-restore", restore_cilindro);
    $(document).on("click",".btn-delete", delete_cilindro);
    
    
    
    function restore_cilindro() {

        Swal.fire({
            title: 'Estas seguro?',
            text: "Este cilindro se restaurara",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Restaurar cilindro'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "GET",
                    url: "/tanque/restablecer/"+$(this).data('id'),

                }).done(function (msg) {
                    
                    if(msg.mensaje == 'Sin permisos'){
                        mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
                        return false;
                    }
                    listtabla.ajax.reload(null,false); 
                    Swal.fire(
                        'Exito!',
                        'Restaurado correctamente',
                        'success'
                    )
                }).fail(function (jqXHR, textStatus){
                    Swal.fire(
                        'Error!',
                        'Verifique sus datos',
                        'error'
                    )
                });  
            }
        })

    }

    function delete_cilindro() {
        Swal.fire({
            title: 'Estas seguro?',
            text: "Se eliminara permanetemente de la base de datos junto con su historial",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Eliminar permanentemente'
        }).then((result) => {
            $.ajax({
                method: "GET",
                url: "/tanque/destroy/"+$(this).data('id')+'',

            }).done(function (msg) {
                if(msg.mensaje == 'Sin permisos'){
                    mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
                    return false;
                }
                listtabla.ajax.reload(null,false); 
                Swal.fire(
                    'Exito!',
                    'Restaurado correctamente',
                    'success'
                )
            }).fail(function (jqXHR, textStatus){
                Swal.fire(
                    'Error!',
                    'Verifique sus datos',
                    'error'
                )
            });
        })

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

});
