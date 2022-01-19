@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

    <div class="container" >
        @inject('tipoeva','App\Http\Controllers\CatalogoGasController')
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

                        <strong>TANQUES ENTREGADOS</strong>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover table-bordered" >
                                <thead >
                                    <tr style="font-size: 13px">
                                        <th scope="col">#</th>
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">GAS</th>
                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">U. M.</th>
                                        <th scope="col">P. U.</th>
                                        <th scope="col">IMPORTE</th>
                                        <th scope="col">IVA 16%</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                
                                <tbody style="font-size: 13px">
                                    @php
                                        $contador=0;
                                    @endphp
                                    @csrf
                                    @foreach ($tanques as $tanque)
                                        <tr class="tr-cilindros-salida">
                                            <td>{{$contador+=1}}</td>
                                            <td class="p-0 text-center">{{$tanque->num_serie}}</td> <input type="hidden" name="inputNumSerie[]" value={{$tanque->num_serie}}>
                                            <td class="p-0 text-center">{{$tanque->tapa_tanque}}</td>
                                            <td class="p-0 text-center">{{$tipoeva->nombre_gas($tanque->tipo_gas)}}</td>
                                            <td class="p-0 text-center">{{$tanque->cantidad}}</td>
                                            <td class="p-0 text-center">{{$tanque->unidad_medida}}</td>
                                            <td class="p-0 text-center">{{$tanque->precio_unitario}}</td>
                                            <td class="p-0 text-center">{{$tanque->importe}}</td>
                                            <td class="p-0 text-center">{{$tanque->iva_particular}}</td>
                                            <td><button type="button" class="btn btn-naranja" id="btn-eliminar-salida"><span class="fas fa-window-close"></span></button></td>
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
                                    <input type="text" name="serie_tanque_entrada" id="serie_tanque_entrada" class="form-control form-control-sm bool_disabled" placeholder="#Serie" >
                                </div>
                                <span  id="serie_tanque_entradaError" class="text-danger"></span>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"># Tapa:</span>
                                    </div>
                                    <select name="tapa_tanque_entrada" id="tapa_tanque_entrada" class="form-control form-control-sm bool_disabled">
                                        <option value="">Selecciona</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                                <span  id="tapa_tanque_entradaError" class="text-danger"></span>
                            </div>

                            <div class="col">
                                <button type="button" class="btn btn-verde btn-sm bool_disabled" id="btn-insert-fila-entrada"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>
                        <div class="table-responsive ">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th>#</th>
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">DESCRIPCIÓN</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">TAPA</th>
                                        
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $contador=0;
                                    @endphp
                                    @foreach ($tanquesEntrada as $tanq)
                                        <tr class='tr-cilindros-entrada' style="font-size: 13px">
                                            <td>{{$contador+=1}}</td>
                                            <td>{{$tanq->num_serie}}</td> <input type='hidden' name='inputNumSerie_entrada[]' id='idInputNumSerie_entrada' value='{{$tanq->num_serie}}'>
                                            <td>{{$tanq->capacidad}}, {{$tanq->material}}, {{$tanq->fabricante}}, {{$tanq->tipo_tanque}}, {{$tipoeva->nombre_gas($tanq->tipo_gas)}}</td><input type='hidden' name='inputDescripcion_entrada[]' value='descrp '>
                                            <td>{{$tanq->ph}} </td><input type='hidden' name='inputPh_entrada[]' value='{{$tanq->ph}}'>
                                            <td>{{$tanq->tapa_tanque}}</td> <input type='hidden' name='inputTapa_entrada[]' value='{{$tanq->tapa_tanque}}'>
                                            <input type='hidden' name='inputRegistro[]' value=0>
                                            <td><button type="button" class="btn btn-naranja" id="btnEliminarFila"><span class="fas fa-window-close"></span></button></td>
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
                {{-- OBSERVACIONES --}}
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Observaciones Generales</label>
                                <textarea name="observaciones" id="observaciones" cols="30" rows="1" class="form-control bool_disabled"> {{$nota->observaciones}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
                {{-- DATOS  CLIENTE --}}
                <div class="card mt-2">
                    <div class="card-header p-2" >
                        <div class="form-row">
                            <div class="col">
                                DATOS CLIENTE
                            </div>
                        </div>
                            
                    </div>
                    <div class="card-body ">
                            <!-- Nombre Completo-->
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Num. Cliente:</span>
                                    </div>
                                    <input id="id_show" name="id_show" value="{{$nota->num_cliente}}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>
                                </div>
                            </div>
                            <!-- Nombre Completo-->
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Nombre:</span>
                                    </div>
                                    <input name="nombre_show" id="nombre_show" value="{{$nota->nombre}}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled>
                                </div>
                            </div>

                            <!-- Telefono-->
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Telefono:</span>
                                    </div>
                                    <input id="telefono_show" value="{{$nota->telefono}}" type="number" class="form-control form-control-sm lenght-telefono" placeholder="#" disabled>
                                </div>
                            </div>

                            <!-- Correo-->
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Correo:</span>
                                    </div>
                                    <input id="email_show" value="{{$nota->email}}" type="email" class="form-control form-control-sm" placeholder="ejemplo@gmail.com" disabled>
                                </div>
                            </div>
                            <!-- Direccion-->
                            <div class="form-row">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Dirección:</span>
                                    </div>
                                    <textarea id="direccion_show" cols="30" rows="3" class="form-control" disabled>{{$nota->direccion}}</textarea>
                                </div>
                            </div>
                    </div>

                    <div class="accordion" id="accordionExample">
                        {{-- DATOS FACTURACIÓN --}}
                        <div class="card mr-2 ml-2">
                            <div class="card-header p-2 bg-secondary" id="headingOne">
                                <button class="btn btn-link btn-block text-left text-white p-0" style="font-size: 13px" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                                    DATOS FACTURACIÓN<i class="fas fa-caret-down ml-2"></i></i>
                                </button>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <!-- RFC-->
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">RFC:</span>
                                            </div>
                                            <input id="rfc_show" value="{{$nota->rfc}}" type="text" class="form-control form-control-sm" placeholder="texto" disabled>
                                        </div>
                                    </div>
    
                                    <!-- CFDI-->
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">CFDI:</span>
                                            </div>
                                            <input id="cfdi_show" value="{{$nota->cfdi}}" type="text" class="form-control form-control-sm" placeholder="texto" disabled>
                                        </div>
                                    </div>
    
                                    <!-- direccion factura-->
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Direccion Factura:</span>
                                            </div>
                                            <textarea id="direccion_factura_show" class="form-control form-control-sm" cols="30" rows="2" disabled> {{$nota->direccion_factura}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- DATOS ENVÍO --}}
                        <div class="card mr-2 ml-2 mb-2">
                            <div class="card-header p-2 bg-secondary" id="headingThree">
                                <button class="btn btn-link btn-block text-left text-white p-0"  style="font-size: 13px" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseOne">
                                    DATOS ENVÍO <i class="fas fa-caret-down ml-2"></i></i>
                                </button>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Dirección:</span>
                                            </div>
                                            <textarea id="direccion_envio_show" class="form-control form-control-sm" cols="30" rows="2" disabled>{{$nota->direccion_envio}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Referencias:</span>
                                            </div>
                                            <textarea id="referencia_envio_show" class="form-control form-control-sm" cols="30" rows="2" disabled>{{$nota->referencia_envio}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <a href="{{$nota->link_ubicacion_envio}}">
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm">Link Ubicación:</span>
                                                </div>
                                                <textarea id="link_ubicacion_envio_show" class="form-control form-control-sm" cols="30" rows="2" disabled>{{$nota->link_ubicacion_envio}}</textarea>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Precio Envio:</span>
                                            </div>
                                            <input id="precio_envio_show" value="{{$nota->precio_envio}}" type="number" value=0 class="form-control form-control-sm numero-decimal-positivo" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <input id="precio_envio_nota" name="precio_envio_nota" type="hidden" value={{$nota->precio_envio}} >

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
                            <button type="button" class="btn btn-verde bool_disabled" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-verde ml-2 bool_disabled" id="guardar-nota">Guardar</button>
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