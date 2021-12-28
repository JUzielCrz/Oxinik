@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('mantenimiento.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <form id="formCreateMantenimiento">
        @csrf
        <input type="hidden" name="incidencia" id="incidencia"  value="ENTRADA">
        <div class="card">
            <div class="card-header p-2 bg-gris text-white">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="ml-3"> INFORMACIÓN NOTA <strong>MANTENIMIENTO. </strong></h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <span>Incidencia: <strong>{{$mantenimientonota->incidencia}}</strong> <br> Nota id: <strong>{{$mantenimientonota->id}}</strong></span>
            </div>
        </div>

            <div class="row mt-2">
                <div class="col-md-9">
                    <div class="card" >
                        <div class="card-header">
                            <h5>TANQUES </h5>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th scope="col">SERIE</th>
                                            <th scope="col">DESCRIPCIÓN</th>
                                            <th scope="col">TALÓN</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyfilaTanques">
                                        @foreach ($tanques as $tanq)
                                            <tr class="trFilaTanque">
                                                <td> {{$tanq->num_serie}}</td> 
                                                <td> {{$tanq->capacidad}}, {{$tanq->material}}, PH: {{$tanq->ph}}, {{$tanq->tipo_gas}}, {{$tanq->tipo_gas}}, {{$tanq->tipo_tanque}}, {{$tanq->fabricante}}</td>
                                                <td> {{$tanq->folio_talon}}</td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card bg-gray" style="height: 10rem;">
                                <div class="card-header text-center p-1"> 
                                    TANQUES
                                </div>
                                <div class="card-body text-center p-0">
                                    <h1 id="contador" class="display-1" style="font-size: 5rem;"> {{$mantenimientonota->cantidad}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>




@endsection

@include('layouts.scripts')

