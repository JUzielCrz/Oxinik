@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('tanques.submenu_navbar')
@endsection

@section('content-sidebar')

    <div class="container " >
    <form id="form-reporte">
        @csrf
    <div class="row justify-content-center">
        <div class="card " style="width: 50%">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h5>TANQUES CON REPORTE</h5>
                    </div>
                    
                </div>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col">
                        <label for="">#Serie</label>
                        <input type="text" name="num_serie" id="num_serie" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Observaciones/Motivo</label>
                        <textarea name="observaciones" id="observaciones" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-gray" id="btn-save-reporte" data-toggle="modal" data-target="#modal-tanque">
                            Guardar
                        </button>
                        <button type="button" class="btn btn-sm btn-gray" id="btn-cancelar" data-toggle="modal" data-target="#modal-tanque">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
    <script src="{{ asset('js/tanque/reportes.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#id-menu-reportes").removeClass('btn-outline-success');
            $("#id-menu-reportes").addClass('btn-success');
        });
    </script>
<!--Fin Scripts-->