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
                    <h5>Notas Foraneas</h5>
                </div>
                <div class="col text-right">
                        <a type="button" class="btn btn-sm btn-amarillo"  href="{{ url('/nota/foranea/create') }}">
                            <span class="fas fa-plus"></span>
                            Agregar
                        </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="row">
                <div class="col">
                    <label for="">Filtro: </label>
                    <select name="" id="Credito" class="form-control form-control-sm">
                        <option value= ''>Credito</option>
                        <option value= 'true'>Pagado</option>
                        <option value= 'false'>Adeuda</option>
                    </select>
                </div>
            </div> --}}
            <div class="table-responsive" style="font-size:13px">
                <table id="tablecruddata" class="table table-sm " style="font-size:13px">
                    <thead>
                        <tr >
                        <th scope="col">#ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Pago Cubierto</th>
                        <th scope="col">Tanques Devueltos</th>
                        <th scope="col">Usuario</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
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
<script src="{{ asset('js/notas/foranea/listado.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-foranea").addClass('active');
    });
</script>
<!--Fin Scripts-->