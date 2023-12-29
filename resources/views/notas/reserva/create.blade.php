@extends('layouts.sidebar')

@section('content-sidebar')

    <div class="container">
        <form id="idFormReserva">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-1">
                            <a href="{{route("nota.reserva.index")}}" class="btn btn-amarillo btn-primary"> <span class="fas fa-arrow-circle-left"></span></a>
                        </div>
                        <div class="col">
                            <h3>Nueva Reserva </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Incidencia:</span>
                                    </div>
                                    <select name="incidencia" id="incidencia" class="form-control form-control-sm">
                                        <option value="" selected disabled>SELECCIONA</option>
                                        <option value="ENTRADA">ENTRADA</option>
                                        <option value="SALIDA">SALIDA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">         
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Chofer:</span>
                                    </div>
                                        <select name="driver" id="driver" class="form-control form-control-sm">
                                            <option value="" selected disabled>SELECCIONA</option>
                                            @foreach ($drivers as $driver)
                                                <option value="{{$driver->id}}"> {{$driver->nombre." ".$driver->apellido}} </option>
                                            @endforeach
                                        </select>
                                    
                                </div>
                            </div>
                            <div class="col">         
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Vehículo:</span>
                                    </div>
                                    <select name="car" id="car" class="form-control form-control-sm">
                                        <option value="" selected disabled>SELECCIONA</option>
                                        @foreach ($cars as $car)
                                            <option value="{{$car->id}}">{{$car->nombre." - ".$car->modelo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                
                            </div>
                        </div>
                        <span  id="serie_tanque_entradaError" class="text-danger"></span>
                    
                </div>
            </div>
        
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <input id="serie_tanque" type="text" class="form-control form-control-sm" placeholder="# SERIE" disabled>
                                <div class="input-group-prepend">
                                    <button id="btn-insertar-cilindro" class="btn btn-amarillo" type="button">Agregar</button>
                                </div>
                                
                            </div>
                            <span id="serie_tanqueError" class="alert-danger"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-hover table-bordered">
                            <thead>
                                <tr style="font-size: 13px">
                                    <th scope="col">#SERIE</th>
                                    <th scope="col">DESCRIPCIÓN</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-reserva-tanques" style="font-size: 13px">
                            </tbody>
                        </table>
                    </div>

                    
                </div>
                <div class="card-footer">
                    <button type="button" id="btn-save-nota" class="btn btn-verde">Aceptar</button>
                </div>
            </div>
        </form>
    </div>

@endsection
@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/reserva/create.js') }}"></script>