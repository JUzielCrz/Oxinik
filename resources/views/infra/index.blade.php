@extends('layouts.sidebar')

@include('infra.partials.infra_styles')

@section('menu-navbar')
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')
<main class="container-fluid infra-page" aria-labelledby="infra-records-title">
    <div class="card mb-3 infra-context-card">
        <div class="card-header bg-gris text-white">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div>
                    <h1 id="infra-records-title" class="infra-page-title">Control de operaciones INFRA</h1>
                    <p class="infra-page-subtitle">Administra salidas, entradas y diferencias de cilindros desde un solo lugar.</p>
                </div>
                <a href="{{ url('/infra/salida') }}" class="btn btn-amarillo btn-sm mt-2 mt-md-0">
                    <span class="fas fa-plus" aria-hidden="true"></span> Registrar salida
                </a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="d-flex align-items-center text-muted small">
                <span class="fas fa-info-circle text-success mr-2" aria-hidden="true"></span>
                <span>Filtra por estado, fecha, nota o responsable. La diferencia se muestra únicamente después de registrar la entrada.</span>
            </div>
        </div>
    </div>

    <section class="row infra-dashboard-metrics mb-3" aria-label="Resumen de operaciones INFRA">
        <div class="col-6 col-xl mb-2 mb-xl-0">
            <div class="infra-dashboard-metric">
                <span class="infra-dashboard-metric-icon bg-onix"><i class="fas fa-clipboard-list" aria-hidden="true"></i></span>
                <span><small>Total de notas</small><strong id="infra-summary-total">0</strong></span>
            </div>
        </div>
        <div class="col-6 col-xl mb-2 mb-xl-0">
            <div class="infra-dashboard-metric">
                <span class="infra-dashboard-metric-icon bg-warning"><i class="fas fa-clock" aria-hidden="true"></i></span>
                <span><small>Pendientes de entrada</small><strong id="infra-summary-pending">0</strong></span>
            </div>
        </div>
        <div class="col-6 col-xl mb-2 mb-xl-0">
            <div class="infra-dashboard-metric">
                <span class="infra-dashboard-metric-icon bg-danger"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></span>
                <span><small>Con diferencia</small><strong id="infra-summary-difference">0</strong></span>
            </div>
        </div>
        <div class="col-6 col-xl mb-2 mb-xl-0">
            <div class="infra-dashboard-metric">
                <span class="infra-dashboard-metric-icon bg-success"><i class="fas fa-check-circle" aria-hidden="true"></i></span>
                <span><small>Completadas</small><strong id="infra-summary-complete">0</strong></span>
            </div>
        </div>
        <div class="col-12 col-xl mb-2 mb-xl-0">
            <div class="infra-dashboard-metric">
                <span class="infra-dashboard-metric-icon bg-secondary"><i class="fas fa-prescription-bottle" aria-hidden="true"></i></span>
                <span><small>Cilindros pendientes</small><strong id="infra-summary-cylinders">0</strong></span>
            </div>
        </div>
    </section>

    <section class="card infra-filter-card mb-3" aria-labelledby="infra-filters-title">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 id="infra-filters-title" class="h6 mb-1">Filtros de consulta</h2>
                    <small class="text-muted">Reduce el listado para encontrar rápidamente una operación.</small>
                </div>
                <span id="infra-active-filters" class="badge badge-light">Sin filtros</span>
            </div>
        </div>
        <div class="card-body">
            <form id="infra-filter-form" class="row align-items-end">
                <div class="col-12 col-md-3 mb-2">
                    <label for="infra-status" class="small font-weight-bold">Estado</label>
                    <select id="infra-status" class="form-control form-control-sm">
                        <option value="">Todos los estados</option>
                        <option value="pending">Pendiente de entrada</option>
                        <option value="difference">Con diferencia</option>
                        <option value="complete">Completada</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 mb-2">
                    <label for="infra-date-from" class="small font-weight-bold">Desde</label>
                    <input type="date" id="infra-date-from" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-md-2 mb-2">
                    <label for="infra-date-to" class="small font-weight-bold">Hasta</label>
                    <input type="date" id="infra-date-to" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-md-2 mb-2">
                    <label for="infra-note-id" class="small font-weight-bold">ID de nota</label>
                    <input type="number" min="1" id="infra-note-id" class="form-control form-control-sm" placeholder="Ej. 125">
                </div>
                <div class="col-6 col-md-3 mb-2">
                    <label for="infra-user-id" class="small font-weight-bold">Responsable</label>
                    <select id="infra-user-id" class="form-control form-control-sm">
                        <option value="">Todos los responsables</option>
                        @foreach ($responsables as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex flex-wrap align-items-center mt-1">
                    <button type="submit" class="btn btn-verde btn-sm mr-2">
                        <span class="fas fa-filter" aria-hidden="true"></span> Aplicar filtros
                    </button>
                    <button type="button" id="btn-clear-infra-filters" class="btn btn-outline-secondary btn-sm">
                        <span class="fas fa-undo" aria-hidden="true"></span> Limpiar
                    </button>
                    <div class="infra-filter-shortcuts ml-md-auto mt-2 mt-md-0" aria-label="Filtros rápidos">
                        <button type="button" class="btn btn-link btn-sm infra-filter-chip" data-status="">Todas</button>
                        <button type="button" class="btn btn-link btn-sm infra-filter-chip" data-status="pending">Pendientes</button>
                        <button type="button" class="btn btn-link btn-sm infra-filter-chip" data-status="difference">Diferencias</button>
                        <button type="button" class="btn btn-link btn-sm infra-filter-chip" data-status="complete">Completadas</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="card infra-list-card" aria-labelledby="infra-table-title">
        <div class="card-header bg-white text-dark">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 id="infra-table-title" class="h6 mb-0">Historial operativo</h2>
                <small class="text-muted mt-2 mt-md-0">Selecciona una fila para ver su detalle o continuar la entrada.</small>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablecruddata" class="table table-sm table-hover align-middle infra-records-table nowrap" style="font-size: 13px; width: 100%;">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">NOTA</th>
                            <th scope="col">SALIDA</th>
                            <th scope="col">ENTRADA</th>
                            <th scope="col">DIFERENCIA</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">RESPONSABLE</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</main>
@endsection

@include('layouts.scripts')
<script src="{{ asset('js/infra/common.js') }}"></script>
<script src="{{ asset('js/infra/index.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#id-menu-index').addClass('active');
    });
</script>
