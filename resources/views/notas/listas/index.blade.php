@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row justify-content-center">
                {{-- <div class="col-md-3">
                    <div class="card">
                        <div class="card-body bg-info border-dark text-white text-center  p-2" >
                            <i class="fas fa-sticky-note"></i> Entradas
                        </div>
                        <a href="#" id="btn-entradas">
                            <div class="card-footer bg-dark text-white text-center p-1 " style="font-size:14px">
                                Listar <i class="fas fa-angle-double-right"></i>
                            </div>
                        </a>
                    </div>
                </div> --}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body bg-info border-dark text-white text-center  p-2" >
                            <i class="fas fa-sticky-note"></i> Salidas
                        </div>
                        <a href="#" id="btn-salidas">
                            <div class="card-footer bg-dark text-white text-center p-1 " style="font-size:14px">
                                Listar <i class="fas fa-angle-double-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body bg-info border-dark text-white text-center  p-2" >
                            <i class="fas fa-sticky-note"></i> Exporadicas
                        </div>
                        <a href="#" id="btn-exporadicas">
                            <div class="card-footer bg-dark text-white text-center p-1 " style="font-size:14px">
                                Listar <i class="fas fa-angle-double-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body bg-info border-dark text-white text-center  p-2" >
                            <i class="fas fa-sticky-note"></i> Sin Pagar
                        </div>
                        <a href="#" id="btn-adeudos">
                            <div class="card-footer bg-dark text-white text-center p-1 " style="font-size:14px">
                                Listar <i class="fas fa-angle-double-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h1>card body</h1>
        </div>
    </div>
</div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/pendientes/index.js') }}"></script>
<!--Fin Scripts-->