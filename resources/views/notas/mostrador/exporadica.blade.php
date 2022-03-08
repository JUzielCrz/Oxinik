@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

    <div class="container" >
        
    <form id="idFormNewVenta">
        @csrf
        <div class="row">
            <div class="col-md-8">
                {{-- Entrada --}}
                <div class="card">
                    <div class="card-header">
                        <h5>ENTRADA TANQUES MOSTRADOR</h5>
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-center">
                            
                            <div class="col">
                                {!! Form::label('# Serie') !!}
                                {!! Form::text('serie_tanque_entrada', null, ['id'=>'serie_tanque_entrada', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}
                                <span  id="serie_tanque_entradaError" class="text-danger"></span>
                            </div>
                            <div class="col ">
                                {!! Form::label('Tapa') !!}
                                {{ Form::select('tapa_tanque_entrada',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque_entrada','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="tapa_tanque_entradaError" class="text-danger"></span>
                            </div>

                            <div class="col align-self-end">
                                <button type="button" class="btn btn-verde" id="btn-insert-fila-entrada"> <span class="fas fa-plus"></span>Añadir</button>
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
                                
                                <tbody id="tbody-tanques-entrada" style="font-size: 13px">
                                </tbody>
            
                            </table>
                        </div>
                        <center>
                            <div id="msg-tanques-entrada" style="display:none" class="alert" role="alert">
                            </div>
                        </center>
                    </div>
                </div>
        
                {{-- SALIDA --}}
                <div class="card mt-2">
                    <div class="card-header">
                        <h5>TANQUES SALIDA</h5>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            
                            <div class="col">
                                {!! Form::label('# Serie') !!}
                                {!! Form::text('serie_tanque', null, ['id'=>'serie_tanque', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}
                                
                            </div>
                            <div class="col ">
                                {!! Form::label('Tapa') !!}
                                {{ Form::select('tapa_tanque',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="tapa_tanqueError" class="text-danger"></span>
                            </div>
                            <div class="col ">
                                {!! Form::label('U. M.') !!}
                                {{ Form::select('unidad_medida',['CARGA' => 'CARGA','kg' => 'kg', 'M3' => 'M3'],null,['id' => 'unidad_medida','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="unidad_medidaError" class="text-danger"></span>
                            </div>  
                            <div class="col">
                                {!! Form::label('Cantidad') !!}
                                {!! Form::number('cantidad', null, ['id'=>'cantidad', 'class' => 'form-control form-control-sm numero-decimal-positivo', 'placeholder'=>'0', 'required', 'readonly' ]) !!}
                                <span  id="cantidadError" class="text-danger"></span>
                            </div>
                            
                            <div class="col">
                                {!! Form::label('Precio') !!}
                                {!! Form::number('precio_unitario', null, ['id'=>'precio_unitario', 'class' => 'form-control form-control-sm numero-decimal-positivo', 'placeholder'=>'$0.0', 'required' ]) !!}
                                <span  id="precio_unitarioError" class="text-danger"></span>
                            </div>
                            
                            <div class="col align-self-end">
                                <button type="button" class="btn btn-verde" id="btn-insert-fila-salida"> <span class="fas fa-plus"></span>Añadir</button>
                            </div> 
                        </div>
                        <span  id="serie_tanqueError" class="text-danger"></span>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover table-bordered" >
                                <thead >
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">GAS</th>
                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">U. M.</th>
                                        <th scope="col">IMPORTE</th>
                                        <th scope="col">IVA 16%</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                
                                <tbody id="tablelistaTanques" style="font-size: 13px">
                                </tbody>
            
                            </table>
                        </div>
                        <center>
                            <div id="msg-tanques-salida" style="display:none" class="alert" role="alert">
                            </div>
                        </center>
                    </div>
                </div>

                {{-- OBSERVACIONES --}}
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Observaciones Generales</label>
                                <textarea name="observaciones" id="observaciones" cols="30" rows="1" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">          
                @include('clientes_sc.search')
                @include('clientes_sc.show')

                <div class="card mt-2">
                    <div class="card-body">
                        <div class="form-row ">
                            <div class="col-md-6">
                                <label for="">Subtotal:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="div-subtotal">
                                    <label id='label-subtotal'>$0.0</label>
                                </div>
                                <input type="hidden" id="input-subtotal" name="input-subtotal" value=0>
                            </div>
                        </div>
                        <div class="form-row ">
                            <div class="col-md-6">
                                <label for="">Iva 16%:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="div-ivaGen">
                                    <label id='label-ivaGen'>$0.0</label>
                                </div>
                                <input type="hidden" id="input-ivaGen" name="input-ivaGen" value=0>
                            </div>
                        </div>

                        {{-- <div class="form-row ">
                            <div class="col-md-6">
                                <label for="">Envío:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="div-precio-envio">
                                    <label id='label-precio-envio'>$0.0</label>
                                </div>
                                <input type="hidden" id="precio_envio" name="precio_envio" value=0>
                            </div>
                        </div> --}}
                        <div id="row-envio" >
                            <button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>
                        </div>

                        <input id="precio_envio_nota" name="precio_envio_nota" type="hidden" value=0 >
                        <hr>

                        <div class="row">
                            <div class="col-md-5">
                                <label for="">TOTAL: $ </label>
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
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Metodo de pago:</span>
                                </div>
                                {{ Form::select('metodo_pago',[
                                    'Efectivo' => 'Efectivo',
                                    'Transferencia' => 'Transferencia', 
                                    'Tarjeta Credito' => 'Tarjeta Credito', 
                                    'Tarjeta Debito' => 'Tarjeta Debito',  
                                    'Cheque' => 'Cheque'
                                    ],null,['id' => 'metodo_pago','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}}
                            </div>
                            <span id="metodo_pagoError" class="alert-danger  mb-2"></span>
                        </div> 

                        
                        <div class="form-row" id="row-ingreso-efectivo">
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Ingreso de Efectivo:</span>
                                </div>
                                <input id="ingreso-efectivo" type="number" class="form-control" value=0 disabled>
                            </div>
                            <span id="ingreso-efectivoError" class="alert-danger"></span>
                        </div>
                        
                        <hr>

                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-verde" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-verde ml-2" id="btn-pagar-nota">Pagar</button>
                            {{-- <button type="button" class="btn btn-amarillo" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>



    <!-- REGITRAR TANQUE-->
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
                
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-verde" data-dismiss="modal">Cancelar</button> --}}
            <button id="guardar-nota" type="button" class="btn btn-verde">Guardar</button>
            </div>
        </div>
        </div>
    </div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/exporadica/index.js') }}"></script>
<script src="{{ asset('js/clientes_sc/edit_save.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#id-menu-mostrador").addClass('active');
    });
</script>
<!--Fin Scripts-->