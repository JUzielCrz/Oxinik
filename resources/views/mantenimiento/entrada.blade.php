@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('mantenimiento.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <form id="formCreateMantenimiento">
        @csrf
        <input type="hidden" name="incidencia" id="incidencia"  value="ENTRADA">
        <div class="card">
            <div class="card-header p-2 bg-gris text-white">
                <div class="row">
                    <div class="col-md-9">
                        <h5 >ENTRADA TANQUES <strong>MANTENIMIENTO</strong></h5>
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
                                <div class="col ">
                                    <label for="">Serie</label>
                                    <input type="text" name="serie_tanque" id="serie_tanque" class="form-control form-control-sm" placeholder="#Serie" >
                                    <span class="text-danger" id="serie_tanqueError"></span>
                                </div>
                                <div class="col ">
                                    <label for="">PH</label>
                                    <div class="row p-0 m-0">
                                        <div class="form-group col p-0 m-0">
                                            <select name="ph_mes" id="ph_mes" class="form-control form-control-sm">
                                                <option value="">Mes</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="form-group col p-0 m-0">
                                            <input type="text" name="ph_anio" id="ph_anio" class="form-control form-control-sm anio_format" disabled>
                                        </div>
                                    </div>
                                    <span  id="phError" class="text-danger"></span>
                                </div>
                                <div class="col text-right align-self-end">
                                    <button type="button" class="btn btn-sm btn-amarillo" id="btn-InsertFila"><span class="fas fa-plus"></span> Agredar</button>
                                </div>
                            </div>
                            
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
        $("#id-menu-entrada").addClass('active');
    });
</script>
<!--Fin Scripts-->
