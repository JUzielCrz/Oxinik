$(document).ready(function () {

    $(document).on("click",".btn-eliminar-nota", eliminar);

    
    // Data Tables
    var listtabla = $('#tablecruddata').DataTable({
        "ordering": true,
        "order": [[ 0, 'desc' ]],
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
        serverSide: true,
        ajax: '/nota/foranea/data',
        columns:[
            // notaf_id es un alias del SELECT; indicar la columna física para
            // que la búsqueda server-side no genere nota_foranea.notaf_id.
            {data: 'notaf_id', name: 'nota_foranea.id'},
            {data: 'nombre', name: 'nota_foranea.nombre'},
            {data: 'created_at', name: 'nota_foranea.created_at'},
            {data: 'total', name: 'nota_foranea.total'},
            {data: 'telefono', name: 'nota_foranea.telefono'},
            {data: 'pago_cubierto', name: 'nota_foranea.pago_cubierto'},
            {data: 'tanques_devueltos', name: 'nota_foranea.tanques_devueltos'},
            // user_name se calcula desde User::find(), no existe en nota_foranea.
            {data: 'user_name', searchable: false},
            {data: 'btnEdit'},
            {data: 'btnPDF'},
            {data: 'btnDelete'}
        ]
    });

    function eliminar() {
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Se eliminara permanentemente la nota y los estatus de los cilindros cambiaran",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "get",
                    url: "/nota/foranea/delete/"+$(this).data('id'),
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
    }
});
