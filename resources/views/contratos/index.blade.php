@extends('layouts.sidebar')

@section('menu-navbar') 
    <li class="nav-item active">
        <a class="nav-link" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> Atras</a>
    </li>
    {{-- <li class="nav-item">
        <a class="btn btn-sm btn-outline-success" href="{{ url('/nota/contrato/entrada') }}"><i class="fas fa-sign-in-alt"></i> Entrada</a>
    </li> --}}
@endsection

@section('content-sidebar')

@php
    $idauth=Auth::user()->id;
    $user=App\User::find($idauth);
@endphp

    <div class="container" >
        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert">
            </div>
        </center>

        <input type="hidden" name="cliente_id" id="cliente_id" value={{$cliente->id}}>
        
        {{-- CARD TABLA DE CONTRATOS SEGUN CLIENTE--}}
        <div class="card">
            <div class="card-header bg-gray">
                <div class="row justify-content-end">
                    <div class="col-md-9">
                        @if ($cliente->empresa == '')
                            <h5 class="" style="font-size: 15px">CONTRATOS DE: {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</h5>
                        @else
                            <h5 class="" style="font-size: 15px"> Empresa: {{$cliente->empresa}}  - Representante: {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</h5>
                        @endif
                        
                    </div>
                    <div class="col-md-3 text-right">
                        @if($user->permiso_con_admin('contrato_create')) 
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalinsertar">
                                <span class="fas fa-plus"></span>
                                Agregar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row table-responsive ml-1"> 
                    <table id="table-contratos" class="table table-sm table-hover" >
                        <thead style="background: #fff; color: black">
                            <tr>
                            <th class="text-center">#Contrato</th>
                            <th class="text-center">Tipo</th>
                            <th scope="col"></th> 
                            <th scope="col"></th> 
                            </tr>
                        </thead>
                        <tbody id="tableinsertfila">
    
                        </tbody>
                        <tbody>
                            @foreach ($contratos as $contrato)
                                <tr class="fila{{$contrato->id}}" data-id="{{$contrato->id}}">
                                    <td class="text-center">{{$contrato->num_contrato}}</td>
                                    <td class="text-center">{{$contrato->tipo_contrato}}</td>
                                    
                                    <td><a class="btn btn-amarillo btn-sm" target="_blank" href="{{ url("/pdf/generar_contrato/{$contrato->id}") }}"  title="Contrato"><i class='fas fa-file-pdf'></i></span></a></td>
                                    <td><button class="btn btn-amarillo btn-delete-modal btn-sm" data-id="{{$contrato->id}}" title="Eliminar"><span class="fas fa-trash" ></span></button>
                                
                                </tr>
                            @endforeach
                            
                        </tbody>
    
                    </table>
                </div>
                
            </div>
        </div>

        {{-- CARD INFORMACION CONTRATO INDIVIDUAL --}}
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card pb-0">
                    <div class="card-header bg-gray">
                        <div class="form-row">
                            <div class="col ">
                                <h5 style="font-size: 17px">INFORMACIÓN</h5>
                            </div>
                            <div class="col ">
                                @if($user->permiso_con_admin('contrato_update')) 
                                <button class="btn btn-amarillo btn-sm" id="btn-edit-modal" ><span class="fas fa-edit"></span> Edit</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="font-size: 12px;">
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >#Contrato:</span>
                                </div>
                                <input type="hidden"  name="idShow" id="idShow">
                                <input id="num_contratoShow" type="text" class="form-control form-control-sm" value="" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Tipo:</span>
                                </div>
                                <input id="tipo_contratoShow" type="text" class="form-control form-control-sm" value="" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Nombre Comercial:</span>
                                </div>
                                <input id="nombre_comercialShow" type="text" class="form-control form-control-sm" value="" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Reguladores:</span>
                                </div>
                                <input id="reguladoresShow" type="text" class="form-control form-control-sm" value="" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Envío:</span>
                                </div>
                                <input id="precio_transporteShow" type="text" class="form-control form-control-sm" value="" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="">Dirección</label>
                                <textarea id="direccionShow" class="form-control form-control-sm" cols="30" rows="2" readonly></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="">Referencia</label>
                                <textarea id="referenciaShow" class="form-control form-control-sm" cols="30" rows="2" readonly></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="">Ubicacion:</label>
                                <textarea id="link_ubicacionShow" class="form-control form-control-sm" cols="30" rows="2" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card ">
                    <div class="card-header pb-0">
                        <div class="row p-0">
                            <div class="col">
                                <h5 style="font-size: 17px">ASIGNACIONES</h5>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        @if ($user->permiso_con_admin('asignacion_disminucion'))
                                        <button class="btn btn-amarillo" type="button" id="btn-modal-asignacion-minus"> <span class="fas fa-minus"></span></button>
                                        @endif
                                    </div>
                                    <div class="input-group-prepend">
                                        @if ($user->permiso_con_admin('asignacion_aumento'))
                                        <button class="btn btn-amarillo" type="button" id="btn-modal-asignacion-plus"> <span class="fas fa-plus"></span></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" >
                        <div id="content-asignaciones">
                            
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                
                <div class="card mt-3">
                    <div class="card-header bg-gray">NOTAS</div>
                    <div class="card-body"  id="cardtablas">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal insertar-->
    <div class="modal fade bd-example-modal-xl" id="modalinsertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h3 class="modal-title" id="modalinsertarTitle">Nuevo Contrato</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('contratos.create')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto" style="margin:10px" >
                <button type="submit" class="btn btn-amarillo" id="btnaccept">Aceptar</button>
                </div>
                <div class="btn-group col-auto" style="margin:10px">
                <button  class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>

    <!-- Modal actualizar datos-->
    <div class="modal fade bd-example-modal-md" id="modalactualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h1 class="modal-title" id="modalactualizarTitle">Actualizar</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('contratos.edit')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto " style="margin:10px" >
                <button type="submit" class="btn btn-amarillo form-control" id="btnactualizar">Actualizar</button>
                </div>
                <div class="btn-group col-auto" style="margin:10px">
                <button type="reset" class="btn btn-amarillo form-control" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>

        <!-- Modal Eliminar datos-->
    <div class="modal fade bd-example-modal-md" id="modaleliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-amarillo">
            <h4 class="modal-title" id="modaleliminarTitle">Eliminar</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            <div class="deleteContent text-center m-5">
                Se eliminara todas las relaciones a este contrato permanentemente. <br>
                ¿Estas seguro de continuar?
                <input type="hidden" name="" id = "ideliminar">
                <span class="hidden id"></span>
            </div>          
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto" style="margin:10px" >
                <button type="submit" class="btn btn-naranja" id="btneliminar">Eliminar</button>
                </div>
                <div class="btn-group col-auto" style="margin:10px">
                <button type="reset" class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>

    <!-- Modal Eliminar datos NOTA-->
    <div class="modal fade bd-example-modal-md" id="modaleliminarnota" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-amarillo">
            <h4 class="modal-title" id="modaleliminarTitle">Eliminar</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            <div class="deleteContent text-center m-5">
                Se eliminara permanentemente. <br>
                ¿Estas seguro?
                <input type="hidden" name="" id = "ideliminar">
                <span class="hidden id"></span>
            </div>          
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto" style="margin:10px" >
                <button type="submit" class="btn btn-naranja" id="btneliminar">Eliminar</button>
                </div>
                <div class="btn-group col-auto" style="margin:10px">
                <button type="reset" class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>

    {{--------------------------------- MODALES PARA ASIGNACION ------------------------------------------------------}}
    <!-- Modal Edit Asignacion de tanques en contrato-->
    <div class="modal fade" id="modal-edit-asignacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
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
            {{-- <button type="button" class="btn btn-verde" data-dismiss="modal">Cancelar</button> --}}
            <button id="btn-save-asignacion" type="button" class="btn btn-verde">Guardar</button>
            </div>
        </div>
        </div>
    </div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/cruds/contratos.js') }}"></script>

<!--Fin Scripts-->
