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
                    <li class="nav-item active mr-4 ml-4">
                        <a class="nav-link btn-menu" href="{{ url('/cliente') }}"><img  src="{{asset('img/contrato.png')}}"   width="60" alt=""><br>Clientes</a>
                    </li>
                @endif
                @if($user->havePermission('contratos'))
                    <li class="nav-item active mr-4">
                        <a class="nav-link btn-menu" href="{{ url('/contratogeneral') }}"><img  src="{{asset('img/contrato.png')}}"   width="60" alt=""><br>Contratos</a>
                    </li>
                @endif
                @if($user->havePermission('tanques'))
                    <li class="nav-item active mr-4 ml-4">
                        <a class="nav-link btn-menu" href="{{ url('/tanque') }}"><img  src="{{asset('img/usuario.svg')}}"   width="60" alt=""><br>Tanques</a>
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

