@extends('layouts.sidebar')

@include('infra.partials.infra_styles')

@section('menu-navbar')
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')
@php
    $cantidadDiferenciaInicial = is_null($nota->cantidad_entrada)
        ? $nota->cantidad_salida
        : (int) $nota->cantidad_diferencia;
@endphp
<main class="container-fluid infra-page" aria-labelledby="infra-entrada-title">
    @include('infra.partials.workflow_header', [
        'title' => 'Entrada de tanques INFRA',
        'subtitle' => 'Registra los cilindros que regresaron y cierra la nota de salida.',
        'steps' => ['Ver salida', 'Registrar entradas', 'Cerrar nota'],
        'activeStep' => 2,
        'context' => 'Nota INFRA #' . $nota->id,
    ])

    <form id="formCreateInfra" novalidate>
        @csrf
        <input type="hidden" name="nota_id" value="{{ $nota->id }}">

        <div class="row mb-3">
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="infra-metric">
                    <span class="infra-metric-label">Cilindros enviados</span>
                    <span id="cantidad_salida_h" class="infra-metric-value">{{ $nota->cantidad_salida }}</span>
                </div>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="infra-metric">
                    <span class="infra-metric-label">Cilindros recibidos</span>
                    <span id="cantidad_entrada_h" class="infra-metric-value">{{ $nota->cantidad_entrada ?: 0 }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div id="infra-difference-metric" class="infra-metric {{ $nota->cantidad_diferencia > 0 ? 'infra-metric-danger' : '' }}">
                    <span class="infra-metric-label">Pendientes por recibir</span>
                    <span id="cantidad_diferencia_h" class="infra-metric-value">{{ $cantidadDiferenciaInicial }}</span>
                </div>
            </div>
        </div>

        <input type="hidden" id="cantidad_salida" name="cantidad_salida" value="{{ $nota->cantidad_salida }}">
        <input type="hidden" id="cantidad_entrada" name="cantidad_entrada" value="{{ $nota->cantidad_entrada ?: 0 }}">
        <input type="hidden" id="cantidad_diferencia" name="cantidad_diferencia" value="{{ $cantidadDiferenciaInicial }}">

        <div class="row">
            <div class="col-lg-8 mb-3">
                <section class="card infra-capture-card h-100" aria-labelledby="infra-entrada-title">
                    <div class="card-header">
                        <h2 id="infra-entrada-title" class="h6 mb-1">1. Registra los cilindros recibidos</h2>
                        <p class="infra-instruction">Agrega únicamente los números de serie que regresaron de INFRA.</p>
                    </div>
                    <div class="card-body">
                        <label class="infra-capture-label" for="serie_tanque">Número de serie del cilindro</label>
                        <div class="input-group">
                            <input type="text" name="serie_tanque" id="serie_tanque" class="form-control infra-capture-input" placeholder="Escribe o escanea el número de serie" autocomplete="off" autocapitalize="characters" aria-describedby="serie_tanque_help serie_tanqueError">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-amarillo px-3" id="btn-InsertFila">
                                    <span class="fas fa-plus" aria-hidden="true"></span> Agregar
                                </button>
                            </div>
                        </div>
                        <small id="serie_tanque_help" class="infra-capture-help">Presiona Enter o selecciona Agregar para validar el cilindro.</small>
                        <div id="serie_tanqueError" class="invalid-feedback d-block" role="alert" aria-live="polite"></div>

                        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                            <h3 class="h6 mb-0">Cilindros recibidos</h3>
                            <button type="button" class="btn btn-link btn-sm text-danger p-0" id="btn-clear-list" disabled>
                                <span class="fas fa-eraser" aria-hidden="true"></span> Limpiar lista
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table infra-table table-hover" aria-describedby="entry-count-caption">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">SERIE</th>
                                        <th scope="col">CAPACIDAD</th>
                                        <th scope="col">MATERIAL</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">FABRICANTE</th>
                                        <th scope="col"><span class="sr-only">Acciones</span></th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyfilaTanques">
                                    @forelse ($tanques as $tanque)
                                        <tr class="trFilaTanque">
                                            <td class="infra-row-number">{{ $loop->iteration }}</td>
                                            <td>
                                                <span>{{ $tanque->num_serie }}</span>
                                                <input type="hidden" name="inputNumSerie[]" class="input-num-serie" value="{{ $tanque->num_serie }}">
                                                <input type="hidden" name="inputEstatus[]" class="input-estatus" value="LLENO-ALMACEN">
                                            </td>
                                            <td>{{ $tanque->capacidad }}</td>
                                            <td>{{ $tanque->material }}</td>
                                            <td>{{ $tanque->ph }}</td>
                                            <td>{{ $tanque->fabricante }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-naranja btn-eliminar-fila" title="Eliminar cilindro de la lista" aria-label="Eliminar cilindro de la lista">
                                                    <span class="fas fa-trash" aria-hidden="true"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        @include('infra.partials.empty_state', [
                                            'colspan' => 7,
                                            'icon' => 'fa-warehouse',
                                            'title' => 'Aún no hay entradas registradas',
                                            'message' => 'Captura un número de serie para comenzar.',
                                        ])
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-lg-4 mb-3">
                <aside class="card infra-summary-card infra-sticky" aria-labelledby="infra-entry-summary-title">
                    <div class="card-header">
                        <h2 id="infra-entry-summary-title" class="h6 mb-0">2. Revisa y cierra la nota</h2>
                    </div>
                    <div class="card-body">
                        <div class="infra-counter mb-3">
                            <span class="infra-counter-label">Cilindros recibidos</span>
                            <span id="entry-counter" class="infra-counter-value">{{ $nota->cantidad_entrada ?: 0 }}</span>
                            <span id="entry-count-caption" class="infra-counter-caption">de {{ $nota->cantidad_salida }} enviados</span>
                        </div>

                        <div id="infra-error-panel" class="infra-error-panel mb-3 d-none">
                            <div class="p-2 text-danger small font-weight-bold">
                                <span class="fas fa-exclamation-triangle" aria-hidden="true"></span> Revisar incidencias
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead><tr><th>SERIE</th><th>DETALLE</th></tr></thead>
                                    <tbody id="tbody_errores"></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="infra-note mb-3">
                            <span class="fas fa-info-circle mr-1" aria-hidden="true"></span>
                            Si faltan cilindros, marca la nota como pendiente y explica la situación en observaciones.
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input class="custom-control-input" type="checkbox" id="pendiente" value="0" name="pendiente" @if ($nota->pendiente == false) checked @endif>
                            <label class="custom-control-label" for="pendiente">Confirmo que no quedan cilindros pendientes</label>
                            <small id="pending-help" class="form-text text-muted">Si no está marcada, la nota quedará pendiente.</small>
                        </div>

                        <label for="observaciones" class="infra-capture-label">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="form-control form-control-sm" placeholder="Describe faltantes, retenciones o mantenimiento">{{ $nota->observaciones }}</textarea>
                        <div id="observacionesError" class="invalid-feedback d-block"></div>

                        <div class="infra-actions mt-4">
                            <button type="button" id="btn-save" class="btn btn-amarillo" disabled>
                                <span class="fas fa-arrow-right" aria-hidden="true"></span> Revisar y cerrar
                            </button>
                        </div>
                        <a href="#modal-registrar-tanque" data-toggle="modal" class="infra-register-link d-inline-block mt-3">
                            <span class="fas fa-plus-circle" aria-hidden="true"></span> ¿El cilindro no está registrado? Darlo de alta
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </form>
</main>

<div class="modal fade" id="modal-registrar-tanque" tabindex="-1" role="dialog" aria-labelledby="modalinsertarTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
                <h4 class="modal-title" id="modalinsertarTitle">Registrar tanque</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true" class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                <div id="idFormTanque">
                    @include('tanques.create', ['embedded' => true])
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-amarillo" id="btn-registrar-tanque">Aceptar</button>
                    <button type="button" class="btn btn-light ml-2" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('infra.partials.confirm_modal')
@endsection

@include('layouts.scripts')
<script src="{{ asset('js/infra/common.js') }}"></script>
<script src="{{ asset('js/infra/entrada.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#id-menu-index').addClass('active');
    });
</script>
