$(document).ready(function () {

    $('#table-estatus-1').on('click','tr', function(evt){
        var estatus=$(this).find("td")[0].innerHTML;
        listtanques(estatus);
    }); 

    $('#table-estatus-2').on('click','tr', function(evt){
        var estatus=$(this).find("td")[0].innerHTML;
        listtanques(estatus);
    }); 

    function listtanques(estatus){
        $("#titulo-table").replaceWith("<h5 id='titulo-table'>"+estatus+"</h5>")
        $("#card-contenido").empty();
        

        $("#card-contenido").append(
            '<div class="table-responsive">'+
                '<table class="table table-hover table-sm" id="table-data" style="font-size: 13px">'+
                "<thead><tr>"+
                "<th>#Serie</th>"+
                        "<th>PH</th>"+
                        "<th>Capacidad</th>"+
                        "<th>Material</th>"+
                        "<th>Fabricante</th>"+
                        "<th>Gas</th>"+
                        "<th>Tipo</th>"+
                        "<th>Estatus</th>"+
            "</tr></thead>"+
                '</table>'+
            '</div>'
        );
        $('#table-data').DataTable({
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
            ajax: '/tanque/estatus/data/'+estatus,
            columns:[
                {data: 'num_serie'},
                {data: 'ph'},
                {data: 'capacidad'},
                {data: 'material'},
                {data: 'fabricante'},
                {data: 'tipo_gas'},
                {data: 'tipo_tanque'},
                {data: 'estatus'},
            ]
        });
    }




});
