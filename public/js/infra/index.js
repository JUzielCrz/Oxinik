$(document).ready(function () {
    'use strict';

    $('#tablecruddata').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        searchDelay: 350,
        order: [[0, 'desc']],
        ajax: '/infra/data',
        language: {
            decimal: '',
            emptyTable: 'No hay registros INFRA todavía.',
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
            infoEmpty: 'Mostrando 0 a 0 de 0 registros',
            infoFiltered: '(filtrado de _MAX_ registros)',
            lengthMenu: 'Mostrar _MENU_ registros',
            loadingRecords: 'Cargando registros...',
            processing: 'Consultando registros...',
            search: 'Buscar:',
            zeroRecords: 'No encontramos notas con esos datos.',
            paginate: {
                first: 'Primero',
                last: 'Último',
                next: 'Siguiente',
                previous: 'Anterior'
            }
        },
        columns: [
            { data: 'id', className: 'text-center font-weight-bold' },
            { data: 'cantidad_salida', className: 'text-center' },
            { data: 'cantidad_entrada', className: 'text-center', render: function (data) { return data === null ? '—' : data; } },
            {
                data: 'mostrar_diferencia',
                className: 'text-center',
                render: function (data) {
                    var diferencia = parseInt(data, 10) || 0;
                    return '<span class="' + (diferencia > 0 ? 'infra-difference-positive' : 'infra-difference-zero') + '">' + diferencia + '</span>';
                }
            },
            { data: 'estado', className: 'text-center' },
            { data: 'created_at', className: 'text-center text-nowrap' },
            { data: 'btnEntrada', className: 'text-center' },
            { data: 'btnShow', className: 'text-center' },
            { data: 'btnPDF', className: 'text-center' }
        ],
        drawCallback: function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
        initComplete: function () {
            $('#tablecruddata_filter input')
                .attr('placeholder', 'ID, fecha o estado...')
                .attr('aria-label', 'Buscar registros INFRA');
        }
    });

    $(document).on('click', '.btn-show', function () {
        window.location = '/infra/show/' + $(this).data('id');
    });
});
