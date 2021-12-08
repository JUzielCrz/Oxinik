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
                {{-- SALIDA --}}
                <div class="card">
                    
                    <div class="card-header">
                        <div class="row m-0 p-0">
                            <div class="col-md-2 ">
                                <button class="btn btn-amarillo btn-block " onclick="return window.history.back();"><span class="fas fa-arrow-circle-left"></span></button>
                            </div>
                            <div class="col m-0">
                                <strong>REGISTRO DE SALIDA</strong>
                            </div>
                            <div class="col text-right" >
                                #Nota: <strong>{{$nota->id}}</strong>
                                <input type="hidden" name="idnota" id="idnota" value="{{$nota->id}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body" >
                        <div class="form-row" style="font-size: 13px">
                            <div class="col">
                                <label for="">Cliente:</label>
                                <input name="nombre_cliente" id="nombre_cliente" type="text" value="{{$cliente->nombre}}" class="form-control form-control-sm solo-texto" disabled>
                            </div>
                            <div class="col">
                                <label for="">Telefono:</label>
                                <input name="telefono" id="telefono" type="number" value="{{$cliente->telefono}}" class="form-control form-control-sm numero-entero-positivo lenght-telefono" >
                                <span  id="telefonoError" class="text-danger"></span>
                            </div>
                            <div class="col">
                                <label for="">Correo:</label>
                                <input name="email" id="email" type="email" class="form-control form-control-sm" value="{{$cliente->email}}" >
                                <span id="emailError" class="text-danger"></span>
                            </div>
                            <!-- RFC-->
                            <div class="col">
                                <label>RFC</label>
                                <input name="rfc" id="rfc" type="text" value="{{$cliente->rfc}}" class="form-control form-control-sm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <span id="rfcError" class="text-danger"></span>
                            </div>
                        </div>  
                        <div class="form-row mt-2" style="font-size: 13px">
                            <!-- CFDI-->
                            <div class="col">
                                <label for="">CFDI: </label>
                                <input name="cfdi" id="cfdi" type="text" value="{{$cliente->cfdi}}" class="form-control form-control-sm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <span id="cfdiError" class="text-danger"></span>
                            </div>

                            <!-- direccion factura-->
                            <div class="col">
                                <label for="">Direccion Factura:</label>
                                <textarea name="direccion_factura" id="direccion_factura" cols="30" rows="1" class="form-control form-control-sm"> {{$cliente->direccion_factura}}</textarea>
                                <span id="direccion_facturaError" class="text-danger"></span>
                            </div>
                            <!-- Direccion-->
                            <div class="col">
                                <label for="">Dirección Cliente:</label>
                                <textarea name="direccion" id="direccion" cols="30" rows="1" class="form-control form-control-sm" > {{$cliente->direccion}}</textarea>
                                <span id="direccionError" class="text-danger"></span>
                            </div>
                        </div>
                    
                        <hr>
                        <strong>TANQUES ENTREGADOS</strong>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover table-bordered" >
                                <thead >
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">U. M.</th>
                                        <th scope="col">P. U.</th>
                                        <th scope="col">IMPORTE</th>
                                        <th scope="col">IVA 16%</th>
                                    </tr>
                                </thead>
                                
                                <tbody style="font-size: 13px">
                                    @foreach ($tanques as $tanque)
                                        <tr class="tr-cilindros-entrada">
                                            <td class="p-0 text-center">{{$tanque->num_serie}}</td> <input type="hidden" name="inputNumSerie[]" value={{$tanque->num_serie}}>
                                            <td class="p-0 text-center">{{$tanque->tapa_tanque}}</td>
                                            <td class="p-0 text-center">{{$tanque->cantidad}}</td>
                                            <td class="p-0 text-center">{{$tanque->unidad_medida}}</td>
                                            <td class="p-0 text-center">$ {{$tanque->precio_unitario}}</td>
                                            <td class="p-0 text-center">$ {{$tanque->importe}}</td>
                                            <td class="p-0 text-center">$ {{$tanque->iva_particular}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
            
                            </table>
                        </div>
                    </div>
                    {{-- TANQUES DE ENTRADA --}}
                    <div class="card-header pb-0">
                        <p class="mb-0 pb-0 mt-2"><strong>REGISTRA TANQUES DE ENTRADA</strong></p>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"># Serie:</span>
                                    </div>
                                    <input type="text" name="serie_tanque_entrada" id="serie_tanque_entrada" class="form-control form-control-sm" placeholder="#Serie" >
                                </div>
                                <span  id="serie_tanque_entradaError" class="text-danger"></span>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"># Tapa:</span>
                                    </div>
                                    <select name="tapa_tanque_entrada" id="tapa_tanque_entrada" class="form-control form-control-sm">
                                        <option value="">Selecciona</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                                <span  id="tapa_tanque_entradaError" class="text-danger"></span>
                            </div>

                            <div class="col">
                                <button type="button" class="btn btn-verde btn-sm" id="btn-insert-fila-entrada"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>
                        <div class="table-responsive ">
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
                                <tbody>
                                    @foreach ($tanquesEntrada as $tanq)
                                        <tr class='classfilatanque_entrada' style="font-size: 13px">
                                            <td>{{$tanq->num_serie}}</td>
                                            <td>{{$tanq->material}}, {{$tanq->fabricante}}, {{$tanq->capacidad}}, {{$tanq->tipo_tanque}}</td>
                                            <td>{{$tanq->ph}}</td>
                                            <td>{{$tanq->tapa_tanque}}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
        
                
            </div>
            <div class="col-md-4">
                <div class="card" >
                    <div class="card-body" style="font-size: 13px">
                        <span class="ml-2 "><strong>DATOS DE ENVIO:</strong></span>
                        <hr class="mt-0">
                        <p>
                            <strong>Dirección: </strong> {{$cliente->direccion_envio}} <br>
                            <strong>Referencia: </strong> {{$cliente->referencia_envio}} <br>
                            <strong>Link Ubicacion: </strong> <a target="_blank" class="btn-link" href={{$cliente->link_ubicacion_envio}}>{{$cliente->link_ubicacion_envio}} </a><br>
                        </p>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body" style="font-size: 15px">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="">Subtotal:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="div-subtotal">
                                    <label id='label-subtotal'>$ {{number_format($nota->subtotal,2)}}</label>
                                </div>
                                <input type="hidden" id="input-subtotal" name="input-subtotal" value=0 value={{$nota->subtotal}}>
                            </div>
                        </div>
                        <div class="form-row ">
                            <div class="col-md-6">
                                <label for="">Iva 16%:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="div-ivaGen">
                                    <label id='label-ivaGen'>$ {{number_format($nota->iva_general,2)}}</label>
                                </div>
                                <input type="hidden" id="input-ivaGen" name="input-ivaGen" value=0>
                            </div>
                        </div>

                        <div class="form-row ">
                            <div class="col-md-6">
                                <label for="">Envío:</label>
                            </div>
                            <div class="col-md-5 text-right">
                                <div id="div-precio-envio">
                                    <label id='label-precio-envio'>$ {{number_format($nota->precio_envio,2)}}</label>
                                </div>
                                <input type="hidden" id="precio_envio" name="precio_envio" value=0>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-5">
                                <label for="">TOTAL:</label>
                            </div>
                            <div class="col-md-6 text-right">
                                <div id="div-total">
                                    <label id='label-total'>$ {{number_format($nota->total,2)}}</label>
                                </div>
                                <input type="hidden" id="input-total" name="input-total">
                            </div>
                        </div>

                        <hr>

                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Metodo de pago:</span>
                                </div>
                                <input type="text" name="metodo_pago" id="metodo_pago" value={{$nota->metodo_pago}}  class="form-control form-control-sm" disabled>
                            </div>
                            <span id="metodo_pagoError" class="alert-danger  mb-3"></span>
                        </div> 
                        @if ($nota->metodo_pago == 'Credito')
                        
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Pago Cubierto:</span>
                                </div>
                                <select name="pago_cubierto" id="pago_cubierto" class="form-control form-control-sm">
                                    <option value=1 @if ($nota->pago_cubierto == true) selected  @endif>Pagado</option>
                                    <option value=0 @if ($nota->pago_cubierto == false) selected  @endif>Adeuda</option>
                                </select>
                            </div>
                            <span id="metodo_pagoError" class="alert-danger  mb-3"></span>
                        </div> 
                        @endif
                        
                        <hr>

                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-verde" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-verde ml-2" id="guardar-nota">Guardar</button>
                            {{-- <button type="button" class="btn btn-amarillo" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>


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
<script src="{{ asset('js/notas/foranea/entrada.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-foranea").addClass('active');
    });
</script>
<!--Fin Scripts-->