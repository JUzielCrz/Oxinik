@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <form id="formCreateInfra">
        @csrf
        <input type="hidden" name="incidencia" id="incidencia" value="SALIDA">
        <div class="card">
            <div class="card-header p-2 bg-dark text-white">
                <h5 >SALIDA TANQUES <strong>INFRA</strong></h5>
            </div>
        </div>

            <div class="row mt-2">
                <div class="col-md-9">
                    <div class="card" >
                        <div class="card-header">
                            <div class=" row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="serie_tanque" id="serie_tanque" class="form-control form-control-sm" placeholder="#Serie" >
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-sm btn-gray" id="btn-InsertFila"><span class="fas fa-plus"></span> Agredar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger" id="serie_tanqueError"></span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th scope="col">SERIE</th>
                                            <th scope="col">CAPACIDAD</th>
                                            <th scope="col">MATERIAL</th>
                                            <th scope="col">PH</th>
                                            <th>fabricante</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyfilaTanques">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card bg-gray" style="height: 10rem;">
                                <div class="card-header text-center p-1"> 
                                    TANQUES
                                </div>
                                <div class="card-body text-center p-0">
                                    <h1 id="contador" class="display-1" style="font-size: 5rem;"> 0</h1>
                                </div>
                            </div>
                            <hr>
                            <button type="button" id="btn-save" class="btn btn-sm btn-block btn-gray "> <span class="fas fa-save"></span> GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>




@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/infra/registro.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-salida").removeClass('btn-outline-success');
        $("#id-menu-salida").addClass('btn-success');

    });

    // function pulsar(e) {
    //     if (e.keyCode === 13 && !e.shiftKey) {
    //         e.preventDefault();
    //         insert_fila();
    //     }
    // }
</script>
<!--Fin Scripts-->
