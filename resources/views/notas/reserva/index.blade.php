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
                    <h5>RESERVA -> Notas</h5>
                </div>
                <div class="col text-right">
                        <button type="button" class="btn btn-amarillo btn-primary" data-toggle="modal" data-target="#modal-create">
                            <span class="fas fa-plus"></span>
                            Agregar
                        </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="font-size:13px">
                <table id="tablecruddata" class="table table-sm " style="font-size:13px">
                    <thead>
                        <tr >
                        <th scope="col">#ID Nota</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Incidencia</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


    <!-- Modal -->
    <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal-createLabel" aria-hidden="true">
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
    </div>
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
<!--Scripts-->
<script src="{{ asset('js/notas/reserva/index.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-reserva").addClass('active');
    });
</script>
<!--Fin Scripts-->