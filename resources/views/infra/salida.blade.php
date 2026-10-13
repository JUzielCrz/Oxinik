@extends('layouts.sidebar')

@include('infra.partials.infra_styles')

@section('menu-navbar')
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')
<main class="container-fluid infra-page" aria-labelledby="infra-salida-title">
    @include('infra.partials.workflow_header', [
        'title' => 'Salida de tanques INFRA',
        'subtitle' => 'Registra los cilindros que serán enviados a INFRA.',
        'steps' => ['Capturar series', 'Revisar lista', 'Confirmar salida'],
        'activeStep' => 1,
        'context' => 'Nueva operación',
    ])

    <form id="formCreateInfra" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-8 mb-3">
                <section class="card infra-capture-card h-100" aria-labelledby="infra-salida-title">
                    <div class="card-header">
                        <h2 id="infra-salida-title" class="h6 mb-1">1. Captura los números de serie</h2>
                        <p class="infra-instruction">Consulta cada cilindro y agrégalo a la lista antes de guardar la salida.</p>
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
                            <h3 class="h6 mb-0">Cilindros listos para salida</h3>
                            <button type="button" class="btn btn-link btn-sm text-danger p-0" id="btn-clear-list" disabled>
                                <span class="fas fa-eraser" aria-hidden="true"></span> Limpiar lista
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table infra-table table-hover" aria-describedby="selected-count-caption">
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
                                    @include('infra.partials.empty_state', [
                                        'colspan' => 7,
                                        'icon' => 'fa-barcode',
                                        'title' => 'Aún no hay cilindros agregados',
                                        'message' => 'Captura un número de serie para comenzar.',
                                    ])
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-lg-4 mb-3">
                <aside class="card infra-summary-card infra-sticky" aria-labelledby="infra-summary-title">
                    <div class="card-header">
                        <h2 id="infra-summary-title" class="h6 mb-0">2. Revisa la operación</h2>
                    </div>
                    <div class="card-body">
                        <div class="infra-counter mb-3">
                            <span class="infra-counter-label">Cilindros seleccionados</span>
                            <span id="contador" class="infra-counter-value">0</span>
                            <span id="selected-count-caption" class="infra-counter-caption">Agrega cilindros para continuar</span>
                        </div>

                        <div id="infra-error-panel" class="infra-error-panel mb-3 d-none">
                            <div class="p-2 text-danger small font-weight-bold">
                                <span class="fas fa-exclamation-triangle" aria-hidden="true"></span> Revisar incidencias
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr><th>SERIE</th><th>DETALLE</th></tr>
                                    </thead>
                                    <tbody id="tbody_errores"></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="infra-summary-item">
                            <span>Estado</span>
                            <strong id="infra-operation-status">Pendiente de captura</strong>
                        </div>
                        <div class="infra-summary-item">
                            <span>Validación</span>
                            <strong id="infra-validation-status">Sin cilindros</strong>
                        </div>

                        <button type="button" id="btn-save" class="btn btn-amarillo btn-block mt-4" disabled>
                            <span class="fas fa-arrow-right" aria-hidden="true"></span> Revisar y confirmar
                        </button>
                    </div>
                </aside>
            </div>
        </div>
    </form>
</main>

@include('infra.partials.confirm_modal')
@endsection

@include('layouts.scripts')
<script src="{{ asset('js/infra/common.js') }}"></script>
<script src="{{ asset('js/infra/salida.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#id-menu-salida').addClass('active');
    });
</script>
