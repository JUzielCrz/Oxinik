@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container notas-page">
    <div class="card notas-index-card">
        <div class="notas-page-header">
            <div>
                <h1 class="notas-page-title">Notas de reserva</h1>
                <p class="notas-page-subtitle">Consulta las entradas y salidas de tanques registradas.</p>
            </div>
            <div class="notas-page-actions">
                    <button type="button" class="btn btn-sm btn-amarillo" id="refresh-table" title="Actualizar listado">
                        <i class="fas fa-sync-alt"></i> 
                        Actualizar
                    </button >
                        {{-- <button type="button" class="btn btn-amarillo btn-primary" data-toggle="modal" data-target="#modal-create">
                            <span class="fas fa-plus"></span>
                            Agregar
                        </button> --}}
                        <a href="{{route("notas.reserva.create")}}" class="btn btn-sm btn-amarillo"> <span class="fas fa-plus"></span> Agregar</a>
            </div>
        </div>
        <div class="card-body">
            <div class="notas-filter-panel">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle text-muted mr-2"></i>
                    <span class="notas-filter-help mb-0">Usa el buscador para localizar una nota por incidencia, chofer o vehículo. Las acciones permiten consultar, descargar o eliminar el registro.</span>
                </div>
            </div>
            <div class="notas-filter-panel">
                <div class="row align-items-end">
                    <div class="col-sm-4 col-md-3">
                        <label for="filtro-incidencia">Tipo de movimiento</label>
                        <select id="filtro-incidencia" class="form-control form-control-sm">
                            <option value="">Todas las incidencias</option>
                            <option value="ENTRADA">Entrada</option>
                            <option value="SALIDA">Salida</option>
                        </select>
                    </div>
                    <div class="col-sm-8 col-md-5 mt-3 mt-sm-0 d-flex align-items-end">
                        <button type="button" class="btn btn-link btn-sm p-0" id="btn-limpiar-reserva">Limpiar filtros</button>
                    </div>
                </div>
            </div>
            <div class="notas-table-shell table-responsive">
                <table id="tablecruddata" class="table table-sm">
                    <thead>
                        <tr >
                        <th scope="col"># ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Incidencia</th>
                        <th scope="col">Chofer</th>
                        <th scope="col">Vehículo</th>
                        <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


    <!-- Modal -->
    {{-- <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modal-createLabel">Crear</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                @include('notas.reserva.create')
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btn-save-nota" class="btn btn-verde">Aceptar</button>
            </div>
        </div>
        </div>
    </div> --}}
    <!-- Modal -->
    <div class="modal fade" id="modal-show" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal-showLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modal-showLabel">Visualizar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                @include('notas.reserva.show')
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
            </div>
        </div>
        </div>
    </div>

@endsection

@include('layouts.scripts')
<link rel="stylesheet" href="{{ asset('css/notas-operacion.css') }}">
<!--Scripts-->
<script src="{{ asset('js/Notas/reserva/index.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-reserva").addClass('active');
    });
</script>
<!--Fin Scripts-->
