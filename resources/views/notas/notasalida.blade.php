@extends('layouts.navbar')
@section('contentnavbar')

<style>
    body {
        background-color: #e8ebf7;
    }
</style>


<div class="container-fluid" style="width: 90rem">
    <form id="form-entrada-nota">

        <div class="row">
            <div class="col-md-9">

                <div class="card">
                    <div class="card-header">
                        <h5>Tanques Salida</h5>
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
                            <div class="col">
                                {!! Form::label('cantidad') !!}
                                {!! Form::number('cantidad', null, ['id'=>'cantidad', 'class' => 'form-control form-control-sm', 'placeholder'=>'0', 'required' ]) !!}
                                <span  id="cantidadError" class="text-danger"></span>
                            </div>
                            <div class="col ">
                                {!! Form::label('U. M.') !!}
                                {{ Form::select('unidad_medida',['CARGA' => 'CARGA','kg' => 'kg', 'M3' => 'M3'],null,['id' => 'unidad_medida','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="unidad_medidaError" class="text-danger"></span>
                            </div>  
                            <div class="col">
                                {!! Form::label('P.U.') !!}
                                {!! Form::number('precio_unitario', null, ['id'=>'precio_unitario', 'class' => 'form-control form-control-sm', 'placeholder'=>'$0.0', 'required' ]) !!}
                                <span  id="precio_unitarioError" class="text-danger"></span>
                            </div>
                            
                            <div class="col ">
                                {!! Form::label('IVA') !!}
                                {{ Form::select('iva',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'iva','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="ivaError" class="text-danger"></span>
                            </div> 
                            <div class="col align-self-end">
                                <button type="button" class="btn btn-grisclaro" id="btnInsertFila"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">GAS</th>
                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">U. M.</th>
                                        <th scope="col">P. U.</th>
                                        <th scope="col">IMPORTE</th>
                                        <th scope="col">IVA 16%</th>
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
                            <div class="col">
                                <select name="" id="selectprueba" class="form-control" data-live-search="true">
                                    <option value=""></option>
                                    <option value="">prueba 1</option>
                                    <option value="">prueba 1</option>
                                    <option value="">prueba 1</option>

                                </select>
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-search" id="inputGroup-sizing-sm"></span>
                                </div>
                                <input id="numcontrato" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                            </div>
                        </div>
                        <div id="listarcontratos"></div>
                        
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

                        {{-- ASIGNACION DE TANQUES --}}
                        <div class="form-row">
                            <center>
                                <div id="msg-asignacion-save" style="display:none" class="alert" role="alert" style="font-size: 13px">
                                </div>
                            </center>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Asignación:</span>
                                </div>
                                <input id="asignacion_tanques" type="text" class="form-control text-center" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>
                                <div class="input-group-append" id="button-addon4">
                                    <button class="btn btn-amarillo" type="button" id="btn-modal-asignacion"> <span class="fas fa-edit"></span></button>
                                </div>
                            </div>    
                        </div>

                        {{-- Folio Nota--}}
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Folio nota:</span>
                                </div>
                                <input id="folio_nota" name="folio_nota" type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                            </div>
                            <span id="folio_notaError" class="alert-danger"></span>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">


                        <div class="form-row ">
                            <div class="col-md-6">
                                <label for="">Subtotal:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="subtotal">
                                    <label id='labelsubtotal'>$0.0</label>
                                </div>
                                <input type="hidden" id="inp-subtotal" value=0>
                            </div>
                        </div>
                        <div class="form-row ">
                            <div class="col-md-6">
                                <label for="">Iva 16%:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="iva_general">
                                    <label id='labeliva_general'>$0.0</label>
                                </div>
                                <input type="hidden" id="inp-iva_general" value=0>
                            </div>
                        </div>

                        <center>
                            <div id="msg-envio-save" style="display:none" class="alert" role="alert" style="font-size: 13px">
                            </div>
                        </center>
                        <div id="row-envio" >
                            
                            <button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>
                        </div>
                        <input type="hidden" name="precio_envio" id="precio_envio" value= 0 >

                        <hr>

                        <div class="row">
                            <div class="col-md-5">
                                <label for="">TOTAL:</label>
                            </div>
                            <div class="col-md-6 text-right">
                                <div id="divtotal">
                                    <label id='labeltotal'>$0.0</label>
                                </div>
                                <input type="hidden" id="inp_total" name="inp_total">
                            </div>
                        </div>

                        <hr>

                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Monto a pagar:</span>
                                </div>
                                <input id="monto_pago" name="monto_pago" type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                                {{ Form::select('metodo_pago',[
                                    'Efectivo' => 'Efectivo',
                                    'Transferencia' => 'Transferencia', 
                                    'Tarjeta Credito' => 'Tarjeta Credito', 
                                    'Tarjeta Debito' => 'Tarjeta Debito',  
                                    'Cheque' => 'Cheque'
                                    ],null,['id' => 'metodo_pago','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}}
                            </div>
                            <span id="metodo_pagoError" class="alert-danger"></span>
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
                        
                        <hr>

                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-grisclaro" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-grisclaro ml-2" id="btn-pagar-nota">Pagar</button>
                            {{-- <button type="button" class="btn btn-gray" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div> 

        
        <!-- Modal Pagar-->
        <div class="modal fade" id="static-modal-pago" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
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
                            <div id="divcambio">
                                <label id='labelcambio'>$0.0</label>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <label for="">Adeudo:</label>
                        </div>
                        <div class="col-md-4 text-right">
                            <div id="divadeudo">
                                <label id='labeladeudo'>$0.0</label>
                            </div>
                        </div>
                    </div>
                    
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
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Asignación tanques</h5>
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

    

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/notasalida.js') }}"></script>
<!--Fin Scripts-->
