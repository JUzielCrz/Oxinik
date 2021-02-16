@extends('layouts.navbar')
@section('contentnavbar')

<style>
    body {
        background-color: #e8ebf0;
    }
</style>

    <div class="container">
        <div class="row justify-content-center  ">
            <div class="col-md-3">
                <a class="btn btn-block" id="btn-vacio-almacen" style="padding: 0px">
                    <div class="card" >
                        <div class="card-header">
                            <p class="card-title text-center">Vacío en Almacén</p>
                        </div>
                        <div class="card-body text-center">
                        <h1 class="display-3" style="font-size: 28px; font-weight: normal"> {{$cantvacioalmacen}}</h1>
                        </div>
                    </div>
                </a>
            </div>
        
            <div class="col-md-3">
                <a class="btn btn-block" id="btn-lleno-almacen" style="padding: 0px">
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title text-center">LLeno en Almacén</p>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-3" style="font-size: 28px; font-weight: normal"> {{$cantllenoalmacen}}</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="btn btn-block" id="btn-entregado-cliente" style="padding: 0px">
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title text-center">Entregado a cliente</p>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-3" style="font-size: 28px; font-weight: normal"> {{$cantEntregadoCliente}}</h1>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="row justify-content-center mt-4">

            <div class="col-md-3">
                <a class="btn btn-block" id="btn-infra" style="padding: 0px">
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title text-center">Infra</p>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-3" style="font-size: 28px; font-weight: normal"> {{$cantinfra}}</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="btn btn-block" id="btn-mantenimiento" style="padding: 0px">
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title text-center">Mantenimiento</p>
                        </div>  
                        <div class="card-body text-center">
                            <h1 class="display-3" style="font-size: 28px; font-weight: normal"> {{$cantmantenimiento}}</h1>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    
        @csrf
        <div class="card mt-4">
            <div class="card-body" id="cardtablas">
                <div class="table-responsive" >
                    
                </div>
            </div>
        </div>
    
    </div>



@endsection

@include('layouts.scripts')
<!--Scripts-->
    <script src="{{ asset('js/cruds/reportes.js') }}"></script>
<!--Fin Scripts-->