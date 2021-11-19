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
                                <input name="nombre_cliente" id="nombre_cliente" type="text" value="{{$nota->nombre_cliente}}" class="form-control form-control-sm solo-texto" disabled>
                            </div>
                            <div class="col">
                                <label for="">Telefono:</label>
                                <input name="telefono" id="telefono" type="number" value="{{$nota->telefono}}" class="form-control form-control-sm numero-entero-positivo lenght-telefono" >
                                <span  id="telefonoError" class="text-danger"></span>
                            </div>
                            <div class="col">
                                <label for="">Correo:</label>
                                <input name="email" id="email" type="email" class="form-control form-control-sm" value="{{$nota->email}}" >
                                <span id="emailError" class="text-danger"></span>
                            </div>
                            <!-- RFC-->
                            <div class="col">
                                <label>RFC</label>
                                <input name="rfc" id="rfc" type="text" value="{{$nota->rfc}}" class="form-control form-control-sm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <span id="rfcError" class="text-danger"></span>
                            </div>
                        </div>  
                        <div class="form-row mt-2" style="font-size: 13px">
                            <!-- CFDI-->
                            <div class="col">
                                <label for="">CFDI: </label>
                                <input name="cfdi" id="cfdi" type="text" value="{{$nota->cfdi}}" class="form-control form-control-sm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <span id="cfdiError" class="text-danger"></span>
                            </div>

                            <!-- direccion factura-->
                            <div class="col">
                                <label for="">Direccion Factura:</label>
                                <textarea name="direccion_factura" id="direccion_factura" cols="30" rows="1" class="form-control form-control-sm"> {{$nota->direccion_factura}}</textarea>
                                <span id="direccion_facturaError" class="text-danger"></span>
                            </div>
                            <!-- Direccion-->
                            <div class="col">
                                <label for="">Dirección Cliente:</label>
                                <textarea name="direccion" id="direccion" cols="30" rows="1" class="form-control form-control-sm" > {{$nota->direccion}}</textarea>
                                <span id="direccionError" class="text-danger"></span>
                            </div>
                        </div>
                    
                        <hr>
                        <strong>TANQUES ENTRADA</strong>
                        <div class="table-responsive ">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">DESCRIPCIÓN</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">P.U.</th>
                                        <th scope="col">IMPORTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tanquesEntrada as $tanq)
                                        <tr class='classfilatanque_entrada' style="font-size: 13px">
                                            <td>{{$tanq->num_serie}}</td><input type="hidden" name="inputNumSerie_entrada[]" value={{$tanq->num_serie}}>
                                            <td>{{$tanq->material}}, {{$tanq->fabricante}}, {{$tanq->tipo_tanque}}</td>
                                            <td>{{$tanq->ph}}</td>
                                            <td>{{$tanq->tapa_tanque}}</td>
                                            <td>{{$tanq->cantidad}} {{$tanq->unidad_medida}}</td>
                                            <td>{{$tanq->precio_unitario}}</td>
                                            <td>{{$tanq->importe}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="tbody-tanques-entrada" style="font-size: 13px">
                                </tbody>
            
                            </table>
                        </div>
                    </div>
                    {{-- TANQUES DE ENTRADA --}}
                    <div class="card-header pb-0">
                        <p class="mb-0 pb-0 mt-2"><strong>REGISTRA SALIDA DE TANQUES</strong></p>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Serie:</span>
                                    </div>
                                    <input type="text" name="serie_tanque" id="serie_tanque" class="form-control form-control-sm" placeholder="#" required>
                                </div>                                
                            </div>
                            <div class="col ">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Tapa:</span>
                                    </div>
                                    <select name="tapa_tanque" id="tapa_tanque" class="form-control form-control-sm">
                                        <option value="">SELECCIONA</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>   
                                <span  id="tapa_tanqueError" class="text-danger"></span>
                            </div>
                            
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-verde" id="btn-insert-fila-salida"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>
                        <span  id="serie_tanqueError" class="text-danger"></span>
                        <div class="table-responsive ">
                            <table class="table table-sm table-hover table-bordered" >
                                <thead >
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">DESCRIPCIÓN</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 13px">
                                    @foreach ($tanques as $tanque)
                                        <tr class="classfilatanque_salida">
                                            <td>{{$tanque->num_serie}}</td> 
                                            {{-- <input type="hidden" name="inputNumSerie_salida[]" value={{$tanque->num_serie}}> --}}
                                            <td>{{$tanque->tapa_tanque}}</td>
                                            <td>{{$tanq->material}}, {{$tanq->fabricante}}, {{$tanq->tipo_tanque}}, PH: {{$tanque->ph}}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="tablelistaTanques">
                                </tbody>
            
                            </table>
                        </div>
                        <center>
                            <div id="msg-tanques-salida" style="display:none" class="alert" role="alert">
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
                            <strong>Dirección: </strong> {{$nota->direccion_envio}} <br>
                            <strong>Referencia: </strong> {{$nota->referencia_envio}} <br>
                            <strong>Link Ubicacion: </strong> <a target="_blank" class="btn-link" href={{$nota->link_ubicacion_envio}}>{{$nota->link_ubicacion_envio}} </a><br>
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





@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/talon/edit.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-talon").addClass('active');
    });
</script>
<!--Fin Scripts-->