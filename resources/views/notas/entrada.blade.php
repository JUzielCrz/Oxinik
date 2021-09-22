@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')



<div class="container">
    
    <form id="form-entrada-nota">
    
        <div class="row">
            <div class="col-md-8">
                <fieldset class="InputsFilaEntrada" disabled="disabled">
                <div class="card">
                    <div class="card-header">
                        <h5>Tanques Entrada</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="row justify-content-center">
                            @csrf
                            <div class="col">
                                {!! Form::label('# Serie') !!}
                                {!! Form::text('serie_tanque', null, ['id'=>'serie_tanque', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}
                                <span  id="serie_tanqueError" class="text-danger"></span>
                            </div>
                            <div class="col ">
                                {!! Form::label('Tapa') !!}
                                {{ Form::select('tapa_tanque',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="tapa_tanqueError" class="text-danger"></span>
                            </div>

                            <div class="col align-self-end">
                                <button type="button" class="btn btn-grisclaro" id="btnInsertFila"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>
                        
                        <hr>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">DESCRIPCIÓN</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">CAMBIO</th>
                                        <th scope="col">RECARGOS</th>
                                        
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                
                                <tbody id="tablelistaTanques">
                                </tbody>
            
                            </table>
                        </div>
                        <center>
                            <div id="msg-tanques" style="display:none" class="alert" role="alert">
                            </div>
                        </center>
                    </div>
                </div>
                </fieldset>

                
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Pendientes</h5>
                        </div>
                        <div class="card-body">
                            <span  id="serie_tanqueError" class="text-danger"></span>
                            <div class="table-responsive">
                                <table id="table-tanques-nota" class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr style="font-size: 13px">
                                            <th scope="col">#SERIE</th>
                                            <th scope="col">DESCRIPCIÓN</th>
                                            <th scope="col">TAPA</th>
                                            <th scope="col">FECHA</th>
                                            <th scope="col">NOTA</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody id="tbody-tanques-nota">
                                    </tbody>
                                </table>
                            </div>
                            <center>
                                <div id="msg-tanques" style="display:none" class="alert" role="alert">
                                </div>
                            </center>
                        </div>
                    </div>
            </div>
            
            <div class="col-md-4">
                <div class="card " >
                    <div class="card-body">
                        
                        @csrf

                        <center>
                            <div id="msg-contrato" style="display:none" class="alert" role="alert">
                            </div>
                        </center>

                        <div class="row">
                            <input type="hidden"  name="contrato_id" id="contrato_id">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-search" id="inputGroup-sizing-sm"></span>
                                </div>
                                <input id="search-contrato-id" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                            </div>
                        </div>
                        <div id="listar-contratos"></div>
                        
                        <hr>
                        {{-- Cliente--}}
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Cliente:</span>
                                </div>
                                <input id="nombre_cliente" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled>
                            </div>
                        </div>
                        {{-- Numero contrato--}}
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"># Contrato:</span>
                                </div>
                                <input id="num_contrato" name="num_contrato" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        {{-- tipo contrato--}}
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Tipo:</span>
                                </div>
                                <input id="tipo_contrato" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <div class="row" >
                            <div class="col">
                                <p>ASIGNACIONES</p>
                            </div>
                            {{-- <div class="col-4-md">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-amarillo" type="button" id="btn-modal-asignacion-minus"> <span class="fas fa-minus"></span></button>
                                    </div>
                                    <div class="input-group-prepend">
                                        <button class="btn btn-amarillo" type="button" id="btn-modal-asignacion-plus"> <span class="fas fa-plus"></span></button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                            <div id="content-asignaciones">
                                
                            </div>
                    </div>
                </div>
                <fieldset class="InputsFilaEntrada" disabled="disabled">
                <div class="card mt-2">
                    <div class="card-body">

                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Recargos por tapa:</span>
                                </div>
                                <input id="recargosXtapa" name="recargosXtapa" type="number" class="form-control" value=0 aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>
                            </div>
                        </div> 

                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Otros Recargos:</span>
                                </div>
                                <input id="recargos" name="recargos" type="number" value=0 class="form-control numero-decimal-positivo" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                            </div>
                            <span id="recargosError" class="alert-danger  mb-3"></span>
                        </div> 

                        <hr>

                        <div class="row">
                            <div class="col-md-5">
                                <label for="">TOTAL:</label>
                            </div>
                            <div class="col-md-6 text-right">
                                <div id="div-total">
                                    <label id='label-total'>$0.0</label>
                                </div>
                                <input type="hidden" id="input-total" name="input-total">
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Metodo de Pago:</span>
                                </div>
                                {{ Form::select('metodo_pago',[
                                    'Efectivo' => 'Efectivo',
                                    'Transferencia' => 'Transferencia', 
                                    'Tarjeta Credito' => 'Tarjeta Credito', 
                                    'Tarjeta Debito' => 'Tarjeta Debito',  
                                    'Cheque' => 'Cheque'
                                    ],null,['id' => 'metodo_pago','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}}
                            </div>
                            <span id="metodo_pagoError" class="alert-danger  mb-3"></span>
                        </div> 

                        
                        <div class="form-row" id="row-ingreso-efectivo">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Ingreso de Efectivo:</span>
                                </div>
                                <input id="ingreso-efectivo" type="number" class="form-control" value=0 disabled>
                            </div>
                            <span id="ingreso-efectivoError" class="alert-danger"></span>
                        </div>
                        
                        <div class="form-row">
                            <div class="col">
                                <label for="">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <hr>

                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-grisclaro" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-grisclaro ml-2" id="btn-pagar-nota">Continuar</button>
                            {{-- <button type="button" class="btn btn-gray" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
                    </div>
                </div>
                </fieldset>
            </div>

        </div> 

        
        <!-- Modal Pagar-->
        <div class="modal fade" id="static-modal-pago" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Resumén</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                
                    {{-- FOrmulario --}}
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <label for="">Cambio:</label>
                        </div>
                        <div class="col-md-4 text-right">
                            <div id="div-cambio">
                                <label id='label-cambio'>$0.0</label>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row justify-content-center">
                        <div class="col-md-4">
                            <label for="">Adeudo:</label>
                        </div>
                        <div class="col-md-4 text-right">
                            <div id="div-adeudo">
                                <label id='label-adeudo'>$0.0</label>
                            </div>
                        </div>
                    </div> --}}
                    
                </div>
                <div class="modal-footer">
                {{-- <button type="button" class="btn btn-grisclaro" data-dismiss="modal">Cancelar</button> --}}
                <button id="guardar-nota" type="button" class="btn btn-verde">Guardar</button>
                </div>
            </div>
            </div>
        </div>

    </form>
    
</div>




  


    <!-- Modal generico-->
    {{-- <div class="modal fade bd-example-modal-lg" id="modal_generico" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"> --}}
    <div class="modal fade" id="modal_generico" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-onix">
                    <h4 class="modal-title" id="modal_generico_titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center"></div>
                        <div id='modal_general_contenido'>
                            {{-- contenido insertado con js --}}
                        </div>
                    <div class="row justify-content-center" >
                        <div id='modal_general_botones' ></div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>


    
@endsection

@include('layouts.scripts')
<!--Scripts-->

<script src="{{ asset('js/notas/entrada.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#id-menu-entrada").removeClass('btn-outline-success');
        $("#id-menu-entrada").addClass('btn-success');
    });
</script>

<!--Fin Scripts-->
