@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container notas-page">
    <div class="card notas-index-card">
        <div class="notas-page-header">
            <div>
                <h1 class="notas-page-title">Tanques pendientes</h1>
                <p class="notas-page-subtitle">Tanques que permanecen en reserva y requieren seguimiento operativo.</p>
            </div>
            <div class="notas-page-actions">
                    <button type="button" class="btn btn-sm btn-amarillo" id="refresh-table" title="Actualizar listado">
                        <i class="fas fa-sync-alt"></i> 
                        Actualizar
                    </button >
            </div>
        </div>
        <div class="card-body">
            <div class="notas-filter-panel">
                <div class="row align-items-end">
                    <div class="col-sm-4 col-md-3">
                        <label for="filtro-pendientes-incidencia">Movimiento</label>
                        <select id="filtro-pendientes-incidencia" class="form-control form-control-sm">
                            <option value="">Todos los movimientos</option>
                            <option value="ENTRADA">Entrada</option>
                            <option value="SALIDA">Salida</option>
                        </select>
                    </div>
                    <div class="col-sm-8 col-md-5 mt-3 mt-sm-0 d-flex align-items-end">
                        <button type="button" class="btn btn-link btn-sm p-0" id="btn-limpiar-pendientes">Limpiar filtros</button>
                    </div>
                </div>
                <p class="notas-filter-help"><i class="fas fa-info-circle mr-1"></i> Revisa primero los tanques con movimiento de salida para priorizar su seguimiento.</p>
            </div>
            <div class="notas-table-shell table-responsive">
                <table id="tablecruddata" class="table table-sm">
                    <thead>
                        <tr >
                            <th scope="col">#Serie</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Movimiento</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Chofer</th>
                            <th scope="col">Automovil</th>
                            <th scope="col">#Nota</th>
                            <th scope="col">Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="modal-show" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal-showLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modal-showLabel">Visualizar Nota</h5>
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
<script src="{{ asset('js/Notas/reserva/tanque_pendiente.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-reserva").addClass('active');
    });
</script>
<!--Fin Scripts-->
