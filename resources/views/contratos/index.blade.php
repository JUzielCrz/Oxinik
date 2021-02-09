@extends('layouts.navbar')
@section('contentnavbar')
<style>
    body {
        background-color: #e8ebf7;
    }
</style>

    <div class="container" >
        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert">
            </div>
        </center>

        <input type="hidden" name="cliente_id" id="cliente_id" value={{$cliente->id}}>
        
        
        <div class="row ">
            <div class="col-md-5 text-center">
                <h4 class="display-4" style="font-size: 2rem">Cliente: <strong>{{$cliente->nombre}}  {{$cliente->apPaterno}}  {{$cliente->apMaterno}}</strong></h4>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <h4 class="card-title"> Contratos</h4>
                    </div>
                    <div class="col-md-5 text-right">
                        <button type="button" class="btn btn-gray" data-toggle="modal" data-target="#modalinsertar">
                            <span class="fas fa-plus"></span>
                            Nuevo Contrato
                        </button>
                    </div>
                </div>
            <hr>
                <div class="row table-responsive ml-1"> 
                    <table id="" class="table table-sm">
                        <thead>
                            <tr>
                            <th class="text-center">Num. Contrato</th>
                            <th class="text-center">Tipo Contrato</th>
                            <th class="text-center">Transporte</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th> 
                            </tr>
                        </thead>
                        <tbody id="tableinsertfila">

                        </tbody>
                        <tbody>
                            @foreach ($contratos as $contrato)
                                <tr class="fila{{$contrato->id}} ">
                                    <td class="text-center">{{$contrato->num_contrato}}</td>
                                    <td >{{$contrato->tipo_contrato}}</td>
                                    <td class="text-center">{{$contrato->precio_transporte}} </td> 
                                    <td><button class="btn btn-gray btn-xs" id="btncontrato" data-id="{{$contrato->num_contrato}}"><span class="far fa-edit"></span></button>
                                    <td><button class="btn btn-naranja btn-edit-modal btn-xs" data-id="{{$contrato->id}}"><span class="far fa-edit"></span></button>
                                    <td><button class="btn btn-amarillo btn-delete-modal btn-xs" data-id="{{$contrato->id}}"><span class="fas fa-trash"></span></button>
                                    
                                </tr>
                            @endforeach
                            
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body" id="cardtablas">
                
            </div>
        </div>
    </div>
    
    <!-- Modal insertar-->
    <div class="modal fade bd-example-modal-md" id="modalinsertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h1 class="modal-title" id="modalinsertarTitle">Nuevo</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('contratos.create')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto" style="margin:10px" >
                <button type="submit" class="btn btn-gray" id="btnaccept">Aceptar</button>
                </div>
                <div class="btn-group col-auto" style="margin:10px">
                <button  class="btn btn-gray" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>


    <!-- Modal mostrar datos-->
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
            {{-- @include('contratos.info') --}}
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

    <!-- Modal actualizar datos-->
    <div class="modal fade bd-example-modal-xl" id="modalactualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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
                <button type="submit" class="btn btn-gray form-control" id="btnactualizar">Actualizar</button>
                </div>
                <div class="btn-group col-auto" style="margin:10px">
                <button type="reset" class="btn btn-gray form-control" data-dismiss="modal">Cancelar</button>
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
                <button type="reset" class="btn btn-gray" data-dismiss="modal">Cancelar</button>
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
                <button type="reset" class="btn btn-gray" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/cruds/contratos.js') }}"></script>
<!--Fin Scripts-->
