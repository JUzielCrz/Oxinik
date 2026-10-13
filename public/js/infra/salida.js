$(document).ready(function () {
    'use strict';

    var seriesPendientes = {};
    var guardadoEnProceso = false;

    $('#btn-InsertFila').on('click', insertarFila);
    $('#btn-save').on('click', abrirConfirmacion);
    $('#btn-confirm-operation').on('click', guardarRegistros);
    $('#btn-clear-list').on('click', confirmarLimpieza);
    $('#infra-confirm-modal').on('hidden.bs.modal', function () {
        if (!guardadoEnProceso) {
            actualizarPaso(obtenerSeriesSeleccionadas().length > 0 ? 2 : 1);
        }
    });

    $('#serie_tanque').on('keydown', function (event) {
        if (event.which === 13) {
            event.preventDefault();
            insertarFila();
        }
    });

    $(document).on('click', '.btn-eliminar-fila', function () {
        $(this).closest('tr').remove();
        actualizarVista();
    });

    function obtenerSeriesSeleccionadas() {
        return $('.input-num-serie').map(function () {
            return $(this).val();
        }).get();
    }

    function normalizarSerie(valor) {
        return $.trim(valor || '').replace(/\s+/g, '').toUpperCase();
    }

    function actualizarVista() {
        var total = obtenerSeriesSeleccionadas().length;
        var tieneErrores = $('#tbody_errores tr').length > 0;

        $('#contador').text(total);
        $('#btn-save').prop('disabled', total === 0);
        $('#btn-clear-list').prop('disabled', total === 0 && !tieneErrores);
        $('#infra-operation-status').text(total > 0 ? 'Lista para revisión' : 'Pendiente de captura');
        $('#infra-validation-status').text(total > 0 ? 'Cilindros validados' : 'Sin cilindros');
        $('#selected-count-caption').text(total === 1 ? '1 cilindro listo' : (total > 1 ? total + ' cilindros listos' : 'Agrega cilindros para continuar'));
        $('#infra-error-panel').toggleClass('d-none', !tieneErrores);
        $('#tbodyfilaTanques .infra-empty-row').toggleClass('d-none', total > 0);
        window.infraSetUnsavedChanges(total > 0);

        actualizarPaso(total > 0 ? 2 : 1);
    }

    function actualizarPaso(pasoActivo) {
        $('.infra-step').each(function (index) {
            var paso = index + 1;
            $(this).toggleClass('active', paso === pasoActivo).toggleClass('complete', paso < pasoActivo);
        });
    }

    function mostrarError(texto) {
        $('#serie_tanqueError').text(texto || '');
    }

    function registrarError(serie, detalle) {
        var $row = $('<tr>');
        $('<td>').text(serie).appendTo($row);
        $('<td>').text(detalle).appendTo($row);
        $('#tbody_errores').append($row);
        actualizarVista();
    }

    function insertarFila() {
        var $input = $('#serie_tanque');
        var serie = normalizarSerie($input.val());

        mostrarError('');

        if (!serie) {
            mostrarError('El número de serie es obligatorio.');
            $input.focus();
            return;
        }

        if (obtenerSeriesSeleccionadas().indexOf(serie) !== -1 || seriesPendientes[serie]) {
            mostrarError('Este número de serie ya está agregado o se está consultando.');
            registrarError(serie, 'Serie repetida');
            $input.val('').focus();
            return;
        }

        seriesPendientes[serie] = true;
        $('#btn-InsertFila').prop('disabled', true).html('<span class="fas fa-spinner fa-spin"></span> Validando...');

        $.get('/tanque/show_numserie/' + encodeURIComponent(serie))
            .done(function (tanque) {
                if (!tanque) {
                    mostrarError('No existe un tanque registrado con ese número de serie.');
                    registrarError(serie, 'Tanque sin registrar');
                    return;
                }

                if (tanque.estatus !== 'VACIO-ALMACEN') {
                    mostrarError('El tanque no está disponible para salida.');
                    registrarError(serie, 'Estatus: ' + tanque.estatus);
                    return;
                }

                agregarTanque(tanque);
                mostrarError('Cilindro validado y agregado correctamente.');
                $input.val('');
            })
            .fail(function () {
                mostrarError('No fue posible consultar el número de serie. Intenta nuevamente.');
                registrarError(serie, 'Error de consulta');
            })
            .always(function () {
                delete seriesPendientes[serie];
                $('#btn-InsertFila').prop('disabled', false).html('<span class="fas fa-plus"></span> Agregar');
                $input.focus();
            });
    }

    function agregarTanque(tanque) {
        var $row = $('<tr>', { class: 'trFilaTanque' });
        var $serieCell = $('<td>');

        $('<span>').text(tanque.num_serie).appendTo($serieCell);
        $('<input>', {
            type: 'hidden',
            name: 'inputNumSerie[]',
            class: 'input-num-serie',
            value: tanque.num_serie
        }).appendTo($serieCell);

        $row.append($('<td>', { class: 'infra-row-number' }));
        $row.append($serieCell);
        $row.append($('<td>').text(tanque.capacidad));
        $row.append($('<td>').text(tanque.material));
        $row.append($('<td>').text(tanque.ph));
        $row.append($('<td>').text(tanque.fabricante));

        var $removeButton = $('<button>', {
            type: 'button',
            class: 'btn btn-sm btn-naranja btn-eliminar-fila',
            title: 'Eliminar cilindro de la lista',
            'aria-label': 'Eliminar cilindro de la lista'
        }).append($('<span>', { class: 'fas fa-trash', 'aria-hidden': 'true' }));

        $row.append($('<td>').append($removeButton));
        $('#tbodyfilaTanques').append($row);
        renumerarFilas();
        actualizarVista();
    }

    function renumerarFilas() {
        $('#tbodyfilaTanques .trFilaTanque').each(function (index) {
            $(this).find('.infra-row-number').text(index + 1);
        });
    }

    function confirmarLimpieza() {
        if (obtenerSeriesSeleccionadas().length === 0 && $('#tbody_errores tr').length === 0) {
            return;
        }

        Swal.fire({
            icon: 'warning',
            title: '¿Limpiar la lista?',
            text: 'Se eliminarán todos los cilindros capturados.',
            showCancelButton: true,
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Sí, limpiar',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.isConfirmed) {
                limpiarCampos();
            }
        });
    }

    function abrirConfirmacion() {
        var series = obtenerSeriesSeleccionadas();

        if (series.length === 0 || Object.keys(seriesPendientes).length > 0) {
            mensaje('warning', 'Aún no puedes continuar', Object.keys(seriesPendientes).length > 0 ? 'Espera a que termine la validación de los números de serie.' : 'Agrega al menos un cilindro a la lista.', null);
            return;
        }

        actualizarPaso(3);
        $('#infra-confirm-description').text('Confirma que los cilindros siguientes serán registrados como salida hacia INFRA.');

        var $list = $('<ul>', { class: 'list-group list-group-flush' });
        $.each(series, function (index, serie) {
            $('<li>', { class: 'list-group-item d-flex justify-content-between align-items-center px-0' })
                .append($('<span>').text(serie))
                .append($('<span>', { class: 'badge badge-success badge-pill' }).text(index + 1))
                .appendTo($list);
        });

        $('#infra-confirm-summary').empty()
            .append($('<div>', { class: 'alert alert-light border mb-0' })
                .append($('<strong>').text('Total: ' + series.length + (series.length === 1 ? ' cilindro' : ' cilindros')))
                .append($list));
        $('#infra-confirm-modal').modal('show');
    }

    function guardarRegistros() {
        var series = obtenerSeriesSeleccionadas();
        var $saveButton = $('#btn-confirm-operation');

        if (guardadoEnProceso || series.length === 0) {
            return;
        }

        guardadoEnProceso = true;
        window.infraNavigationLocked = true;
        $saveButton.prop('disabled', true).html('<span class="fas fa-spinner fa-spin"></span> Guardando...');

        $.ajax({
            method: 'post',
            url: '/infra/salida_save',
            data: $('#formCreateInfra').serialize() + '&cantidad=' + series.length
        })
            .done(function (response) {
                if (!response.notaId) {
                    window.infraNavigationLocked = false;
                    mensaje('error', 'No se pudo guardar', response.mensaje || 'No fue posible registrar la salida.', null);
                    return;
                }

                window.infraSetUnsavedChanges(false);
                limpiarCampos();
                mensaje('success', 'Salida registrada', 'La salida fue registrada correctamente.', 1500);
                window.open('/pdf/infra/nota/' + response.notaId, '_blank');
            })
            .fail(function (jqXHR) {
                window.infraNavigationLocked = false;
                var mensajeError = 'Verifica los datos seleccionados.';

                if (jqXHR.status === 422 && jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                    var errores = jqXHR.responseJSON.errors;
                    mensajeError = errores.cantidad ? errores.cantidad[0] :
                        (errores.inputNumSerie ? errores.inputNumSerie[0] : mensajeError);
                }

                mensaje('error', 'No se pudo guardar', mensajeError, null);
            })
            .always(function () {
                guardadoEnProceso = false;
                $saveButton.prop('disabled', false).html('<span class="fas fa-check"></span> Confirmar y guardar');
                $('#infra-confirm-modal').modal('hide');
                actualizarPaso(obtenerSeriesSeleccionadas().length > 0 ? 2 : 1);
            });
    }

    function limpiarCampos() {
        $('#tbodyfilaTanques .trFilaTanque').remove();
        $('#tbody_errores').empty();
        $('#infra-error-panel').addClass('d-none');
        $('#serie_tanque').val('');
        mostrarError('');
        actualizarVista();
        $('#serie_tanque').focus();
    }

    function mensaje(icono, titulo, texto, timer) {
        Swal.fire({
            icon: icono,
            title: titulo,
            text: texto,
            timer: timer,
            width: 360
        });
    }

    actualizarVista();
});
