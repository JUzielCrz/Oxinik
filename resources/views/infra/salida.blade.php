@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container" >
    <form id="formCreateInfra">
        @csrf
        <div class="card">
            <div class="card-header p-2 bg-gris text-white">
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
                                            <button type="button" class="btn btn-sm btn-amarillo" id="btn-InsertFila"><span class="fas fa-plus"></span> Agredar</button>
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
                                <table class="table table-sm" style="font-size: 12px">
                                    <tbody>
                                        <tr class="bg-gris">
                                            <th class="text-center">SERIE</th>
                                            <th class="text-center">ERROR</th>
                                        </tr>
                                    </tbody>
                                    <tbody id="tbody_errores">
                                    </tbody>
                                </table>
                            <hr>
                            <button type="button" id="btn-save" class="btn btn-sm btn-block btn-amarillo "> <span class="fas fa-save"></span> GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>




@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/infra/salida.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-salida").addClass('active');
    });
</script>
<script type="text/javascript">
            function salir_pagina(evt , url){
                evt.preventDefault();
                Swal.fire({
                    title: '¿Estas seguro de salir?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F9C846',
                    cancelButtonColor: '#329F5B',
                    confirmButtonText: '¡Si, Continuar!',
                    cancelButtonText: 'Cancelar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = url;
                    }
                })
            }
</script>
<!--Fin Scripts-->
