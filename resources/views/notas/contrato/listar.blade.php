@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>LISTADO DE NOTAS</h5>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body bg-verde border-dark text-white text-center  p-2" >
                            <i class="fas fa-sticky-note"></i> Salidas
                        </div>
                        <a href="#" id="btn-salidas">
                            <div class="card-footer bg-gris text-white text-center p-1 " style="font-size:14px">
                                Listar <i class="fas fa-angle-double-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body bg-verde border-dark text-white text-center  p-2" >
                            <i class="fas fa-sticky-note"></i> Entradas
                        </div>
                        <a href="#" id="btn-entradas">
                            <div class="card-footer bg-gris text-white text-center p-1 " style="font-size:14px">
                                Listar <i class="fas fa-angle-double-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body bg-verde border-dark text-white text-center  p-2" >
                            <i class="fas fa-sticky-note"></i> Notas sin Pagar
                        </div>
                        <a href="#" id="btn-adeudos">
                            <div class="card-footer bg-gris text-white text-center p-1 " style="font-size:14px">
                                Listar <i class="fas fa-angle-double-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body bg-verde border-dark text-white text-center  p-2" >
                            <i class="fas fa-sticky-note"></i> Asignaciones
                        </div>
                        <a href="#" id="btn-asignaciones">
                            <div class="card-footer bg-gris text-white text-center p-1 " style="font-size:14px">
                                Listar <i class="fas fa-angle-double-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-1">
        <div class="card-body" id="card-contenido">
            <h5 id="titulo-table"></h5>
            <hr>    
            <div id="insert-table"></div>
        </div>
    </div>
</div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/contrato/listar.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-contrato").addClass('active');
        
    });
</script>
<!--Fin Scripts-->