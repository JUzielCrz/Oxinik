$(document).ready(function () {

    $(document).on("click",".btn-eliminar-nota", eliminar);
    $(document).on("click", "#btn-aplicar-filtros", aplicarFiltros);
    $(document).on("click", "#btn-limpiar-filtros", limpiarFiltros);

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
        ajax: {
            url: '/nota/foranea/data',
            data: filtros
        },
        columns:[
            // notaf_id es un alias del SELECT; indicar la columna física para
            // que la búsqueda server-side no genere nota_foranea.notaf_id.
            {data: 'notaf_id', name: 'nota_foranea.id'},
            {data: 'nombre', name: 'nota_foranea.nombre'},
            {data: 'telefono', name: 'nota_foranea.telefono'},
            {data: 'fecha', name: 'nota_foranea.fecha'},
            {data: 'total', name: 'nota_foranea.total', className: 'text-right'},
            {data: 'pago_cubierto', name: 'nota_foranea.pago_cubierto', searchable: false},
            {data: 'tanques_devueltos', name: 'nota_foranea.tanques_devueltos', searchable: false},
            {data: 'estado_nota', searchable: false},
            {data: 'user_name', name: 'users.name'},
            {data: 'acciones', searchable: false, orderable: false, className: 'text-center'}
        ],
        drawCallback: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    function filtros(data) {
        data.estado = $('#filtro-estado').val();
        data.pago = $('#filtro-pago').val();
        data.tanques = $('#filtro-tanques').val();
        data.desde = $('#filtro-desde').val();
        data.hasta = $('#filtro-hasta').val();
    }

    function aplicarFiltros() {
        var desde = $('#filtro-desde').val();
        var hasta = $('#filtro-hasta').val();

        if (desde && hasta && desde > hasta) {
            Swal.fire('Rango inválido', 'La fecha inicial no puede ser posterior a la fecha final.', 'warning');
            return;
        }

        actualizarResumenFiltros();
        listtabla.ajax.reload();
    }

    function limpiarFiltros() {
        $('#filtro-estado, #filtro-pago, #filtro-tanques, #filtro-desde, #filtro-hasta').val('');
        actualizarResumenFiltros();
        listtabla.ajax.reload();
    }

    function actualizarResumenFiltros() {
        var filtrosActivos = 0;
        $('#filtro-estado, #filtro-pago, #filtro-tanques, #filtro-desde, #filtro-hasta').each(function () {
            if ($(this).val()) {
                filtrosActivos++;
            }
        });

        $('#resumen-filtros').text(filtrosActivos ? filtrosActivos + ' filtro(s) activo(s)' : 'Mostrando todas las notas');
    }

    actualizarResumenFiltros();

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
