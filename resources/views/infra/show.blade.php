@extends('layouts.sidebar')

@include('infra.partials.infra_styles')

@section('menu-navbar')
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')
@inject('tipoeva', 'App\Http\Controllers\CatalogoGasController')
@php
    $salidas = $tanques->where('incidencia', 'SALIDA');
    $entradas = $tanques->where('incidencia', 'ENTRADA');
@endphp

<main class="container-fluid infra-page" aria-labelledby="infra-detail-title">
    <div class="card mb-3 infra-context-card">
        <div class="card-header bg-gris text-white">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div>
                    <h1 id="infra-detail-title" class="infra-page-title">Detalle de nota INFRA #{{ $infranota->id }}</h1>
                    <p class="infra-page-subtitle">Consulta los cilindros enviados, recibidos y las diferencias de la operación.</p>
                </div>
                @if ($infranota->cantidad_entrada === null)
                    <span class="infra-status infra-status-pending mt-1">Pendiente de entrada</span>
                @elseif ($infranota->pendiente && $infranota->cantidad_diferencia > 0)
                    <span class="infra-status infra-status-difference mt-1">Con diferencia</span>
                @else
                    <span class="infra-status infra-status-complete mt-1">Completada</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row small text-muted">
                <div class="col-md-4 mb-2 mb-md-0"><strong>Responsable:</strong> {{ optional($usuario)->name ?: 'No disponible' }}</div>
                <div class="col-md-4 mb-2 mb-md-0"><strong>Fecha:</strong> {{ $infranota->created_at ? $infranota->created_at->format('d/m/Y H:i') : 'No disponible' }}</div>
                <div class="col-md-4"><strong>Observaciones:</strong> {{ $infranota->observaciones ?: 'Sin observaciones' }}</div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 mb-2 mb-md-0"><div class="infra-metric"><span class="infra-metric-label">Salida</span><span class="infra-metric-value">{{ $infranota->cantidad_salida }}</span></div></div>
        <div class="col-md-4 mb-2 mb-md-0"><div class="infra-metric"><span class="infra-metric-label">Entrada</span><span class="infra-metric-value">{{ $infranota->cantidad_entrada ?: 0 }}</span></div></div>
        <div class="col-md-4"><div class="infra-metric {{ $infranota->cantidad_diferencia > 0 ? 'infra-metric-danger' : '' }}"><span class="infra-metric-label">Pendientes</span><span class="infra-metric-value">{{ $infranota->pendiente ? $infranota->cantidad_diferencia : 0 }}</span></div></div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-3">
            <section class="card h-100" aria-labelledby="infra-output-title">
                <div class="card-header bg-white text-dark d-flex justify-content-between align-items-center">
                    <h2 id="infra-output-title" class="h6 mb-0">Cilindros enviados</h2>
                    <span class="badge badge-secondary">{{ $salidas->count() }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table infra-table table-hover">
                            <thead><tr><th>SERIE</th><th>CAPACIDAD</th><th>MATERIAL</th><th>PH</th><th>GAS</th><th>FABRICANTE</th></tr></thead>
                            <tbody>
                                @forelse ($salidas as $tanque)
                                    <tr>
                                        <td>{{ $tanque->num_serie }}</td>
                                        <td>{{ $tanque->capacidad }}</td>
                                        <td>{{ $tanque->material }}</td>
                                        <td>{{ $tanque->ph }}</td>
                                        <td>{{ $tipoeva->nombre_gas($tanque->tipo_gas) }}</td>
                                        <td>{{ $tanque->fabricante }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6"><div class="infra-empty-state"><i class="fas fa-truck-loading"></i><strong>Sin cilindros enviados</strong><span>No hay detalle disponible.</span></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-6 mb-3">
            <section class="card h-100" aria-labelledby="infra-entry-title">
                <div class="card-header bg-white text-dark d-flex justify-content-between align-items-center">
                    <h2 id="infra-entry-title" class="h6 mb-0">Cilindros recibidos</h2>
                    <span class="badge badge-secondary">{{ $entradas->count() }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table infra-table table-hover">
                            <thead><tr><th>SERIE</th><th>CAPACIDAD</th><th>MATERIAL</th><th>PH</th><th>GAS</th><th>FABRICANTE</th></tr></thead>
                            <tbody>
                                @forelse ($entradas as $tanque)
                                    <tr>
                                        <td>{{ $tanque->num_serie }}</td>
                                        <td>{{ $tanque->capacidad }}</td>
                                        <td>{{ $tanque->material }}</td>
                                        <td>{{ $tanque->ph }}</td>
                                        <td>{{ $tipoeva->nombre_gas($tanque->tipo_gas) }}</td>
                                        <td>{{ $tanque->fabricante }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6"><div class="infra-empty-state"><i class="fas fa-warehouse"></i><strong>Sin entradas registradas</strong><span>La nota aún no tiene cilindros recibidos.</span></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection

@include('layouts.scripts')
<script src="{{ asset('js/infra/common.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#id-menu-index').addClass('active');
    });
</script>
