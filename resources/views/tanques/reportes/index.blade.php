@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('tanques.submenu_navbar')
@endsection

@section('content-sidebar')

    <div class="container" >
    @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h5>TANQUES CON REPORTE</h5>
                    </div>
                    <div class="col text-right">
                        <a type="button" class="btn btn-sm btn-gray" href="{{ url('/tanque/reportados/create') }}">
                            <span class="fas fa-plus"></span>
                            Nuevo Reporte
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table id="tablecruddata" class="table table-sm" style="font-size: 13px">
                        <thead>
                            <tr>
                            <th class="text-center">#REPORTE</th>
                            <th class="text-center">#SERIE</th>
                            <th class="text-center">DESCRIPCIÓN</th>
                            <th class="text-center">ESTATUS</th>
                            <th class="text-center">OBSERVACIONES</th>
                            <th class="text-center"></th>
                            <th class="text-center"></th> 
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        
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