$(document).ready(function () {

    // Data Tables
    $('#tablecruddata').DataTable({
        language: {"url": "js/language_dt_spanish.json"},
        processing: true,
        serverSider: true,
        ajax: '/nota/reserva/tanques_data',
        columns:[
            {data: 'num_serie'},   
            {data: 'estatus'}, 
            {data: 'tipo_tanque'}, 
        ]
    });


});
