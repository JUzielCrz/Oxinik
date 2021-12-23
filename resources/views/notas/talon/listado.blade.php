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
                    <h5 id="titulo-tabla">TALONES</h5>
                </div>
                <div class="col text-right">
                    <a type="button" class="btn btn-sm btn-amarillo"  href="{{ url('/nota/talon/create') }}">
                        <span class="fas fa-plus"></span>
                        Agregar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="input-group input-group-sm">
                        @csrf
                        <select name="estatus" id="estatus" class="form-control form-control-sm">
                            <option value="ALL">GENERAL</option>
                            <option value=1>PENDIENTES</option>
                            <option value=0>CERRADOS</option>
                        </select>
                        <div class="input-group-prepend">
                            <button class="btn btn-amarillo" id="btn-estatus"> Aplicar</button>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            <hr>
            <div id="insert-table" class="table-responsive ">
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/talon/listado.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-talon").addClass('active');
    });
</script>
<!--Fin Scripts-->