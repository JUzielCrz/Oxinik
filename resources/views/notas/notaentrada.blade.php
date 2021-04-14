@extends('layouts.navbar')
@section('contentnavbar')

<head>
    <link href="{{asset('selects/select2.min.css')}}" rel="stylesheet">
</head>
<style>
    body {
        background-color: #e8ebf7;
    }
</style>


<div class="container-fluid" style="width: 90rem">
    
    <form id="form-entrada-nota">
    
        <div class="row">
            <div class="col-md-9">
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
                                            <th scope="col">TAPA</th>
                                            <th scope="col">FOLIO NOTA</th>
                                            <th scope="col">FECHA</th>
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
            
            <div class="col-md-3">
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
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Recargos:</span>
                                </div>
                                <input id="recargos" name="recargos" type="number" class="form-control numero-decimal-positivo" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
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
                        {{-- <div class="form-row ">
                            <div class="col-md-6">
                                <label for="">Subtotal:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="div-subtotal">
                                    <label id='label-subtotal'>$0.0</label>
                                </div>
                                <input type="hidden" id="input-subtotal" name="input-subtotal" value=0>
                            </div>
                        </div> --}}
                        {{-- <div class="form-row ">
                            <div class="col-md-6">
                                <label for="">Iva 16%:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="div-ivaGen">
                                    <label id='label-ivaGen'>$0.0</label>
                                </div>
                                <input type="hidden" id="input-ivaGen" name="input-ivaGen" value=0>
                            </div>
                        </div> --}}

                        {{-- <hr>

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
                        </div> --}}

                        {{-- <hr> --}}

                        {{-- <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Monto a pagar:</span>
                                </div>
                                <input id="monto_pago" name="monto_pago" type="number" class="form-control numero-decimal-positivo" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                                {{ Form::select('metodo_pago',[
                                    'Efectivo' => 'Efectivo',
                                    'Transferencia' => 'Transferencia', 
                                    'Tarjeta Credito' => 'Tarjeta Credito', 
                                    'Tarjeta Debito' => 'Tarjeta Debito',  
                                    'Cheque' => 'Cheque'
                                    ],null,['id' => 'metodo_pago','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}}
                            </div>
                            <span id="metodo_pagoError" class="alert-danger  mb-3"></span>
                        </div>  --}}

                        
                        <div class="form-row" id="row-ingreso-efectivo">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Ingreso de Efectivo:</span>
                                </div>
                                <input id="ingreso-efectivo" type="number" class="form-control" value=0 disabled>
                            </div>
                            <span id="ingreso-efectivoError" class="alert-danger"></span>
                        </div>
                        
                        <hr>

                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-grisclaro" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-grisclaro ml-2" id="btn-pagar-nota">Pagar</button>
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


        <!-- Modal Edit envio-->
        <div class="modal fade" id="modal-edit-evio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Editar Envío</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                
                    @include('notas.editenvio')
                </div>
                <div class="modal-footer">
                {{-- <button type="button" class="btn btn-grisclaro" data-dismiss="modal">Cancelar</button> --}}
                <button id="btn-save-envio" type="button" class="btn btn-verde">Guardar</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal Edit Asignacion de tanques en contrato-->
    <div class="modal fade" id="modal-edit-asignacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="h5-title-modal"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                @include('contratos.asignaciontanques')
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-grisclaro" data-dismiss="modal">Cancelar</button> --}}
            <button id="btn-save-asignacion" type="button" class="btn btn-verde">Guardar</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal Info tanque-->
    <div class="modal fade bd-example-modal-md" id="modalmostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h1 class="modal-title" id="modalmostrarTitle">Informacion</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('tanques.info')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto" style="margin:10px">
                <button type="reset" class="btn btn-gray" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>

    <!-- Modal devolucion tanque NO encontrado-->
    <div class="modal fade bd-example-modal-lg" id="modal-registrar-tanque" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-onix">
                    <h4 class="modal-title" id="modalinsertarTitle">Registrar Tanque</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
                <div class="modal-body">
                        {{-- input --}}
                        
                        @include('notas.registrar_tanque')
                        
                        {{-- endinputs --}}
                    <!-- botones Aceptar y cancelar-->
                    <div class="row justify-content-center" >
                        <div class="btn-group col-auto" style="margin:10px" >
                        <button type="button" class="btn btn-gray" id="btn-registrar-tanque">Aceptar</button>
                        </div>
                        <div class="btn-group col-auto" style="margin:10px">
                        <button  class="btn btn-gray" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/notaentrada.js') }}"></script>
<!--Fin Scripts-->
