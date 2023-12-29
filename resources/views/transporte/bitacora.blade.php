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
                        <input type="text" value="{{$bitacora->id}}" class="form-control form-control-sm" readonly >
                    </div>
                    <div class="col-2">
                        <label for="fecha">Fecha</label>
                        <input type="text" value="{{$bitacora->fecha}}" class="form-control form-control-sm" disabled>
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
                <div></div>
            </div>
    
        </div>



        {{-- OBSERVACIONES --}}
        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="">Observaciones Generales</label>
                        <textarea name="observaciones" id="observaciones" cols="30" rows="1" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/transporte/bitacora.js') }}"></script>


<!--Fin Scripts-->
