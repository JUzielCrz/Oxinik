@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

    <div class="container" >
        
    <form id="idFormNewVenta" style="font-size: 13px">
        @csrf
        <div class="row">
            <div class="col-md-8">
                {{-- SALIDA --}}
                <div class="card">
                    <div class="card-header bg-gris text-white">
                        <div class="row m-0 p-0">
                            <div class="col m-0">
                                <h5>NUEVO TALON</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <strong>REGISTRA TANQUES DE ENTRADA</strong>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="col">
                                {!! Form::label('# Serie') !!}
                                {!! Form::text('serie_tanque_entrada', null, ['id'=>'serie_tanque_entrada', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}

                            </div>
                            <div class="col ">
                                {!! Form::label('Tapa') !!}
                                {{ Form::select('tapa_tanque',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="tapa_tanqueError" class="text-danger"></span>
                            </div>
                            
                            <div class="col align-self-end">
                                <button type="button" class="btn btn-verde" id="btn-insert-fila-entrada"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>
                        <span  id="serie_tanque_entradaError" class="text-danger"></span>
                        <div class="table-responsive mt-2">
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
                <div class="card">
                    <div class="card-header p-2" >
                        <div class="form-row">
                            <div class="col">
                                BUSCAR CLIENTE
                            </div>
                            <div class="col text-right">
                                <button id="btn-registrar-cliente" class="btn btn-sm btn-amarillo"  type="button" data-toggle="modal" data-target="#modal-create-cliente"><span class="fas fa-edit"></span> Registar</button>
                            </div>
                        </div>
                            
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden"  name="contrato_id" id="contrato_id">
                            <div class="input-group input-group-sm ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-search" id="inputGroup-sizing-sm"></span>
                                </div>
                                <input id="search_cliente" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                            </div>
                        </div>
                        <div id="listarclientes"></div>
                    </div>
                </div>
                {{-- DATOS  CLIENTE --}}
                <div class="card mt-2">
                    <div class="card-header p-2" >
                        <div class="form-row">
                            <div class="col">
                                DATOS CLIENTE
                            </div>
                            <div class="col text-right">
                                <button id="btn-editar-cliente" class="btn btn-sm btn-amarillo"  type="button" data-toggle="modal" data-target="#modal-editar-cliente"><span class="fas fa-edit"></span> Editar</button>
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
                                    <input id="id_show" name="id_show" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>
                                </div>
                            </div>
                            <!-- Nombre Completo-->
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Nombre:</span>
                                    </div>
                                    <input name="nombre_show" id="nombre_show" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled>
                                </div>
                            </div>

                            <!-- Telefono-->
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Telefono:</span>
                                    </div>
                                    <input id="telefono_show" type="number" class="form-control form-control-sm lenght-telefono" placeholder="#" disabled>
                                </div>
                            </div>

                            <!-- Correo-->
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Correo:</span>
                                    </div>
                                    <input id="email_show" type="email" class="form-control form-control-sm" placeholder="ejemplo@gmail.com" disabled>
                                </div>
                            </div>
                            <!-- Direccion-->
                            <div class="form-row">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Dirección:</span>
                                    </div>
                                    <textarea id="direccion_show" cols="30" rows="3" class="form-control" disabled></textarea>
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
                                            <input id="rfc_show" type="text" class="form-control form-control-sm" placeholder="texto" disabled>
                                        </div>
                                    </div>
    
                                    <!-- CFDI-->
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">CFDI:</span>
                                            </div>
                                            <input id="cfdi_show" type="text" class="form-control form-control-sm" placeholder="texto" disabled>
                                        </div>
                                    </div>
    
                                    <!-- direccion factura-->
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Direccion Factura:</span>
                                            </div>
                                            <textarea id="direccion_factura_show" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
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
                                            <textarea id="direccion_envio_show" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Referencias:</span>
                                            </div>
                                            <textarea id="referencia_envio_show" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Link Ubicación:</span>
                                            </div>
                                            <textarea id="link_ubicacion_envio_show" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Precio Envio:</span>
                                            </div>
                                            <input id="precio_envio_show" type="number" value=0 class="form-control form-control-sm numero-decimal-positivo" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                


                <div class="card mt-2">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-verde" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-verde ml-2" id="btn-guardar-nota">Guardar</button>
                            {{-- <button type="button" class="btn btn-amarillo" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
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

    <!-- EDITAR CLIENTE-->
    <div class="modal fade bd-example-modal-md" id="modal-editar-cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalinsertarTitle">Editar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('clientes_sc.edit')
                    <!-- botones Aceptar y cancelar-->
                    <div class="row justify-content-center" >
                        <div class="btn-group col-auto" style="margin:10px" >
                            <button type="button" class="btn btn-amarillo" id="btn-cliente-edit-save">Aceptar</button>
                        </div>
                        <div class="btn-group col-auto" style="margin:10px">
                            <button  class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- CREATE CLIENTE-->
    <div class="modal fade bd-example-modal-md" id="modal-create-cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalinsertarTitle">Registrar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('clientes_sc.create')
                    <!-- botones Aceptar y cancelar-->
                    <div class="row justify-content-center" >
                        <div class="btn-group col-auto" style="margin:10px" >
                            <button type="button" class="btn btn-amarillo" id="btn-cliente-create-save">Aceptar</button>
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
<script src="{{ asset('js/notas/talon/create.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-talon").addClass('active');
    });
</script>
<!--Fin Scripts-->