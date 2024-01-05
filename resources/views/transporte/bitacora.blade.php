@extends("layouts.headerindex")
@section('contenido')

<style>
    .width-column {
        width: 5rem;
    }
</style>

    <div class="container mt-4" >
        <nav class="nav bg-dark mb-3" >
            <a class="btn btn-sm btn-verde m-2" href="{{route('transporte.index')}}"><span class="fas fa-arrow-circle-left"></span> Atras</a>
            <ul class="navbar-nav justify-content-center">
                <h5 class="nav-item text-white ">
                    <span>Bitacora Transporte</span>
                </h5>
            </ul>
        </nav>

         {{-- DATA NOTE --}}
         <div class="card">
            <div class="card-header">
                <h5>Datos Generales</h5>
            </div>

            <div class="card-body">
                <div class="row justify-content-end  ">
                    <div class="col-2">
                        <label for="fecha">#Bitácora</label>
                        <input type="text" value="{{$transporte->id}}" id="bitacora_id" class="form-control form-control-sm" readonly >
                    </div>
                    <div class="col-2">
                        <label for="fecha">Fecha</label>
                        <input type="text" value="{{$transporte->fecha}}" class="form-control form-control-sm" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <label for="fecha">Chofer</label>
                        <input type="text" value="{{$driver->nombre.' '.$driver->apellido}}" class="form-control form-control-sm" disabled>
                    </div>
                    <div class="col">
                        <label for="fecha">Tipo Licencia</label>
                        <input type="text" value="{{$driver->licencia_tipo}}" class="form-control form-control-sm" disabled>
                    </div>
                    <div class="col">
                        <label for="fecha">Num. Licencia</label>
                        <input type="text" value="{{$driver->licencia_numero}}" class="form-control form-control-sm" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <label for="fecha">Vehículo</label>
                        <input type="text" value="{{$car->nombre}}" class="form-control form-control-sm" disabled>
                    </div>
                    <div class="col">
                        <label for="fecha">Modelo</label>
                        <input type="text" value="{{$car->modelo}}" class="form-control form-control-sm" disabled>
                    </div>
                    <div class="col">
                        <label for="fecha">Marca</label>
                        <input type="text" value="{{$car->marca}}" class="form-control form-control-sm" disabled>
                    </div>
                    <div class="col">
                        <label for="fecha">Placa</label>
                        <input type="text" value="{{$car->placa}}" class="form-control form-control-sm" disabled>
                    </div>
                </div>
                <form id="formDatosGenerales">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-md-3 form-group">
                            <label for="">Kilometraje Inicial</label>
                            <input type="number" value="{{$transporte->kilometraje_inicial}}" name="kilometraje_inicial" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="">Kilometraje Final</label>
                            <input type="number" value="{{$transporte->kilometraje_final}}" name="kilometraje_final" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="">Envases</label>
                            <input type="number" value="{{$transporte->envases}}" name="envases" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="">Acomuladores</label>
                            <input type="number" value="{{$transporte->acomuladores}}" name="acomuladores" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Observaciones Generales</label>
                            <textarea name="observaciones" id="observaciones" cols="30" rows="1" class="form-control">{{$transporte->observaciones}}</textarea>
                        </div>
                    </div>
                </form>
                <div class="row justify-content-end mt-4">
                    <div class="col col-auto ">
                        <button type="button" class="btn  btn-sm btn-amarillo" id="guardar_nota" >
                            <span class="fas fa-plus"></span>
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
            

        </div>

        <div class="card mt-3">
            <div class="card-header ">
                <div class="row">
                    <div class="col">
                        <h5>Incidencias</h5>
                    </div>
                    {{-- <div class="col text-right">
                        
                        <button type="button" class="btn  btn-sm btn-amarillo" id="new-rent" >
                            <span class="fas fa-plus"></span>
                            Agregar
                        </button>
                    </div> --}}
                    
                </div>
                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm " id="tablecruddata">
                        <thead>
                            <th>Lugar Salida</th>
                            <th>Lugar Llegada</th>
                            <th>Hora Salida</th>
                            <th>Hora Entrada</th>
                            <th>Descarga</th>
                            <th>Carga</th>
                            <th>Total</th>
                            <th>Observacion</th>
                            <th></th>
                        </thead>
                        
                    </table>
                </div>
                <hr>
                <form id="formIncidencia">
                    <div class="row">
                        @csrf
                        <div class="col-md-3">
                            <label for="">Lugar Salida</label>
                            <input type="text" value="" name="lugar_salida" id="lugar_salida" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label for="">Lugar Llegada</label>
                            <input type="text" value="" name="lugar_llegada" id="lugar_llegada"  class="form-control form-control-sm">
                        </div>
                        <div class="col">
                            <label for="">Hora Salida</label>
                            <input type="time" value=""  name="hora_salida" id="hora_salida"class="form-control form-control-sm">
                        </div>
                        <div class="col">
                            <label for="">Hora Entrada</label>
                            <input type="time" value="" name="hora_entrada" id="hora_entrada" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label for="">Descarga E/A</label>
                            <input type="text" value="" name="descarga" id="descarga" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label for="">Carga E/A</label>
                            <input type="text" value="" name="carga" id="carga" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label for="">Total</label>
                            <input type="text" value="" name="total" id="total" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label for="">Observación</label>
                            <textarea name="observaciones"  id="observaciones" class="form-control  form-control-sm" id="" cols="1" rows="1"></textarea>
                        </div>
                        <div class="col align-self-end">
                            <button type="button" class="btn  btn-sm btn-amarillo" id="guardar_incidencia" >
                                <span class="fas fa-plus"></span>
                                Añadir
                            </button>
                        </div>
                    </div>
                </form>
            </div>
    
        </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/transporte/bitacora.js') }}"></script>


<!--Fin Scripts-->
