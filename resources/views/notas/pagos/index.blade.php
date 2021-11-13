@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

    <div class="container">
        <div class="card ">
            <div class="card-header pt-1 pb-1">
                <h5 class="mb-0" style="font-size: 20px">IFORMACIÓN NOTA</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm" style="font-size: 13px" >
                        <thead >
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">FECHA</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">SUMA PAGOS</th>
                                <th class="text-center">ADEUDO</th>
                                <th class="text-center">OBSERVACIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                    $adeudo=$nota->total-$suma_pagos;
                                @endphp
                                <input type="hidden" id="nota_id" value="{{$nota->id}}">
                                <td class="text-center">{{$nota->id}}</td>
                                <td class="text-center">{{$nota->fecha}}</td>
                                <td class="text-center">{{$nota->total}}</td>
                                <td class="text-center">{{$suma_pagos}}</td>
                                <td class="text-center">{{$adeudo}}</td>
                                <td class="text-center">{{$nota->observaciones}}</td>
        
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header pt-1 pb-1">
                <div class="row">
                    <div class="col">
                        <h5 class="mb-0" style="font-size: 20px">PAGOS</h5>
                    </div>
                    <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-create">Agregar</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm" style="font-size: 13px">
                        <thead>
                            <tr>
                                <th class="text-center">MONTO PAGO</th>
                                <th class="text-center">METODO DE PAGO</th>
                                <th class="text-center">FECHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pagos as $pago)
                            <tr>
                                <td class="text-center">{{$pago->monto_pago}}</td>
                                <td class="text-center">{{$pago->metodo_pago}}</td>
                                <td class="text-center">{{$pago->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modal-createLabel">Agregar Pago Nota</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                @include('notas.pagos.create')
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button id="btn-aceptar"  type="button" class="btn btn-success">Aceptar</button>
            </div>
        </div>
        </div>
    </div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/pagos/index.js') }}"></script>
<!--Fin Scripts-->