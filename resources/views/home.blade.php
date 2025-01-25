@extends('layouts.sidebar')

@section('content-sidebar')

    <style>

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 70vh;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: #2F4858;
        }
    </style>

    @php
    $idauth=Auth::user()->id;
    $user=App\User::find($idauth);
    @endphp

    <div class="container">
        <div class="card-group" style="width: 80%">
            <div class="card">
                <div class="row mt-5 mb-5">
                    <div class="col text-center">
                        <img src="img/logo.png" width="370rem" alt="" >
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                    <hr>
                    <h1 class="display-4 mb-5" >¡Bienvenido!</h1>
                    </div>
                </div>
            </div>
            <div class="card bg-verde">
                <div class="card-body">
                    <div class="card-group">
                        @if($user->permiso_con_admin('nota_salida') ||  $user->permiso_con_admin('nota_entrada') )
                            <div class="card text-center mr-2" style="width: 13rem">
                                <a  @if ($user->permiso_con_admin('nota_salida') )
                                    href="{{ url('/nota/contrato/salida') }}"
                                    @else
                                    href="{{ url('/nota/contrato/entrada') }}"
                                    @endif>
                                    <img src="{{asset('/img/home/notas_venta.svg')}}" width="100" height="80" class="d-inline-block align-top mt-2" alt="">
                                    <hr class="mb-1">
                                    <span style="color: #84A7BD">NOTAS</span>
                                </a>
                            </div>
                        @endif
                        {{-- Clientes --}}
                        @if($user->permiso_con_admin('cliente_show'))    
                            <div class="card text-center mr-2" style="width: 13rem">
                                <a href="{{ url('/cliente/index') }}">
                                    <img src="{{asset('/img/home/clientes.svg')}}" width="100" height="80" class="d-inline-block align-top mt-2" alt="">
                                    <hr class="mb-1">
                                    <span style="color: #84A7BD">CLIENTES</span>
                                </a>
                            </div>
                        @endif
                        {{-- Contratos --}}
                        @if($user->permiso_con_admin('contrato_show'))  
                            <div class="card text-center mr-2" style="width: 13rem">
                                <a href="{{url('/contrato/listar')}}">
                                    <img src="{{asset('/img/home/contratos.svg')}}" width="100" height="80" class="d-inline-block align-top mt-2" alt="">
                                    <hr class="mb-1">
                                    <span style="color: #84A7BD">CONTRATOS</span>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-group mt-4">
                        @if($user->permiso_con_admin('tanque_show') || $user->permiso_con_admin('gas_show'))    
                            <div class="card text-center mr-2" style="width: 13rem">
                                <a @if ($user->permiso_con_admin('tanque_show'))
                                    href="{{ url('/tanque/index') }}"
                                @else
                                    href="{{ url('/gas/index') }}"
                                @endif>
                                    <img src="{{asset('/img/home/tanques.svg')}}" width="100" height="80" class="d-inline-block align-top mt-2" alt="">
                                    <hr class="mb-1">
                                    <span style="color: #84A7BD">TANQUES</span>
                                </a>
                            </div>
                        @endif
                        {{-- Infra --}}
                        @if($user->permiso_con_admin('infra_salida') || $user->permiso_con_admin('infra_entrada'))    
                            <div class="card text-center mr-2" style="width: 13rem">
                                <a @if ($user->permiso_con_admin('infra_salida'))
                                    href="{{ url('/infra/salida') }}"
                                @else
                                    href="{{ url('/infra/entrada') }}"
                                @endif >
                                    <img src="{{asset('/img/home/infra.svg')}}" width="100" height="80" class="d-inline-block align-top mt-2" alt="">
                                    <hr class="mb-1">
                                    <span style="color: #84A7BD">INFRA</span>
                                </a>
                            </div>
                        @endif
                        {{-- Mantenimiento --}}
                        @if($user->permiso_con_admin('mantenimiento_salida') || $user->permiso_con_admin('mantenimiento_entrada'))    
                            <div class="card text-center mr-2" style="width: 13rem">
                                <a @if ($user->permiso_con_admin('mantenimiento_salida'))
                                    href="{{ url('/mantenimiento/salida') }}"
                                @else
                                    href="{{ url('/mantenimiento/entrada') }}"
                                @endif>
                                    <img src="{{asset('/img/home/mantenimiento.svg')}}" width="100" height="80" class="d-inline-block align-top mt-2" alt="">
                                    <hr class="mb-1">
                                    <span style="color: #84A7BD">MANTENIMIENTO</span>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-group mt-4">
                        @if($user->soloParaUnRol('admin'))
                            <div class="card text-center" style="width: 13rem">
                                <a href="#">
                                    <img src="{{asset('/img/home/usuarios.svg')}}" width="100" height="80" class="d-inline-block align-top mt-2" alt="">
                                    <hr class="mb-1">
                                    <span style="color: #84A7BD">USUARIOS</span>
                                </a>
                            </div>
                        @endif
                        {{-- <div class="card text-center mr-2" style="width: 13rem">
                        </div>
                        <div class="card text-center mr-2" style="width: 13rem">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div> 
    </div>  

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/tanque/index.js') }}"></script>
<!--Fin Scripts-->
