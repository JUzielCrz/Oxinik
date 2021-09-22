@extends("layouts.headerindex")

@section('contenido')
    {{-- <head>
        <link href="{{asset('css/sidebar.css')}}" rel="stylesheet">  
    </head> --}}

    @php
        $idauth=Auth::user()->id;
        $user=App\User::find($idauth);
    @endphp

    {{-- Barra --}}
    
    


    <nav class="navbar navbar-expand-lg navbar-light bg-light ">

        <a class="navbar-brand  ml-3" href="#">
            <img src="{{asset('/img/logo.svg')}}" width="120" class="d-inline-block align-top" alt="">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        
        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav text-center">
                
                @if($user->havePermission('clientes'))

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img  src="{{asset('img/cliente.svg')}}"   width="60" alt=""><br>Nota
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ url('/notaentrada') }}">Entrada</a>
                            <a class="dropdown-item" href="{{ url('/notasalida') }}">Salida</a>
                        </div>
                    </li>
                @endif

                @if($user->havePermission('ventas'))
                    <li class="nav-item active mr-4 ml-4">
                        <a class="nav-link btn-menu" href="{{ url('/venta_exporadica/newventa') }}"><img  src="{{asset('img/ventas.svg')}}"   width="60" alt=""><br>Exporadico</a>
                    </li>
                @endif

                @if($user->havePermission('clientes'))
                    <li class="nav-item active mr-4 ml-4">
                        <a class="nav-link btn-menu" href="{{ url('/cliente') }}"><img  src="{{asset('img/cliente.svg')}}"   width="60" alt=""><br>Clientes</a>
                    </li>
                @endif

                @if($user->havePermission('pendientes'))
                    <li class="nav-item active mr-4">
                        <a class="nav-link btn-menu" href="{{ url('/pendientes') }}"><img  src="{{asset('img/pendientes.svg')}}"   width="60" alt=""><br>Pendientes</a>
                    </li>
                @endif

                @if($user->havePermission('infra'))
                    <li class="nav-item active mr-4 ml-4">
                        <a class="nav-link btn-menu" href="{{ url('/createinfra') }}"><img  src="{{asset('img/infra.svg')}}"   width="60" alt=""><br>INFRA</a>
                    </li>
                @endif

                @if($user->havePermission('mantenimiento'))
                    <li class="nav-item active mr-2 ml-2">
                        <a class="nav-link btn-menu" href="{{ url('/createmantenimiento') }}"><img  src="{{asset('img/mantenimiento.svg')}}"   width="60" alt=""><br>Mantenimiento</a>
                    </li>
                @endif

                @if($user->havePermission('tanques'))
                    <li class="nav-item active mr-4">
                        <a class="nav-link btn-menu" href="{{ url('/tanque') }}"><img  src="{{asset('img/tanque.svg')}}"   width="60" alt=""><br>Tanques</a>
                    </li>
                @endif

                

                @if($user->havePermission('reportes'))
                    <li class="nav-item active mr-4 ml-4">
                        <a class="nav-link btn-menu" href="{{ url('/reportes') }}"><img  src="{{asset('img/reportes.svg')}}"   width="60" alt=""><br>Reportes</a>
                    </li>
                @endif

                

                @if($user->havePermission('usuarios'))
                    <li class="nav-item active mr-4 ml-4">
                        <a class="nav-link btn-menu" href="{{ url('/user') }}"><img  src="{{asset('img/usuario.svg')}}"   width="60" alt=""><br>Usuarios</a>
                    </li>
                @endif

                

                    <li class="nav-item active mr-4 ml-4">
                        <a class="nav-link btn-menu" href="{{ route('logout') }}" 
                        onclick="event.preventDefault();
                        document.getElementById('logout-form1').submit();">
                        <span class="fas fa-sign-out-alt fa-2x m-2 "></span>
                        <br>Salir</a>
                    <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    </li>
            </ul>
        </div>

        

    </nav>
    
    <!-- Contenido de pagina -->
    <div id="content">
        <div class="row py-4">


        @yield('contentnavbar')

    </div>

    </div>

@endsection
