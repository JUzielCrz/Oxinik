@php
$idauth=Auth::user()->id;
$user=App\User::find($idauth);
@endphp
@if($user->permiso_con_admin('tanque_show')) 
    <li class="nav-item" id="id-menu-index" >
        <a class="nav-link" href="{{ url('/tanque/index') }}"><i class="fas fa-prescription-bottle"></i> Tanques</a>
    </li>
    <li class="nav-item" id="id-menu-bajas">
        <a class="nav-link"  href="{{ url('/tanque/lista_bajas') }}"><i class="fas fa-trash"></i> Dados de baja</a>
    </li>
    <li class="nav-item" id="id-menu-estatus">
        <a class="nav-link"  href="{{ url('/tanque/estatus') }}"><i class="fas fa-chart-bar"></i> Información</a>
    </li>
    <li class="nav-item" id="id-menu-reportes">
        <a class="nav-link"  href="{{ url('/tanque/reportados') }}"><i class="fas fa-bug"></i> Reportados</a>
    </li>
    {{-- <li class="nav-item" id="id-menu-sindevolver">
        <a class="nav-link"  href="{{ url('/tanque/sindevolver') }}"><i class="fas fa-undo-alt"></i> Sin Devolver</a>
    </li> --}}
@endif

@if($user->permiso_con_admin('gas_show')) 
    <li class="nav-item" id="id-menu-gas">
        <a class="nav-link"  href="{{ url('/gas/index') }}"><i class="fas fa-gas-pump"></i> Gases</a>
    </li>
@endif

