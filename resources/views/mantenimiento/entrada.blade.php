@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('mantenimiento.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <form id="formCreateMantenimiento">
        @csrf
        <input type="hidden" name="nota_id" id="nota_id" value={{$nota->id}}>
        <input type="hidden" id="pendiente" >

        <input type="hidden" name="incidencia" id="incidencia"  value="ENTRADA">
        <div class="card">
            
        </div>

            <div class="row mt-2">
                <div class="col-md-9">
                    <div class="card" >
                        <div class="card-header p-2 bg-gris text-white">
                            <div class="col-md-9">
                                <h5>TANQUES SALIDA</h5>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-sm table-hover" style="font-size: 13px">
                                <thead>
                                    <tr>
                                        <th>#SERIE</th>
                                        <th>DESCRIPCIÓN</th>
                                        <th>#TALON</th>
                                    </tr>
                                </thead>
                                @inject('tipoeva','App\Http\Controllers\CatalogoGasController')
                                <tbody>
                                    @foreach ($tanques as $tanq)
                                    @if ($tanq->incidencia == 'SALIDA')
                                        <tr class="trFilaTanque_salida">
                                            <td>{{$tanq->num_serie}}</td>
                                            <td>{{$tipoeva->nombre_gas($tanq->tipo_gas)}}, {{$tanq->capacidad}}, {{$tanq->fabricante}}, {{$tanq->material}}, {{$tanq->tipo_tanque}}</td>
                                            <td>{{$tanq->folio_talon}}</td>
                                        </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header p-2 bg-gris text-white ">
                            <div class="col-md-9">
                                <h5>REG. ENTRADA</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class=" row">
                                <div class="col ">
                                    <label for="">Serie</label>
                                    <input type="text" name="serie_tanque" id="serie_tanque" class="form-control form-control-sm bool_disabled" placeholder="#Serie" >
                                    <span class="text-danger" id="serie_tanqueError"></span>
                                </div>
                                <div class="col ">
                                    <label for="">PH</label>
                                    <div class="row p-0 m-0">
                                        <div class="form-group col p-0 m-0">
                                            <select name="ph_mes" id="ph_mes" class="form-control form-control-sm bool_disabled">
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
                                    <button type="button" class="btn btn-sm btn-amarillo bool_disabled" id="btn-InsertFila"><span class="fas fa-plus"></span> Agredar</button>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th scope="col">SERIE</th>
                                            <th scope="col">DESCRIPCIÓN</th>
                                            <th scope="col">PH</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tanques as $tanq)
                                        @if ($tanq->incidencia == 'ENTRADA')
                                            <tr class="trFilaTanque">
                                                <td>{{$tanq->num_serie}}</td>
                                                <td>{{$tipoeva->nombre_gas($tanq->tipo_gas)}}, {{$tanq->capacidad}}, {{$tanq->fabricante}}, {{$tanq->material}}, {{$tanq->tipo_tanque}}</td>
                                                <td> {{$tanq->ph}}</td>
                                                <td>{{$tanq->folio_talon}}</td>
                                            </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
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
                            <button type="button" id="btn-save" class="btn btn-sm btn-block btn-amarillo bool_disabled"> <span class="fas fa-save"></span> GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>




@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/mantenimiento/entrada.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-entrada").addClass('active');
    });
</script>
<!--Fin Scripts-->
