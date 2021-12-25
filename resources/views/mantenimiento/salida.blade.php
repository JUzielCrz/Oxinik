@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('mantenimiento.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <form id="formCreateMantenimiento">
        @csrf
        <input type="hidden" name="incidencia" id="incidencia" value="SALIDA">
        <div class="card">
            <div class="card-header p-2 bg-gris text-white">
                <div class="row">
                    <div class="col-md-9">
                        <h5 >SALIDA TANQUES <strong>MANTENIMIENTO</strong></h5>
                    </div>
                    <div class="col-md-3 text-right" >
                        <button type="button" id="btn-SaveAll" class="btn btn-sm btn-amarillo "> <span class="fas fa-save"></span> GUARDAR</button>
                    </div>
                </div>
            </div>
        </div>

            <div class="row mt-2">
                <div class="col-md-9">
                    <div class="card" >
                        <div class="card-header">
                            <div class=" row">
                                <div class="col-md-3">
                                    <label for="">#Serie</label>
                                    <input type="text" name="serie_tanque" id="serie_tanque" class="form-control form-control-sm" placeholder="#" >

                                </div>
                                <div class="col-md-4">
                                    <label for="">Folio Talón</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <input type="text" name="folio_talon" id="folio_talon" class="form-control form-control-sm" aria-label="Text input with checkbox"> 
                                            <div class="input-group-text">
                                                <input type="checkbox" name="mantener_folio" id="mantener_folio" aria-label="Checkbox for following text input"> Mantener
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 align-self-end">
                                    <button type="button" class="btn btn-sm btn-amarillo " id="btn-InsertFila"><span class="fas fa-plus"></span> Agredar</button>
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
                                            <th>FABRICANTE</th>
                                            <th>#TALÓN</th>
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
<script src="{{ asset('js/mantenimiento/registro.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-salida").addClass('active');
    });
</script>
<!--Fin Scripts-->
