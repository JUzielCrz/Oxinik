$(document).ready(function () {
    'use strict';

    var seriesPendientes = {};
    var guardadoEnProceso = false;

    $('#btn-InsertFila').on('click', insertarFila);
    $('#btn-save').on('click', abrirConfirmacion);
    $('#btn-confirm-operation').on('click', guardarRegistros);
    $('#btn-clear-list').on('click', confirmarLimpieza);
    $('#btn-registrar-tanque').on('click', validarTanque);
    $('#infra-confirm-modal').on('hidden.bs.modal', function () {
        if (!guardadoEnProceso) {
            actualizarPaso(2);
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
        actualizarVista(true);
    });

    $('#fabricanteoficial').on('change', function () {
        var esOtro = $(this).val() === 'Otros';
        $('#otrofabricante').prop('disabled', !esOtro);
        if (!esOtro) {
            $('#otrofabricante').val('');
        }
    });

    $('#unidadmedida').on('change', function () {
        var esCarga = $(this).val() === 'Carga';
        if (esCarga) {
            $('#capacidadnum').val(1).prop('disabled', true);
        } else {
            $('#capacidadnum').prop('disabled', false);
        }
    });

    function obtenerSeriesSeleccionadas() {
        return $('.input-num-serie').map(function () {
            return $(this).val();
        }).get();
    }

    function normalizarSerie(valor) {
        return $.trim(valor || '').replace(/\s+/g, '').toUpperCase();
    }

    function actualizarVista(marcarCambios) {
        var totalEntradas = obtenerSeriesSeleccionadas().length;
        var totalSalida = parseInt($('#cantidad_salida').val(), 10) || 0;
        var diferencia = Math.max(totalSalida - totalEntradas, 0);
        var tieneErrores = $('#tbody_errores tr').length > 0;

        $('#entry-counter, #cantidad_entrada_h').text(totalEntradas);
        $('#cantidad_entrada').val(totalEntradas);
        $('#cantidad_diferencia_h').text(diferencia);
        $('#cantidad_diferencia').val(diferencia);
        $('#entry-count-caption').text('de ' + totalSalida + ' enviados');
        $('#btn-save').prop('disabled', totalEntradas === 0);
        $('#btn-clear-list').prop('disabled', totalEntradas === 0 && !tieneErrores);
        $('#infra-error-panel').toggleClass('d-none', !tieneErrores);
        $('#tbodyfilaTanques .infra-empty-row').toggleClass('d-none', totalEntradas > 0);
        $('#infra-difference-metric').toggleClass('infra-metric-danger', diferencia > 0);
        $('#pending-help').text(diferencia > 0 ? 'Si no está marcada, la nota quedará pendiente por los cilindros faltantes.' : 'Todos los cilindros enviados están registrados.');

        if (marcarCambios) {
            window.infraSetUnsavedChanges(true);
        }
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
        $('#infra-error-panel').removeClass('d-none');
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

                if (tanque.estatus !== 'INFRA') {
                    mostrarError('El tanque no está disponible para registrar su entrada.');
                    registrarError(serie, 'Estatus: ' + tanque.estatus);
                    return;
                }

                agregarTanque(tanque, 'LLENO-ALMACEN');
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

    function agregarTanque(tanque, estatus) {
        var $row = $('<tr>', { class: 'trFilaTanque' });
        var $serieCell = $('<td>');

        $('<span>').text(tanque.num_serie).appendTo($serieCell);
        $('<input>', {
            type: 'hidden',
            name: 'inputNumSerie[]',
            class: 'input-num-serie',
            value: tanque.num_serie
        }).appendTo($serieCell);
        $('<input>', {
            type: 'hidden',
            name: 'inputEstatus[]',
            class: 'input-estatus',
            value: estatus || 'LLENO-ALMACEN'
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
        actualizarVista(true);
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
            text: 'Se eliminarán todos los cilindros de la captura.',
            showCancelButton: true,
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Sí, limpiar',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.isConfirmed) {
                $('#tbodyfilaTanques .trFilaTanque').remove();
                $('#tbody_errores').empty();
                actualizarVista(true);
                $('#serie_tanque').focus();
            }
        });
    }

    function abrirConfirmacion() {
        var series = obtenerSeriesSeleccionadas();

        if (series.length === 0 || Object.keys(seriesPendientes).length > 0) {
            mensaje('warning', 'Aún no puedes continuar', Object.keys(seriesPendientes).length > 0 ? 'Espera a que termine la validación de los números de serie.' : 'Agrega al menos un cilindro recibido.', null);
            return;
        }

        actualizarPaso(3);
        $('#infra-confirm-description').text('Confirma que la entrada de los cilindros fue revisada y que la nota puede cerrarse.');

        var $list = $('<ul>', { class: 'list-group list-group-flush' });
        $.each(series, function (index, serie) {
            $('<li>', { class: 'list-group-item d-flex justify-content-between align-items-center px-0' })
                .append($('<span>').text(serie))
                .append($('<span>', { class: 'badge badge-success badge-pill' }).text(index + 1))
                .appendTo($list);
        });

        var totalSalida = parseInt($('#cantidad_salida').val(), 10) || 0;
        var diferencia = Math.max(totalSalida - series.length, 0);
        $('#infra-confirm-summary').empty()
            .append($('<div>', { class: 'alert ' + (diferencia > 0 ? 'alert-warning' : 'alert-light border') + ' mb-0' })
                .append($('<strong>').text('Recibidos: ' + series.length + ' de ' + totalSalida))
                .append($('<div>').text(diferencia > 0 ? 'Pendientes por recibir: ' + diferencia : 'No hay cilindros pendientes.'))
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
            url: '/infra/entrada_save',
            data: $('#formCreateInfra').serialize() + '&cantidad_entrada=' + series.length
        })
            .done(function (response) {
                if (response.alert !== 'success') {
                    window.infraNavigationLocked = false;
                    mensaje('error', 'No se pudo cerrar la nota', response.mensaje || 'Verifica los datos de la entrada.', null);
                    return;
                }

                window.infraSetUnsavedChanges(false);
                mensaje('success', 'Entrada registrada', response.mensaje || 'La entrada fue registrada correctamente.', 1200);
                setTimeout(function () {
                    window.location = '/infra/index';
                }, 900);
            })
            .fail(function (jqXHR) {
                window.infraNavigationLocked = false;
                var mensajeError = 'Verifica los datos seleccionados.';

                if (jqXHR.status === 422 && jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                    var errores = jqXHR.responseJSON.errors;
                    mensajeError = errores.cantidad_entrada ? errores.cantidad_entrada[0] :
                        (errores.inputNumSerie ? errores.inputNumSerie[0] : mensajeError);
                }

                mensaje('error', 'No se pudo guardar', mensajeError, null);
            })
            .always(function () {
                guardadoEnProceso = false;
                $saveButton.prop('disabled', false).html('<span class="fas fa-check"></span> Confirmar y guardar');
                $('#infra-confirm-modal').modal('hide');
                actualizarPaso(2);
            });
    }

    function validarTanque() {
        var campos = ['num_serie', 'unidadmedida', 'capacidadnum', 'material', 'tipo_tanque', 'estatus', 'ph_anio', 'ph_mes', 'tipo_gas', 'fabricanteoficial'];
        var hayErrores = false;

        $.each(campos, function (_, campo) {
            $('#' + campo + 'Error').empty();
            $('#' + campo).removeClass('is-invalid');
            if (!$('#' + campo).val() || $('#' + campo).val() <= 0) {
                $('#' + campo).addClass('is-invalid');
                $('#' + campo + 'Error').text('Campo obligatorio');
                hayErrores = true;
            }
        });

        var fabricante = $('#fabricanteoficial').val() === 'Otros' ? $('#otrofabricante').val() : $('#fabricanteoficial').val();
        if (!fabricante) {
            $('#fabricanteoficial, #otrofabricante').addClass('is-invalid');
            $('#fabricanteError').text('Especifica el fabricante');
            hayErrores = true;
        }

        if (parseInt($('#ph_anio').val(), 10) < 1950) {
            $('#ph_anio').addClass('is-invalid');
            $('#phError').text('Indica un año válido');
            hayErrores = true;
        }

        if (hayErrores) {
            return;
        }

        var serie = normalizarSerie($('#num_serie').val());
        $.ajax({
            method: 'POST',
            url: '/tanque/create',
            data: {
                _token: $('input[name=_token]').first().val(),
                id: $('#id').val(),
                num_serie: serie,
                ph: $('#ph_anio').val() + '-' + $('#ph_mes').val(),
                capacidad: $('#capacidadnum').val() + ' ' + $('#unidadmedida').val(),
                material: $('#material').val(),
                fabricante: fabricante,
                tipo_gas: $('#tipo_gas').val(),
                estatus: $('#estatus').val(),
                tipo_tanque: $('#tipo_tanque').val()
            }
        })
            .done(function (response) {
                if (response.mensaje === 'Sin permisos') {
                    mensaje('error', 'Sin permisos', 'No tienes permisos para registrar el tanque.', null);
                    return;
                }

                agregarTanque({
                    num_serie: serie,
                    capacidad: $('#capacidadnum').val() + ' ' + $('#unidadmedida').val(),
                    material: $('#material').val(),
                    ph: $('#ph_anio').val() + '-' + $('#ph_mes').val(),
                    fabricante: fabricante
                }, $('#estatus').val());
                $('#modal-registrar-tanque').modal('hide');
                limpiarCamposTanque();
                mensaje('success', 'Tanque registrado', 'El tanque fue agregado a la entrada.', 1200);
            })
            .fail(function (jqXHR) {
                mensaje('error', 'No se pudo registrar', 'Verifica los datos del tanque.', null);
                if (jqXHR.status === 422 && jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        $('#' + key + 'Error').text(value[0]);
                    });
                }
            });
    }

    function limpiarCamposTanque() {
        var $formularioTanque = $('#idFormTanque');
        if ($formularioTanque.is('form')) {
            $formularioTanque[0].reset();
        } else {
            $formularioTanque.find('input, select, textarea').not('[type="hidden"]').val('');
        }
        $('#otrofabricante').prop('disabled', true);
        $formularioTanque.find('.is-invalid').removeClass('is-invalid');
        $formularioTanque.find('.text-danger').empty();
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

    actualizarVista(false);
    window.infraSetUnsavedChanges(false);
});
