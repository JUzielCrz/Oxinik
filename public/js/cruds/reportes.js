$(document).ready(function () {

    $(document).on("click","#btn-vacio-almacen", function(){ listtanques('VACIO-ALMACEN')});
    $(document).on("click","#btn-lleno-almacen", function(){ listtanques('LLENO-ALMACEN')});
    $(document).on("click","#btn-infra", function(){ listtanques('INFRA')});
    $(document).on("click","#btn-mantenimiento", function(){ listtanques('MANTENIMIENTO')});
    $(document).on("click","#btn-entregado-cliente", function(){ listtanques('ENTREGADO-CLIENTE')});


    function listtanques(estatus){
        $('#filatabla').remove();
        $('#cardtablas').append(
            "<div id='filatabla'>"+
                "<div class='row table-responsive ml-1' >"+ 
                    "<table id='tablecruddata' class='table table-sm table-striped table-hover'>"+
                        "<thead>"+
                            "<tr>"+
                                "<th scope='col'>"+'#Serie'+"</th>"+
                                "<th scope='col'>"+'PH'+"</th>"+
                                "<th scope='col'>"+'Capacidad'+"</th>"+
                                "<th scope='col'>"+'Material'+"</th>"+
                                "<th scope='col'>"+'Fabricante'+"</th>"+
                                "<th scope='col'>"+'Gas'+"</th>"+
                                "<th scope='col'>"+'Estatus'+"</th>"+
                            "</tr>"+
                        "</thead>"+
                    "</table>"+
                "</div>"+
            "</div>"
        );

        $('#tablecruddata').DataTable({
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
            ajax: '/dt_reportelisttanques/'+estatus,
            columns:[
                {data: 'num_serie'},
                {data: 'ph'},
                {data: 'capacidad'},
                {data: 'material'},
                {data: 'fabricante'},
                {data: 'tipo_gas'},
                {data: 'estatus'},
            ]
        });
    }




});
