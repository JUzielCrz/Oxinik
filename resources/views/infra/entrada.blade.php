@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <form id="formCreateInfra">
        @csrf
        <input type="hidden" name="nota_id" value={{$nota->id}}>
        <div class="card">
            <div class="card-header p-2 bg-gris text-white">
                <div class="row">
                    <div class="col-md-9">
                        <h5 >ENTRADA TANQUES <strong>INFRA</strong></h5>
                    </div>
                </div>
            </div>
        </div>
            <div class="row mt-2">
                <div class="col-md-8">
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
                                        @foreach ($tanques as $tanque)
                                            <tr class='trFilaTanque'>
                                                <td>{{$tanque->num_serie}}</td> <input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value={{$tanque->num_serie}}>
                                                <td>{{$tanque->capacidad}}</td> 
                                                <td>{{$tanque->material}}</td>
                                                <td>{{$tanque->ph}}</td>
                                                <td>{{$tanque->fabricante}}</td>
                                                <th scope="col"></th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-group">
                        <div class="card bg-gray" style="height: 8rem;">
                            <div class="card-header text-center p-1"> 
                                SALIDAS
                            </div>
                            <div class="card-body text-center p-0">
                                <h1 id="cantidad_salida_h" class="display-1" style="font-size: 5rem;" > {{$nota->cantidad_salida}}</h1>
                                <input type="hidden" id="cantidad_salida" name="cantidad_salida" value={{$nota->cantidad_salida}}>
                            </div>
                        </div>
                        <div class="card bg-gray" style="height: 8rem;">
                            <div class="card-header text-center p-1"> 
                                ENTRADAS
                            </div>
                            <div class="card-body text-center p-0">
                                <h1 id="cantidad_entrada_h" class="display-1" style="font-size: 5rem;"> 0</h1>
                                <input type="hidden" id="cantidad_entrada" name="cantidad_entrada">
                            </div>
                        </div>
                        <div class="card bg-gray" style="height: 8rem;">
                            <div class="card-header text-center p-1"> 
                                DIFERENCIA
                            </div>
                            <div class="card-body text-center p-0">
                                <h1 id="cantidad_diferencia_h" class="display-1" style="font-size: 5rem;"> 0</h1>
                                <input type="hidden" id="cantidad_diferencia" name="cantidad_diferencia">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                        
                            <table class="table table-sm" style="font-size: 12px">
                                <tbody id="tbody_errores">
                                    <tr class="bg-gris">
                                        <th class="text-center">SERIE</th>
                                        <th class="text-center">ERROR</th>
                                    </tr>
                                </tbody>
                            </table>
                        <hr>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value=0 name="pendiente" @if ($nota->pendiente == false) checked @endif>
                            <label class="form-check-label" for="defaultCheck1">
                                Selecciona si tanques faltantes fueron retenidos o enviados a mantenimiento.
                            </label>
                        </div>
                        <hr>
                        <label for="" class="mt-2">Observaciones</label>
                        <textarea name="observaciones" id="Observaciones" cols="30" rows="2" class="form-control form-control-sm">{{$nota->observaciones}}</textarea>
                        <hr>
                        <button type="button" id="btn-save" class="btn btn-sm btn-block btn-amarillo "> <span class="fas fa-save"></span> GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>

<!-- Modal registrar tanque-->
<div class="modal fade bd-example-modal-lg" id="modal-registrar-tanque" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
                <h4 class="modal-title" id="modalinsertarTitle">Registrar Tanque</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true" class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                    {{-- input --}}
                    
                    @include('tanques.create')
                    
                    {{-- endinputs --}}
                <!-- botones Aceptar y cancelar-->
                <div class="row justify-content-center" >
                    <div class="btn-group col-auto" style="margin:10px" >
                    <button type="button" class="btn btn-amarillo" id="btn-registrar-tanque">Aceptar</button>
                    </div>
                    <div class="btn-group col-auto" style="margin:10px">
                    <button  class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>




@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/infra/entrada.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-entrada").addClass('active');
    });
</script>
<!--Fin Scripts-->
