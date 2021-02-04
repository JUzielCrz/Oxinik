@extends('layouts.navbar')
@section('contentnavbar')
    <div class="container">
        <div class="row justify-content-center  ">
            <div class="card col-md-3">
                <div class="card-body text-center">
                <h5 class="card-title">Vacío en Almacén</h5>
                <h1 class="display-3"> {{$cantvacioalmacen}}</h1>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
                </div>
            </div>

            <div class="card col-md-3 ml-3">
                <div class="card-body text-center">
                    <h5 class="card-title">LLeno en Almacén</h5>
                    <h1 class="display-3"> {{$cantllenoalmacen}}</h1>
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>

            <div class="card col-md-3 ml-3">
                <div class="card-body text-center">
                <h5 class="card-title">Entregadoa a clientes</h5>
                <h1 class="display-3"> {{$cantEntregadoCliente}}</h1>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center  mt-4">
            <div class="card col-md-3 ml-3">
                <div class="card-body text-center">
                <h5 class="card-title">Infra</h5>
                <h1 class="display-3"> {{$cantinfra}}</h1>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
                </div>
            </div>

            <div class="card col-md-3 ml-3">
                <div class="card-body text-center">
                <h5 class="card-title">Mantenimiento</h5>
                <h1 class="display-3"> {{$cantmantenimiento}}</h1>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
                </div>
            </div>
        </div>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
    {{-- <script src="{{ asset('js/cruds/tanques.js') }}"></script> --}}
<!--Fin Scripts-->