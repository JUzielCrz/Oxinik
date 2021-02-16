@extends('layouts.navbar')
@section('contentnavbar')

<style>
    body {
        background-color: #e8ebf0;
    }
</style>

<div class="container">
    <form id="formCreatemantenimiento">
        @csrf
        <input type="hidden" id="idmantenimientoNota" name="idmantenimientoNota" value="{{$mantenimientonota->id}}">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h2>CONTROL DE TANQUES EN mantenimiento</h2>
                        </div>
                        <div class="col-md-3 text-right" >
                            <button type="button" id="btn-SaveAll" class="btn btn-gray btn-md"> <span class="fas fa-save fa-2x mr-2"></span> GUARDAR</button>
                            <a href={{ url('/mantenimiento')}} class="btn btn-gray btn-md"> <span class="fas fa-sticky-note fa-2x"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="card" style="height: 10rem">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label>Fecha</label>
                                    <input class="form-control" type="date" name="fecha" id="fecha" value="{{$mantenimientonota->fecha}}">
                                    <span id="fechaError" class="text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('Incidencia') !!}
                                    {{ Form::select('incidencia',['ENTRADA' => 'ENTRADA', 'SALIDA' => 'SALIDA'], $mantenimientonota->incidencia ,['id' => 'incidencia','class'=>'form-control ml-2', 'placeholder'=>'Selecciona', 'required'])}}
                                    <span  id="incidenciaError" class="text-danger"></span>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-gray" style="height: 10rem;">
                        <div class="card-header text-center " style="padding: 5px"> 
                            TANQUES
                        </div>
                        <div class="card-body text-center" style="padding: 0px">
                            <h1 id="contador" class="display-1" style="font-size: 6rem;"></h1>
                            <input type="hidden" id="cantidadtanques" value="{{$mantenimientonota->cantidad}}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4" >
                <div class="card-header">
                    <div class=" row">
                        <div class="form-group col-md-6">
                            <input type="text" name="serie_tanque" id="serie_tanque" class="form-control" placeholder="Número de Serie">
                            <span class="text-danger" id="serie_tanqueError"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <button type="button" class="btn btn-gray" id="btn-InsertFila"><span class="fas fa-plus mr-2"></span> Agredar</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">SERIE</th>
                                    <th scope="col">CAPACIDAD</th>
                                    <th scope="col">MATERIAL</th>
                                    <th scope="col">PH</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tbodyfilaTanques">
                                @foreach ($tanques as $tanq)
                                    <tr class="trFilaTanque">
                                        <td> {{$tanq->num_serie}}</td> <input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='{{$tanq->num_serie}}'>
                                        <td> {{$tanq->capacidad}}</td>
                                        <td> {{$tanq->material}}</td>
                                        <td> {{$tanq->ph}}</td>
                                        <td><button type='button' class='btn btn-naranja' id='btn-EliminarFila'><span class='fas fa-window-close'></span></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <center>
                        <div id="divmsgtanque" style="display:none" class="alert" role="alert">
                        </div>
                    </center>
                </div>
            </div>
        
    </form>
</div>




@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/mantenimiento/edit.js') }}"></script>
<!--Fin Scripts-->
