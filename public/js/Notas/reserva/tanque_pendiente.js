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
        ajax: '/nota/reserva/tanques_data',
        columns:[
            {data: 'num_serie'},   
            {data: 'estatus'}, 
            {data: 'nota_id'},
            {data: 'created_at'},
            {data: 'incidencia'},
            {data: 'btnShow'},
            
        ]
    });

    $(document).on("click",".btn-show", nota_show);


    function nota_show() {
        $("#tbody-reserva-show").empty();
        $.get('/nota/reserva/show/' + $(this).data('id'), function(msg) { 
            $("#modal-show").modal("show");
            $("#nota_id").replaceWith("<h5 id='nota_id'>Nota id: "+msg.nota.id+"</h5>");
            $("#span-incidencia").replaceWith('<span id="span-incidencia">Incidencia: '+msg.nota.incidencia+'</span>');
            $.each(msg.tanques, function (key, value) {
                $("#tbody-reserva-show").append(
                    "<tr><td>"+value.num_serie+"</td><td>"+value.tipo_gas+", "+value.capacidad+", "+value.material+", "+value.fabricante+", "+value.nombre+", "+value.tipo_tanque+", PH: "+value.ph +"</td></tr>"
                );
            });
        });
    }


});
