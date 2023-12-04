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

            <ul id="menu_principal" class="list-unstyled components">
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
                            onclick="salir_pagina(event, '/nota/contrato/salida')"
                            href="{{ url('/nota/contrato/salida') }}"
                            @else
                            onclick="salir_pagina(event, '/nota/contrato/entrada')"
                            href="{{ url('/nota/contrato/entrada') }}"
                            @endif
                            data-toggle="tooltip" data-placement="right" title="Notas"><i class="fas fa-clipboard"></i></a>
                        </li>
                    @endif
                {{-- Clientes --}}
                    @if($user->permiso_con_admin('cliente_show'))    
                        <li id="nav-ico-cliente" ><a  onclick="salir_pagina(event, '/cliente/index')"href="{{ url('/cliente/index') }}" data-toggle="tooltip" data-placement="right" title="Clientes"><i class="fas fa-users"></i></a></li>
                    @endif
                {{-- Contratos --}}
                    @if($user->permiso_con_admin('contrato_show'))    
                        <li id="nav-ico-contratos" ><a onclick="salir_pagina(event, '/contrato/listar')" href="{{ url('/contrato/listar') }}" data-toggle="tooltip" data-placement="right" title="Contratos"><i class="fas fa-file-signature"></i></a></li>
                    @endif
                {{-- Tanques --}}
                    @if($user->permiso_con_admin('tanque_show') || $user->permiso_con_admin('gas_show'))    
                        <li id="nav-ico-tanques"><a 
                            @if ($user->permiso_con_admin('tanque_show'))
                                onclick="salir_pagina(event, '/tanque/index')" 
                                href="{{ url('/tanque/index') }}"
                            @else
                                onclick="salir_pagina(event, '/gas/index')" 
                                href="{{ url('/gas/index') }}"
                            @endif
                            data-toggle="tooltip" data-placement="right" title="Tanques"><i class="fas fa-prescription-bottle"></i> </a></li>
                    @endif
                {{-- Contratos --}}
                    @if($user->permiso_con_admin('concentrators_show'))    
                        <li id="nav-ico-contratos" ><a href="{{ route('concentrators.index') }}" data-toggle="tooltip" data-placement="right" title="Concentradores"><i class="fas fa-suitcase-rolling"></i> </a></li>
                    @endif
                    
                {{-- Infra --}}
                    @if($user->permiso_con_admin('infra_salida') || $user->permiso_con_admin('infra_entrada'))    
                        <li id="nav-ico-infra" ><a onclick="salir_pagina(event, '/infra/index')" href="{{ url('/infra/index') }}" data-toggle="tooltip" data-placement="right" title="Infra"><i class="fas fa-building"></i></a></li>
                    @endif
                {{-- Mantenimiento --}}
                    @if($user->permiso_con_admin('mantenimiento_salida') || $user->permiso_con_admin('mantenimiento_entrada'))    
                        <li id="nav-ico-mantenimiento" >
                            <a onclick="salir_pagina(event, '/mantenimiento/index')"  href="{{ url('/mantenimiento/index') }}"  data-toggle="tooltip" data-placement="right" title="Mantenimiento"><i class="fas fa-dolly-flatbed"></i></a>
                        </li>
                    @endif
                    
                    {{-- Usuarios --}}
                    @if($user->permiso_con_admin('drivers_show') )
                        <li id="nav-ico-usuario" ><a href="{{ url('/drivers') }}" data-toggle="tooltip" data-placement="right" title="Choferes"><i class="fas fa-user-friends"></i></a></li>
                    @endif
                    {{-- Usuarios --}}
                    @if($user->permiso_con_admin('cars_show') )
                        <li id="nav-ico-usuario" ><a href="{{ url('/cars') }}" data-toggle="tooltip" data-placement="right" title="Cars"><i class="fas fa-truck"></i></a></li>
                    @endif
                    {{-- users --}}
                    @if($user->soloParaUnRol('admin'))
                        <li id="nav-ico-usuario" ><a onclick="salir_pagina(event, '/user/index')" href="{{ url('/user/index') }}" data-toggle="tooltip" data-placement="right" title="Usuarios"><i class="fas fa-users-cog"></i></a></li>
                    @endif
                

                {{-- Configuraciones--}}
                @if($user->soloParaUnRol('admin'))
                    <li id="nav-ico-config" ><a onclick="salir_pagina(event, '/config/empresa/index')" href="{{ url('/config/empresa/index') }}" data-toggle="tooltip" data-placement="right" title="Ajustes"><i class="fas fa-tools"></i></a></li>
                @endif
                {{-- Perfil--}}
                <li id="nav-ico-perfil" ><a onclick="salir_pagina(event, '/perfil/index')" href="{{ url('/perfil/index') }}" data-toggle="tooltip" data-placement="right" title="Perfil"><i class="fas fa-user-circle"></i></a></li>
            </ul>

            <ul class="list-unstyled CTAs">
                {{-- <li>
                    <a onclick="salir_pagina(event)" href="#" class="download">Download source</a>
                </li> --}}
                <li>
                    <a onclick="salir_pagina(event)" href="{{ route('logout') }}" 
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
                <span class="text-white mr-2"> <i class="fas fa-user"></i> {{auth()->user()->name}} </span>
                <div class="btn-group">
                    <a type="button" class="btn btn-verde text-white" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-angle-down"></i>
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



<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>