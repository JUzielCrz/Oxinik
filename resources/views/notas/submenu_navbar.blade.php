    <li class="nav-item dropdown" id="id-menu-contrato" >
        <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            C/Contrato <i class="fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 13px">
            <a class="dropdown-item" href="{{ url('/nota/salida') }}"> <i class="fas fa-sign-out-alt"></i> Salida</a>
            <a class="dropdown-item" href="{{ url('/nota/entrada') }}"><i class="fas fa-sign-in-alt"></i> Entrada</a>
        </div>
    </li>
    <li class="nav-item" id="id-menu-mostrador">
        <a class="nav-link"  href="{{ url('/nota/exporadica') }}"><i class="fas fa-shopping-bag"></i> Mostrador</a>
    </li>
    <li class="nav-item" id="id-menu-foranea">
        <a class="nav-link"  href="{{ url('/nota/foranea/index') }}"><i class="fas fa-tasks"></i> Foraneas</a>
    </li>
    <li class="nav-item" id="id-menu-talon">
        <a class="nav-link"  href="{{ url('/nota/talon/index') }}"><i class="fas fa-tasks"></i> Talones</a>
    </li>
    <li class="nav-item" id="id-menu-notas">
        <a class="nav-link"  href="{{ url('/nota/listar/index') }}"><i class="fas fa-tasks"></i> Notas</a>
    </li>
    
