@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container notas-page">
    <div class="card notas-index-card">
        <div class="notas-page-header">
            <div>
                <h1 id="titulo-tabla" class="notas-page-title">Talones</h1>
                <p class="notas-page-subtitle">Consulta, seguimiento y administración de talones.</p>
            </div>
            <div class="notas-page-actions">
                    <a type="button" class="btn btn-sm btn-amarillo"  href="{{ url('/nota/talon/create') }}">
                        <span class="fas fa-plus"></span>
                        Agregar
                    </a>
            </div>
        </div>
        <div class="card-body">
            <div class="notas-filter-panel">
                <div class="row align-items-end">
                    <div class="col-sm-5 col-md-4 col-lg-3">
                        <label for="estatus">Estado de la nota</label>
                    <div class="input-group input-group-sm">
                        @csrf
                        <select name="estatus" id="estatus" class="form-control form-control-sm">
                            <option value="ALL">General</option>
                            <option value="1">Pendientes</option>
                            <option value="0">Cerrados</option>
                        </select>
                        <div class="input-group-prepend">
                            <button class="btn btn-amarillo" id="btn-estatus" type="button">Aplicar</button>
                        </div>
                    </div>
                        <p class="notas-filter-help">Selecciona un estado para actualizar el listado.</p>
                    </div>
                </div>
            </div>
            <div id="insert-table" class="notas-table-shell table-responsive">
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.scripts')
<link rel="stylesheet" href="{{ asset('css/notas-operacion.css') }}">
<!--Scripts-->
<script src="{{ asset('js/Notas/talon/listado.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-talon").addClass('active');
    });
</script>
<!--Fin Scripts-->
