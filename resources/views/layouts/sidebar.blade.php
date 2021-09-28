@extends("layouts.headerindex")
@section('contenido')


{{-- <img src="{{asset('/img/empresa/logo.svg')}}" width="120" class="d-inline-block align-top">--}}

<!--Container Main end-->

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <h3>OXINIK</h3>
                <strong>OX</strong>
            </div>

            <ul class="list-unstyled components">
                {{-- <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li><a href="#">Home 1</a></li>
                        <li><a href="#">Home 2</a></li>
                        <li><a href="#">Home 3</a></li>
                    </ul>
                </li> --}}

                {{-- Nota --}}
                    <li id="nav-ico-notas"><a href="{{ url('/nota/salida') }}"><i class="fas fa-clipboard"></i> Notas</a></li>
                {{-- Clientes --}}
                    <li id="nav-ico-cliente" ><a href="{{ url('/cliente/index') }}"><i class="fas fa-users"></i> Clientes</a></li>
                {{-- Contratos --}}
                    <li id="nav-ico-contratos" ><a href="{{ url('/contratos/index') }}"><i class="fas fa-file-signature"></i> Contratos</a></li>
                {{-- Tanques --}}
                    <li id="nav-ico-tanques"><a href="{{ url('/tanque/index') }}"><i class="fas fa-prescription-bottle"></i> Tanques</a></li>
                {{-- Infra --}}
                    <li id="nav-ico-infra" ><a href="{{ url('/infra/entrada') }}"><i class="fas fa-building"></i>Infra</a></li>
                {{-- Mantenimiento --}}
                    <li id="nav-ico-mantenimiento" ><a href="{{ url('/mantenimiento/entrada') }}"><i class="fas fa-dolly-flatbed"></i> Manteni- <br> miento</a></li>
                
                {{-- Reportes --}}
                {{-- Usuarios --}}
                {{-- <li id="nav-ico-usuario" ><a href="{{ url('/user/index') }}"><i class="fas fa-users-cog"></i>Usuarios</a></li> --}}

            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="#" class="download">Download source</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault();
                    document.getElementById('logout-form1').submit();" class="article">Cerar Sesión</a>
                    <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-sm navbar-light bg-light p-2">
                {{-- BOTON PARA MENU LATERAL (SIDEBAR) --}}
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>   
                </button>

                {{-- MENU del NVAR--}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>     
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ">
                        @yield('menu-navbar')
                    </ul>
                </div>
            </nav>

            @yield('content-sidebar')

        </div>
    </div>

@endsection



