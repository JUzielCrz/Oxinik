@extends('layouts.navbar')
@section('contentnavbar')

<style>
    body {
        background-color: #e8ebf7;
    }
</style>


<div class="container ">
    <form id="form-entrada-nota">

        <h1 class="display-1">por moificarse</h1>
        <div class="row">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h5>Tanques Salida</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="row justify-content-center">
                            @csrf
                            <div class="col-md-4">
                                {!! Form::label('# Serie') !!}
                                {!! Form::text('serie_tanque', null, ['id'=>'serie_tanque', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}
                                <span  id="serie_tanqueError" class="text-danger"></span>
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('Precio') !!}
                                {!! Form::number('precio', null, ['id'=>'precio', 'class' => 'form-control form-control-sm', 'placeholder'=>'$0.0', 'required' ]) !!}
                                <span  id="precioError" class="text-danger"></span>
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('Regulador') !!}
                                {{ Form::select('regulador',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'regulador','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="reguladorError" class="text-danger"></span>
                            </div>  
                            <div class="col-md-2 ">
                                {!! Form::label('Tapa') !!}
                                {{ Form::select('tapa_tanque',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="tapa_tanqueError" class="text-danger"></span>
                            </div>  
                            <div class="col-md-2 align-self-end">
                                <button type="button" class="btn btn-grisclaro" id="btnInsertFila"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"># SERIE</th>
                                        <th scope="col">DESCRIPCIÓN</th>
                                        <th scope="col">PRECIO</th>
                                        <th scope="col">REGULADOR</th>
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
                                <input id="num_contrato" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled>
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
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Asignación:</span>
                                </div>
                                <input id="asignacion_tanques" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled>
                                <div class="input-group-append" id="button-addon4">
                                    <button class="btn btn-amarillo" type="button"> <span class="fas fa-plus"></span></button>
                                </div>
                            </div>    
                        </div>

                        {{-- Folio Nota--}}
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Folio nota:</span>
                                </div>
                                <input id="folio_nota" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
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
                                <input type="hidden" id="inp-subtotal" name="inputTotal" value=0>
                            </div>
                        </div>

                        <div id="row-envio" >
                            
                            <button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>
                        </div>
                        <input type="hidden" name="precio-envio" id="precio-envio" value= 0 >

                        <hr>

                        <div class="row">
                            <div class="col-md-5">
                                <label for="">TOTAL:</label>
                            </div>
                            <div class="col-md-6 text-right">
                                <div id="divtotal">
                                    <label id='labeltotal'>$0.0</label>
                                </div>
                                <input type="hidden" id="inp-total" name="inputTotal">
                            </div>
                        </div>

                        <hr>

                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Monto a pagar:</span>
                                </div>
                                <input id="monto-pago" type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                                {{ Form::select('metodo_pago',[
                                    'Efectivo' => 'Efectivo',
                                    'Transferencia' => 'Transferencia', 
                                    'Tarjeta Credito' => 'Tarjeta Credito', 
                                    'Tarjeta Debito' => 'Tarjeta Debito',  
                                    'Cheque' => 'Cheque'
                                    ],null,['id' => 'metodo_pago','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}}
                            </div>
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

        
        <!-- Modal -->
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

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/notaentrada.js') }}"></script>
<!--Fin Scripts-->
