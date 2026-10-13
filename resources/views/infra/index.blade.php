@extends('layouts.sidebar')

@include('infra.partials.infra_styles')

@section('menu-navbar')
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')
<main class="container-fluid infra-page" aria-labelledby="infra-records-title">
    <div class="card mb-3 infra-context-card">
        <div class="card-header bg-gris text-white">
            <h1 id="infra-records-title" class="infra-page-title">Registros INFRA</h1>
            <p class="infra-page-subtitle">Consulta el estado de las salidas, entradas y cilindros pendientes.</p>
        </div>
        <div class="card-body py-3">
            <div class="d-flex align-items-center text-muted small">
                <span class="fas fa-info-circle text-success mr-2" aria-hidden="true"></span>
                <span>Usa la búsqueda para localizar una nota por ID, fecha o estado operativo.</span>
            </div>
        </div>
    </div>

    <section class="card infra-list-card" aria-labelledby="infra-table-title">
        <div class="card-header bg-white text-dark">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 id="infra-table-title" class="h6 mb-0">Historial operativo</h2>
                <a href="{{ url('/infra/salida') }}" class="btn btn-amarillo btn-sm mt-2 mt-md-0">
                    <span class="fas fa-plus" aria-hidden="true"></span> Registrar nueva salida
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablecruddata" class="table table-sm table-hover align-middle" style="font-size: 13px; width: 100%;">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">ID NOTA</th>
                            <th scope="col">SALIDA</th>
                            <th scope="col">ENTRADA</th>
                            <th scope="col">PENDIENTES</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">REGISTRAR ENTRADA</th>
                            <th scope="col">DETALLE</th>
                            <th scope="col">PDF</th>
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
