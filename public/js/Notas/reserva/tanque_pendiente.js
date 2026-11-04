$(document).ready(function () {

    // Data Tables
    var listtabla = $('#tablecruddata').DataTable({
        language: {"url": "/js/language_dt_spanish.json"},
        processing: true,
        serverSide: false,
        ajax: '/nota/reserva/tanques_data',
        columns:[
            {data: 'num_serie'},   
            {data: 'estatus'}, 
            {data: 'incidencia', render: function (data) {
                var clase = data === 'SALIDA' ? 'notas-status--salida' : 'notas-status--entrada';
                return '<span class="notas-status '+clase+'">'+(data || 'Sin dato')+'</span>';
            }},
            { data: null, render: function ( data, type, row ) {
                // Combinar campos
                return data.tipo_tanque+', '+data.gas+', PH: '+data.ph+', '+data.capacidad+', '+data.material+', '+data.fabricante;
            } }, 
            {data: 'driver'},
            {data: 'car'},
            {data: 'nota_id'},
            {data: 'fecha'},
            {data: 'buttons'},
        ]
    });

    $(document).on("change", "#filtro-pendientes-incidencia", function () {
        listtabla.column(2).search(this.value).draw();
    });
    $(document).on("click", "#btn-limpiar-pendientes", function () {
        $("#filtro-pendientes-incidencia").val("");
        listtabla.search("").columns().search("").draw();
    });
    $(document).on("click", "#refresh-table", function () {
        listtabla.ajax.reload(null, false);
    });
});
