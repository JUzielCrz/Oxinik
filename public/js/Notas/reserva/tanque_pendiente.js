$(document).ready(function () {

    // Data Tables
    $('#tablecruddata').DataTable({
        language: {"url": "/js/language_dt_spanish.json"},
        processing: true,
        serverSider: true,
        ajax: '/nota/reserva/tanques_data',
        columns:[
            {data: 'num_serie'},   
            {data: 'estatus'}, 
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
});
