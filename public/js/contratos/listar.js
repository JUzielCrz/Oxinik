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
                    '<th class="text-center"># CONTRATO</th>'+
                    '<th class="text-center">CLIENTE</th>'+
                    '<th class="text-center">TIPO</th>'+
                    '<th class="text-center">DIRECCION</th>'+
                    '<th class="text-center"></th>'+
                '</tr>'+
                '</thead>'+
            '</table>'
        );
        $("#titulo-tabla").replaceWith('<h5 id="titulo-tabla"> CONTRATOS -> '+$('#tipo_contrato option:selected').text()+' '+$('#estatus').val()+'S</h5>');

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
                url : '/contrato/listar/data',
                type: "post",
                data: 
                    {
                    '_token': $('input[name=_token]').val(),
                    'estatus': $('#estatus').val(),
                    'tipo_contrato': $('#tipo_contrato').val(),
                    }
            },
            columns:[
                {data: 'num_contrato', className: "text-center"},
                {data: 'cliente', className: "text-center"},
                {data: 'tipo_contrato', className: "text-center"},
                {data: 'direccion', className: "text-center"}, //aqui va estatus
                {data: 'btnShow'},
            ]
        });
        
    }


});