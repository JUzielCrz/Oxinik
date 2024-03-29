    <li class="nav-item dropdown" id="id-menu-contrato" >
        <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-sticky-note"></i>  C/Contrato |<i class="fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 13px">
            <a class="dropdown-item" href="{{ url('/nota/contrato/salida') }}"> <i class="fas fa-sign-out-alt"></i> Notas Salida</a>
            <a class="dropdown-item" href="{{ url('/nota/contrato/entrada') }}"><i class="fas fa-sign-in-alt"></i> Notas Entrada</a>
            <a class="dropdown-item" href="{{ url('/nota/contrato/listar/index') }}"><i class="fas fa-sign-in-alt"></i> Lista Notas</a>
        </div>
    </li>
    <li class="nav-item dropdown" id="id-menu-mostrador" >
        <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-sticky-note"></i> Mostrador | <i class="fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 13px">
            <a class="dropdown-item" href="{{ url('/nota/exporadica') }}"> <i class="fas fa-shopping-bag"></i> Generar Nota</a>
            <a class="dropdown-item" href="{{ url('/nota/exporadica/listar') }}"><i class="fas fa-sign-in-alt"></i> Lista Notas</a>
        </div>
    </li>
    <li class="nav-item" id="id-menu-foranea">
        <a class="nav-link"  href="{{ url('/nota/foranea/index') }}"><i class="fas fa-sticky-note"></i> Foraneas</a>
    </li>
    <li class="nav-item" id="id-menu-talon">
        <a class="nav-link"  href="{{ url('/nota/talon/index') }}"><i class="fas fa-sticky-note"></i>> Talones</a>
    </li>

    <li class="nav-item dropdown" id="id-menu-reserva" >
        <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-sticky-note"></i> Reserva <i class="fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 13px">
            <a class="dropdown-item" href="{{ url('/nota/reserva/tanques_pendientes') }}"> Tanques Pendientes</a>
            <a class="dropdown-item" href="{{ url('/nota/reserva/index') }}">Lista Notas</a>
        </div>
    </li>

    
