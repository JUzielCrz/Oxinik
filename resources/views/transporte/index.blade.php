@extends('layouts.sidebar')

    @section('menu-navbar') 
    
    @endsection

@section('content-sidebar')

    <div class="container">
        <div class="card">
            
            <div class="card-body">
                <h4>Filtrar</h4>
                <hr>
                <form action="" id="formFilter">
                    @csrf
                    <div class="row">
                        <div class="col"> 
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Fecha:</span>
                                </div>
                                <input type="date" name="filter_fecha" id="filter_fecha" class="form-control  form-control-sm ">
                            </div> 
                        </div>   
                        <div class="col"> 
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Vehículo:</span>
                                </div>
                                <select name="filter_vehiculo" id="filter_vehiculo" class="form-control form-control-sm">
                                    <option value="">SELECCIONA</option>
                                    @foreach ($cars as $car)
                                        <option value="{{$car->id}}">{{$car->nombre." ".$car->modelo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>   
                        <div class="col">      
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Chofer:</span>
                                </div>
                                <select name="filter_chofer" id="filter_chofer" class="form-control form-control-sm">
                                    <option value="">SELECCIONA</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{$driver->id}}">{{$driver->nombre." ".$driver->apellido}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" id="filtro" class="btn btn-sm btn-amarillo">Buscar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="card mt-3" >
            <div class="card-header">
                <div class="row justify-content-end ">
                    <div class="col-auto">
                        <button type="button" class="btn btn-sm btn-amarillo" data-toggle="modal" data-target="#modalCreate">Agregar</button>

                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                informacion del driver y coche
                            </div>
                            <div class="card-footer d-flex p-0">
                                <button class="btn btn-info w-50 rounded-0 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-info-circle mr-2"></i> Incidencia</button>
                                <button class="btn btn-danger w-50 rounded-0 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-file-pdf mr-2"></i> PDF
                                </button>
                                
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="table-responsive"> 
                    <table id="tablecruddata" class="table table-sm" style="font-size: 13px">
                        <thead>
                            <tr>
                            <th>#NOTA</th>
                            <th scope="col">Vehículo</th>
                            <th scope="col">Chofer</th>
                            <th scope="col">Fecha</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


        <!-- Modal insertar-->
        <div class="modal fade bd-example-modal-md" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-onix">
                <h5 id="modal_title">Agregar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                    <span aria-hidden="true" class="fas fa-times"></span>
                </button>
                </div>
                <div class="modal-body">
                @include('transporte.create')
                <!--Botones Aceptar y Cancelar-->
                <div class="row justify-content-center" >
                    <div class="btn-group col-auto">
                        <button type="button" class="btn  btn-sm btn-amarillo" id="btn_save">Guardar</button>
                    </div>
                    <div class="btn-group col-auto" >
                        <button  class="btn  btn-sm btn-amarillo" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                </div>
                
            </div>
            </div>
        </div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/transporte/index.js') }}"></script>
<!--Fin Scripts-->