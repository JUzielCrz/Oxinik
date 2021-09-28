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
            ajax: '/mantenimiento/data',
            
            columns:[
                {data: 'id', className: "text-center"},
                {data: 'fecha', className: "text-center"},
                {data: 'incidencia', className: "text-center"},
                {data: 'cantidad', className: "text-center"},
                {data: 'btnShow', className: "text-center"},
                // {data: 'btnEdit'},
                // {data: 'btnDelete'},
            ],
        });
    
    // CRUD
    
    $(document).on("click",".btn-show", show);

    
    function show() {
        window.location = "/mantenimiento/show/"+$(this).data('id');
    }


});
