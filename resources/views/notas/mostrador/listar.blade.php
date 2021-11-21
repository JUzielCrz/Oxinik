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
                    <h5>Notas Mostrador</h5>
                </div>
                <div class="col text-right">
                    <a type="button" class="btn btn-sm btn-amarillo"  href="{{ url('/nota/exporadica') }}">
                        <span class="fas fa-plus"></span>
                        Agregar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="font-size:13px">
                <table id="table-data" class="table table-sm " style="font-size:13px">
                    <thead><tr>
                        <th>ID</th>
                        <th>CLIENTE</th>
                        <th>FECHA</th>
                        <th>TELEFONO</th>
                        <th>TOTAL</th>
                        <th>ESTATUS</th>
                        <th>USUARIO</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr></thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/exporadica/listar.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-mostrador").addClass('active');
    });
</script>
<!--Fin Scripts-->