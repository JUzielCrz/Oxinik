@extends('layouts.navbar')
@section('contentnavbar')

<style>
    body {
        background-color: #e8ebf7;
    }
</style>

    <div class="container ">
        
    <form id="idFormNewVenta">
        <div class="card" >
            <div class="card-header">
                <h3>VENTA EXPORADICA</h3>
            </div>
            <div class="card-body">
                <center>
                    <div id="divmsgnota" style="display:none" class="alert" role="alert">
                    </div>
                </center>
                @csrf
                {{-- <label class="text-danger">* OBLIGATORIO </label>      --}}
                
                <!-- Nombre Completo-->
                <div class="row">
                    <div class="form-group col-md-4">
                        {!! Form::label('Cliente*') !!}
                        {!! Form::text('cliente', null, ['id'=>'cliente', 'class' => 'form-control solo-text', 'placeholder'=>'Nombre Completo', 'required' ]) !!}
                        <span  id="clienteError" class="text-danger"></span>
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('Telefono*') !!}
                        {!! Form::number('telefono', null, ['id'=>'telefono', 'class' => 'form-control telefono', 'placeholder'=>'# Telefono', 'required' ]) !!}
                        <span  id="telefonoError" class="text-danger"></span>
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('Correo Electronico*') !!}
                        {!! Form::email('email', null, ['id'=>'email', 'class' => 'form-control', 'placeholder'=>'Correo Electronico']) !!}
                        <span  id="emailError" class="text-danger"></span>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {!! Form::label('Dirección*') !!}
                        {!! Form::textarea('direccion', null, [ 'id'=>'direccion', 'class' => 'form-control', 'rows' => 2,'placeholder'=>'Dirección']) !!}
                        <span  id="direccionError" class="text-danger"></span>
                    </div>  
                </div>

                <hr>

                <!-- DATOS FACTURACION-->
                <div id="datosfacturacion">
                    <div class="form-row justify-content-end" id="filaFacturacion">
                        <button type="button" class="btn btn-gray" id="btnFacturacion"><span class="fas fa-plus"></span> Agregar Datos Facturacion</button>
                    </div>

                    <div class="collapse" id="myCollapsible">
                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label>RFC</label>
                                    {!! Form::text('rfc', null, ['id'=>'rfc', 'class' => 'form-control', 'placeholder'=>'RFC']) !!}
                                    <span  id='rfcError' class='text-danger'></span>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label>CFDI</label>
                                    {!! Form::text('cfdi', null, ['id'=>'cfdi', 'class' => 'form-control', 'placeholder'=>'CFDI']) !!}
                                    <span  id='cfdiError' class='text-danger'></span>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label>Metodo de Pago</label>
                                    {{ Form::select('metodo_pago',['Efectivo' => 'Efectivo', 
                                        'Transferencia' => 'Transferencia',
                                        'Tarjeta Credito' => 'Tarjeta Credito',
                                        'Tarjeta Debito' => 'Tarjeta Debito', 
                                        'Cheque' => 'Cheque'],null,['id' => 'metodo_pago','class'=>'form-control', 'placeholder'=>'Selecciona'])}}
                                    <span  id='metodo_pagoError' class='text-danger'></span>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='form-group col-md-6'>
                                    <label>Direccion Factura</label>
                                    {!! Form::textarea('direccion_factura', null, ['id'=>'direccion_factura', 'class' => 'form-control', 'placeholder'=>'Dirección']) !!}
                                    <span  id='direccion_facturaError' class='text-danger'></span>
                                </div>
                                <div class='col-md-6 text-right m-auto mr-3'>
                                        <button type='button' class='btn btn-gray' id='btnFacturacionCancelar'><span class='fas fa-minus mr-2'></span> 'Cancelar Facturación'</button>
                                </div>
                            </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <div class="row justify-content-center">
                    <div class="col-md-6 ">
                        <h4 class="ml-7" style="font-size: 20px">ENTRADA DE TANQUES</h4>
                    </div>
                    <div class="col-md-5 text-right ">
                        <button type="button" class="btn btn-grisclaro " data-toggle="modal" data-target="#modalinsertar"> <span class="fas fa-plus-circle mr-3"></span>Registrar</button>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <center>
                    <div id="divmsgregistrotanques" style="display:none" class="alert" role="alert">
                    </div>
                </center>

                <div class="table-responsive"> 
                    <table id="tablaRegistrarTanque" class="table table-hover table-sm">
                        <thead>
                            <tr>
                            <th scope="col">#Serie</th>
                            <th scope="col">PH</th>
                            <th scope="col">CAPACIDAD</th>
                            <th scope="col">MATERIAL</th>
                            <th scope="col">FABRICANTE</th>
                            <th scope="col">TIPO GAS</th>
                            <th scope="col"></th> 
                            </tr>
                        </thead>
                    </table>
                </div>
                <center>
                    <div id="divmsgentrada" style="display:none" class="alert" role="alert">
                    </div>
                </center>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="ml-5" style="font-size: 20px">SALIDA DE TANQUES</h4>
            </div>
            <div class="card-body">
                
                <div class="row justify-content-center">
                    @csrf
                    <div class="col-md-4">
                        {!! Form::label('# Serie') !!}
                        {!! Form::text('num_seriesalida', null, ['id'=>'num_seriesalida', 'class' => 'form-control', 'placeholder'=>'#Serie', 'required' ]) !!}
                        <span  id="num_seriesalidaError" class="text-danger"></span>
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('Precio') !!}
                        {!! Form::number('preciosalida', null, ['id'=>'preciosalida', 'class' => 'form-control precio', 'placeholder'=>'$0.0', 'required' ]) !!}
                        <span  id="preciosalidaError" class="text-danger"></span>
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('Regulador') !!}
                        {{ Form::select('reguladorsalida',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'reguladorsalida','class'=>'form-control ml-2', 'placeholder'=>'Selecciona', 'required'])}}
                        <span  id="reguladorsalidaError" class="text-danger"></span>
                    </div>  
                    <div class="col-md-2">
                        {!! Form::label('Tapa') !!}
                        {{ Form::select('tapa_tanquesalida',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanquesalida','class'=>'form-control ml-2', 'placeholder'=>'Selecciona', 'required'])}}
                        <span  id="tapa_tanquesalidaError" class="text-danger"></span>
                    </div>  
                    <div class="col-md-2 justify-content-end m-auto" >
                        <button type="button" class="btn btn-grisclaro " id="btnRegSalida"> <span class="fas fa-plus-circle mr-3"></span>Agregar</button>
                    </div> 
                </div>

                <hr>

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
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

                <hr>
                <div class="row ">
                    <div class="col-md-9 text-right">
                        <label for="">TOTAL:</label>
                    </div>
                    <div class="col-md-1 text-right">
                        <div id="preciototal">
                        </div>

                    </div>
                </div>
                <center>
                    <div id="divmsgsalida" style="display:none" class="alert" role="alert">
                    </div>
                </center>
            </div>
        </div>

    

        <div class="card ">
            <div class="card-body ">
                <div class="row justify-content-center">
                        <button type="button" class="btn btn-amarillo" style='width:170px; height:65px' id="btnCancelarAll">Cancelar</button>
                        <button type="button" class="btn btn-amarillo ml-2"  style='width:170px; height:65px' id="btnInsertAll" >Guardar</button>
                </div>
            </div>
        </div>

        <!-- Modal insertar-->
        <div class="modal fade bd-example-modal-lg" id="modalinsertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-onix">
                        <h4 class="modal-title" id="modalinsertarTitle">Registrar Tanque</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                            <span aria-hidden="true" class="fas fa-times"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('ventas.registertanque')
                        <!-- botones Aceptar y cancelar-->
                        <div class="row justify-content-center" >
                            <div class="btn-group col-auto" style="margin:10px" >
                            <button type="submit" class="btn btn-gray" id="btnRegEntrada">Aceptar</button>
                            </div>
                            <div class="btn-group col-auto" style="margin:10px">
                            <button  class="btn btn-gray" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </form>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/ventas/ventatanque.js') }}"></script>
<!--Fin Scripts-->