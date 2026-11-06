@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row ">
                <div class="col">
                    <h5 class="mb-0">Notas foráneas</h5>
                    <small class="text-white-50">Consulta pagos, devoluciones y pendientes en un solo lugar</small>
                </div>
                <div class="col text-right">
                    <a type="button" class="btn btn-sm btn-amarillo" href="{{ url('/nota/foranea/create') }}">
                        <span class="fas fa-plus"></span>
                        Agregar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="foranea-filters rounded mb-3" aria-label="Filtros de notas foráneas">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong><span class="fas fa-filter mr-1" aria-hidden="true"></span>Filtrar notas</strong>
                        <small class="d-block text-muted">Combina filtros para encontrar rápidamente las notas que requieren atención.</small>
                    </div>
                    <button type="button" class="btn btn-link btn-sm p-0" id="btn-limpiar-filtros">Limpiar filtros</button>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3 mb-2">
                        <label for="filtro-estado">Estatus</label>
                        <select id="filtro-estado" class="form-control form-control-sm">
                            <option value="">Todas</option>
                            <option value="pendiente">Pendientes</option>
                            <option value="completa">Completas</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="filtro-pago">Pago</label>
                        <select id="filtro-pago" class="form-control form-control-sm">
                            <option value="">Todos</option>
                            <option value="pendiente">Adeudos</option>
                            <option value="cubierto">Pagados</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="filtro-tanques">Devolución de cilindros</label>
                        <select id="filtro-tanques" class="form-control form-control-sm">
                            <option value="">Todas</option>
                            <option value="pendientes">Pendientes</option>
                            <option value="devueltos">Devueltos</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-2 d-flex align-items-end">
                        <button type="button" class="btn btn-amarillo btn-sm btn-block" id="btn-aplicar-filtros">
                            <span class="fas fa-search mr-1" aria-hidden="true"></span>Aplicar filtros
                        </button>
                    </div>
                </div>
                <div class="form-row mb-0">
                    <div class="form-group col-md-3 mb-0">
                        <label for="filtro-desde">Desde</label>
                        <input type="date" id="filtro-desde" class="form-control form-control-sm">
                    </div>
                    <div class="form-group col-md-3 mb-0">
                        <label for="filtro-hasta">Hasta</label>
                        <input type="date" id="filtro-hasta" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6 d-flex align-items-end justify-content-md-end">
                        <small id="resumen-filtros" class="text-muted pb-1"></small>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablecruddata" class="table table-sm table-hover align-middle" style="font-size:13px; width:100%">
                    <thead>
                        <tr >
                            <th scope="col">#ID</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Fecha</th>
                            <th scope="col" class="text-right">Total</th>
                            <th scope="col">Pago</th>
                            <th scope="col">Cilindros</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Capturó</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.scripts')
<link rel="stylesheet" href="{{ asset('css/notas-foranea.css') }}?v={{ md5_file(public_path('css/notas-foranea.css')) }}">
<!--Scripts-->
<script src="{{ asset('js/Notas/foranea/listado.js') }}?v={{ md5_file(public_path('js/Notas/foranea/listado.js')) }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-foranea").addClass('active');
    });
</script>
<!--Fin Scripts-->
