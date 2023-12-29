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
                    <span>RESERVA -> Tanques Pendientes</span>
                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-amarillo btn-primary" id="refresh-table">
                        <i class="fas fa-sync-alt"></i> 
                        Tabla
                    </button >

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="font-size:13px">
                <table id="tablecruddata" class="table table-sm " style="font-size:13px">
                    <thead>
                        <tr >
                            <th scope="col">#Serie</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Chofer</th>
                            <th scope="col">Automovil</th>
                            <th scope="col">#Nota</th>
                            <th scope="col">Fecha</th>
                            <th ></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

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
<!--Scripts-->
<script src="{{ asset('js/notas/reserva/tanque_pendiente.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-reserva").addClass('active');
    });
</script>
<!--Fin Scripts-->