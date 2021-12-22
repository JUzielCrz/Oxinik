@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('tanques.submenu_navbar')
@endsection

@section('content-sidebar')

@csrf
<div class="container">
    <div class="row">
        <div class="col-md-4" >
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="">Estatus</label>
                            <select name="estatus" id="estatus" class="form-control form-control-sm">
                                <option value="">Selecciona</option>
                                <option value="VACIO-ALMACEN">VACIO-ALMACEN</option>
                                <option value="LLENO-ALMACEN">LLENO-ALMACEN</option>
                                <option value="INFRA">INFRA</option>
                                <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                <option value="ENTREGADO-CLIENTE">ENTREGADO-CLIENTE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Gas</label>
                            <select name="tipo_gas" id="tipo_gas" class="form-control form-control-sm">
                                <option value=0>ALL</option>
                                @foreach ($gases as $gas)
                                    <option value={{$gas->id}}>{{$gas->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col text-right">
                            <button class="btn btn-sm btn-verde" type="button" id="btn-listar">Aplicar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="row no-gutters">
                    {{-- <div class="col-md-4">
                        <div class="card-body p-2">
                            <div class="card-header text-center p-1"> 
                                TANQUES
                            </div>
                            <div class="card-body text-center p-0">
                                <h1 id="contador" class="display-1" style="font-size: 5rem;"> 0</h1>
                            </div>
                        </div>
                    </div> --}}
                    
                    <div class="col">
                        <div class="card-body p-2 table-responsive">
                            <table class="table table-sm " id="table-estatus-1" style="font-size: 13px;">
                                <thead class="text-center bg-gris">
                                    <tr>
                                        <th>ESTATUS</th>
                                        <th>CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr><td class="p-0">VACIO ALMACEN</td><td class="p-0"><strong>{{$vacioalmacen}} </strong></td></tr>
                                    <tr><td class="p-0">LLENO ALMACEN</td><td class="p-0"><strong>{{$llenoalmacen}} </strong></td></tr>
                                    <tr><td class="p-0">INFRA</td><td class="p-0"><strong>{{$infra}} </strong></td></tr>
                                    <tr><td class="p-0">MANTENIMIENTO</td><td class="p-0"><strong>{{$mantenimiento}} </strong></td></tr>
                                    <tr><td class="p-0">ENTREGADO CLIENTE</td><td class="p-0"><strong>{{$entregadocliente}} </strong></td></tr>
                                </tbody>
                                <tfoot class="text-center bg-gris">
                                    <tr><td class="p-1">TOTAL</td><td class="p-1"><strong>{{$vacioalmacen+$llenoalmacen+$infra+$mantenimiento+$entregadocliente}} </strong></td></tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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