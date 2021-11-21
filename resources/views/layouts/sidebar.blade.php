@extends("layouts.headerindex")
@section('contenido')

    @php
        $idauth=Auth::user()->id;
        $user=App\User::find($idauth);
    @endphp

<!--Container Main end-->
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <a href="{{URL('/home')}}">
                    <h3>OXINIK</h3>
                    <strong>OX</strong>
                </a>
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
                    @if($user->permiso_con_admin('nota_salida') ||  $user->permiso_con_admin('nota_entrada') )
                        <li id="nav-ico-notas"><a 
                            @if ($user->permiso_con_admin('nota_salida') )
                            href="{{ url('/nota/contrato/salida') }}"
                            @else
                            href="{{ url('/nota/contrato/entrada') }}"
                            @endif
                            ><i class="fas fa-clipboard"></i> Notas</a>
                        </li>
                    @endif
                {{-- Clientes --}}
                    @if($user->permiso_con_admin('cliente_show'))    
                        <li id="nav-ico-cliente" ><a href="{{ url('/cliente/index') }}"><i class="fas fa-users"></i> Clientes</a></li>
                    @endif
                {{-- Contratos --}}
                    @if($user->permiso_con_admin('contrato_show'))    
                        <li id="nav-ico-contratos" ><a href="{{ url('/contrato/listar') }}"><i class="fas fa-file-signature"></i> Contratos</a></li>
                    @endif
                {{-- Tanques --}}
                    @if($user->permiso_con_admin('tanque_show') || $user->permiso_con_admin('gas_show'))    
                        <li id="nav-ico-tanques"><a 
                            @if ($user->permiso_con_admin('tanque_show'))
                                href="{{ url('/tanque/index') }}"
                            @else
                                href="{{ url('/gas/index') }}"
                            @endif
                            ><i class="fas fa-prescription-bottle"></i> Tanques</a></li>
                    @endif
                {{-- Infra --}}
                    @if($user->permiso_con_admin('infra_salida') || $user->permiso_con_admin('infra_entrada'))    
                        <li id="nav-ico-infra" ><a 
                            @if ($user->permiso_con_admin('infra_salida'))
                                href="{{ url('/infra/salida') }}"
                            @else
                                href="{{ url('/infra/entrada') }}"
                            @endif ><i class="fas fa-building"></i>Infra</a></li>
                    @endif
                {{-- Mantenimiento --}}
                    @if($user->permiso_con_admin('mantenimiento_salida') || $user->permiso_con_admin('mantenimiento_entrada'))    
                        <li id="nav-ico-mantenimiento" ><a 
                            @if ($user->permiso_con_admin('mantenimiento_salida'))
                                href="{{ url('/mantenimiento/salida') }}"
                            @else
                                href="{{ url('/mantenimiento/entrada') }}"
                            @endif
                            ><i class="fas fa-dolly-flatbed"></i> Manteni- <br> miento</a></li>
                    @endif
                {{-- Usuarios --}}
                    @if($user->soloParaUnRol('admin'))
                        <li id="nav-ico-usuario" ><a href="{{ url('/user/index') }}"><i class="fas fa-users-cog"></i>Usuarios</a></li>
                    @endif

            </ul>

            <ul class="list-unstyled CTAs">
                {{-- <li>
                    <a href="#" class="download">Download source</a>
                </li> --}}
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

            <nav class="navbar navbar-expand-sm pt-0 pb-0 ">
                {{-- BOTON PARA MENU LATERAL (SIDEBAR) --}}
                <button type="button" id="sidebarCollapse" class="btn btn-verde " >
                    <i class="fas fa-align-left"></i>   
                </button>
                <button class="btn btn-sm btn-verde ml-2" onclick="return window.history.back();"><span class="fas fa-arrow-circle-left"></span></button>

                {{-- MENU del NVAR--}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>     
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav" id="menu-navbar">
                        @yield('menu-navbar')
                    </ul>
                    
                </div>

                {{-- cERRAR SESION --}}
                <div class="btn-group">
                    <a type="button" class="btn btn-verde text-white" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="font-size: 13px">
                        <a  href="{{ route('logout') }}" class="dropdown-item" type="button" onclick="event.preventDefault(); document.getElementById('logout-form1').submit();" class="article">
                            <i class="fas fa-sign-out-alt"></i> Cerar Sesión
                        </a>
                        <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                
            </nav>

            @yield('content-sidebar')

        </div>
    </div>

@endsection



