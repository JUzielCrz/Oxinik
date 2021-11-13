@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('tanques.submenu_navbar')
@endsection

@section('content-sidebar')


<div class="container">
    <div class="card">
        <div class="card-body">
            <span><strong>Selecciona Estatus</strong></span>
            <hr>
            <div class="row" >
                <div class="col-md-6">  
                    <table class="table table-sm table-hover" id="table-estatus-1" style="font-size: 13px;">
                        <thead>
                            <tr>
                                <th>Estatus</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr><td>VACIO-ALMACEN</td><td><strong>{{$vacioalmacen}} </strong></td></tr>
                            <tr><td>LLENO-ALMACEN</td><td><strong>{{$llenoalmacen}} </strong></td></tr>
                            <tr><td>INFRA</td><td><strong>{{$infra}} </strong></td></tr>
                            <tr><td>MANTENIMIENTO</td><td><strong>{{$mantenimiento}} </strong></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-hover" id="table-estatus-2" style="font-size: 13px;">
                        <thead>
                            <tr>
                                <th>Estatus</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr><td>ENTREGADO-CLIENTE</td> <td> <strong>{{$entregadocliente}} </strong>  </td> </tr>
                            <tr><td>VENTA-ESPORÁDICA</td> <td> <strong>{{$ventaexporadica}} </strong> </td> </tr>
                            <tr><td>TANQUE-CAMBIADO</td> <td> <strong>{{$tanquecambiado}} </strong> </td> </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 id="titulo-table"></h5>
        </div>
        <div class="card-body" id="card-contenido">
            
        </div>
    </div>
</div>



@endsection

@include('layouts.scripts')
<!--Scripts-->
    <script src="{{ asset('js/tanque/listar_estatus.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#id-menu-estatus").addClass('active');
        });
    </script>
    <!--Fin Scripts-->