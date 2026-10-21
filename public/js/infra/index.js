$(document).ready(function () {
    'use strict';

    var $filterForm = $('#infra-filter-form');
    var table = $('#tablecruddata').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        scrollX: true,
        searchDelay: 350,
        order: [[0, 'desc']],
        ajax: {
            url: '/infra/data',
            type: 'GET',
            data: function (data) {
                data.status = $('#infra-status').val();
                data.date_from = $('#infra-date-from').val();
                data.date_to = $('#infra-date-to').val();
                data.note_id = $('#infra-note-id').val();
                data.user_id = $('#infra-user-id').val();
            },
            dataSrc: function (response) {
                actualizarResumen(response.summary || {});
                actualizarFiltrosActivos();
                return response.data || [];
            }
        },
        language: {
            decimal: '',
            emptyTable: 'No hay registros INFRA que coincidan con la consulta.',
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
            infoEmpty: 'Mostrando 0 a 0 de 0 registros',
            infoFiltered: '(filtrado de _MAX_ registros)',
            lengthMenu: 'Mostrar _MENU_ registros',
            loadingRecords: 'Cargando registros...',
            processing: 'Consultando operaciones...',
            search: 'Buscar:',
            zeroRecords: 'No encontramos operaciones con esos datos.',
            paginate: {
                first: 'Primero',
                last: 'Último',
                next: 'Siguiente',
                previous: 'Anterior'
            }
        },
        columns: [
            { data: 'id', name: 'infra_llenado.id', className: 'text-center font-weight-bold' },
            { data: 'cantidad_salida', name: 'infra_llenado.cantidad_salida', className: 'text-center' },
            {
                data: 'cantidad_entrada',
                name: 'infra_llenado.cantidad_entrada',
                className: 'text-center',
                render: function (data) {
                    return data === null ? '—' : data;
                }
            },
            {
                data: 'mostrar_diferencia',
                name: 'infra_llenado.cantidad_diferencia',
                className: 'text-center',
                render: function (data) {
                    if (data === null || typeof data === 'undefined') {
                        return '<span class="text-muted">—</span>';
                    }

                    var diferencia = parseInt(data, 10) || 0;
                    return '<span class="' + (diferencia > 0 ? 'infra-difference-positive' : 'infra-difference-zero') + '">' + diferencia + '</span>';
                }
            },
            { data: 'estado', name: 'infra_llenado.cantidad_entrada', className: 'text-center' },
            { data: 'created_at', name: 'infra_llenado.created_at', className: 'text-center text-nowrap' },
            { data: 'responsable', name: 'users.name', defaultContent: '—', className: 'text-left' },
            { data: 'acciones', name: 'infra_llenado.id', orderable: false, searchable: false, className: 'text-center' }
        ],
        drawCallback: function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
        initComplete: function () {
            $('#tablecruddata_filter input')
                .attr('placeholder', 'ID, fecha o responsable...')
                .attr('aria-label', 'Buscar operaciones INFRA');
        }
    });

    $filterForm.on('submit', function (event) {
        event.preventDefault();
        table.ajax.reload(null, true);
    });

    $('.infra-filter-chip').on('click', function () {
        $('#infra-status').val($(this).data('status'));
        table.ajax.reload(null, true);
    });

    $('#btn-clear-infra-filters').on('click', function () {
        $filterForm[0].reset();
        table.search('');
        table.ajax.reload(null, true);
        $('#tablecruddata_filter input').val('');
    });

    $(document).on('click', '.btn-show', function () {
        window.location = '/infra/show/' + $(this).data('id');
    });

    function actualizarResumen(summary) {
        $('#infra-summary-total').text(formatearNumero(summary.total));
        $('#infra-summary-pending').text(formatearNumero(summary.pending));
        $('#infra-summary-difference').text(formatearNumero(summary.difference));
        $('#infra-summary-complete').text(formatearNumero(summary.complete));
        $('#infra-summary-cylinders').text(formatearNumero(summary.pending_cylinders));
    }

    function actualizarFiltrosActivos() {
        var active = 0;

        if ($('#infra-status').val()) {
            active++;
        }
        if ($('#infra-date-from').val()) {
            active++;
        }
        if ($('#infra-date-to').val()) {
            active++;
        }
        if ($('#infra-note-id').val()) {
            active++;
        }
        if ($('#infra-user-id').val()) {
            active++;
        }

        $('#infra-active-filters')
            .text(active ? active + (active === 1 ? ' filtro activo' : ' filtros activos') : 'Sin filtros')
            .toggleClass('badge-success', active > 0)
            .toggleClass('badge-light', active === 0);
    }

    function formatearNumero(value) {
        return new Intl.NumberFormat('es-MX').format(parseInt(value, 10) || 0);
    }
});
