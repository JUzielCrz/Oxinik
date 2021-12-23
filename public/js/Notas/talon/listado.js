$(document).ready(function () {

    $(document).on("click","#btn-estatus", estatus);
    estatus();

    var listtabla='';
    function estatus() {
        $("#insert-table").empty();
        $("#insert-table").append(
            '<table id="tablecruddata" class="table table-sm" style="font-size: 13px">'+
                '<thead>'+
                    '<tr>'+
                        '<th scope="col">#ID</th>'+
                        '<th scope="col">Nombre</th>'+
                        '<th scope="col">Fecha</th>'+
                        '<th scope="col">Total</th>'+
                        '<th scope="col">Pendiente</th>'+
                        '<th scope="col">Telefono</th>'+
                        '<th scope="col">Usuario</th>'+
                        '<th scope="col"></th>'+
                        '<th scope="col"></th>'+
                    '</tr>'+
                '</thead>'+
            '</table>'
        );
        $("#titulo-tabla").replaceWith('<h5 id="titulo-tabla"> TALONES '+$("#estatus option:selected").text()+'</h5>');

        listtabla = $('#tablecruddata').DataTable({
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
            ajax:{
                url : '/nota/talon/data',
                type: "post",
                data: 
                    {
                    '_token': $('input[name=_token]').val(),
                    'estatus': $('#estatus').val(),
                    }
            },
            columns:[
                {data: 'id'},   
                {data: 'nombre'},
                {data: 'fecha'},
                {data: 'total'},
                {data: 'pendiente'},
                {data: 'telefono'},
                {data: 'user_name'},
                {data: 'btnPDF'},
                {data: 'btnEdit'},
            ]
        });
    }
    // Data Tables
    

    
});
