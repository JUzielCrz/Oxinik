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
            ajax: '/infra/data',
            
            columns:[
                {data: 'id', className: "text-center"},
                {data: 'cantidad_salida', className: "text-center"},
                {data: 'cantidad_entrada', className: "text-center"},
                {data: 'mostrar_diferencia', className: "text-center"},
                {data: 'created_at', className: "text-center"},
                {data: 'btnEntrada', className: "text-center"},
                {data: 'btnShow', className: "text-center"},
                {data: 'btnPDF', className: "text-center"},
                // {data: 'btnEdit'},
                // {data: 'btnDelete'},
            ],
        });
    
    // CRUD
    
    $(document).on("click",".btn-show", show);

    function show() {
        window.location = "/infra/show/"+$(this).data('id');
    }


});
