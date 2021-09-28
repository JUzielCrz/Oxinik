@extends('layouts.sidebar')

@section('content-sidebar')

    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="card bg-dark text-white ">
                    <div class="card-body">
                        <h1 class="display-4">Bienvenido</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-3">    
                <a href="{{ url('/nota/salida') }}">
                    <div class="card" style="width: 14rem">
                        <div class="card-body text-center">
                            <img src="{{asset('/img/home/notas_venta.svg')}}" width="100" height="100" class="d-inline-block align-top" alt="">
                        <hr>
                        Notas
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/cliente/index') }}">
                    <div class="card" style="width: 14rem">
                        <div class="card-body text-center">
                            <img src="{{asset('/img/home/clientes.svg')}}" width="100" height="100" class="d-inline-block align-top" alt="">
                        <hr>
                        Clientes
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#">
                    <div class="card" style="width: 14rem">
                        <div class="card-body text-center">
                            <img src="{{asset('/img/home/contratos.svg')}}" width="100" height="100" class="d-inline-block align-top" alt="">
                        <hr>
                        Contratos
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/tanque/index') }}">
                    <div class="card" style="width: 14rem">
                        <div class="card-body text-center">
                            <img src="{{asset('/img/home/tanques.svg')}}" width="100" height="100" class="d-inline-block align-top" alt="">
                        <hr>
                        Tanques
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-3">
                <a href="{{ url('/infra/entrada') }}">
                    <div class="card" style="width: 14rem">
                        <div class="card-body text-center">
                            <img src="{{asset('/img/home/infra.svg')}}" width="100" height="100" class="d-inline-block align-top" alt="">
                        <hr>
                            Infra
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/mantenimiento/entrada') }}">
                    <div class="card" style="width: 14rem">
                        <div class="card-body text-center">
                            <img src="{{asset('/img/home/mantenimiento.svg')}}" width="100" height="100" class="d-inline-block align-top" alt="">
                        <hr>
                            Mantenimiento
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#">
                    <div class="card" style="width: 14rem">
                        <div class="card-body text-center">
                            <img src="{{asset('/img/home/usuarios.svg')}}" width="100" height="100" class="d-inline-block align-top" alt="">
                        <hr>
                            Usuarios
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>  

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/tanque/index.js') }}"></script>
<!--Fin Scripts-->
