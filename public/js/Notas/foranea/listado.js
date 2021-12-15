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
        ajax: '/nota/foranea/data',
        columns:[
            {data: 'notaf_id'},   
            {data: 'nombre'},
            {data: 'fecha'},
            {data: 'total'},
            {data: 'telefono'},
            {data: 'pago_cubierto'},
            {data: 'tanques_devueltos'},
            {data: 'user_name'},
            {data: 'btnEdit'},
            {data: 'btnPDF'},
        ]
    });

    
});
