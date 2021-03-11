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
        
        
        <div class="card bg-gray">
            {{-- <div class="card-body"> --}}
                <h1 class="text-center display-1" style="font-size: 30px">CONTRATOS</h1>
            {{-- </div> --}}
        </div>


        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card bg-gray" style="height: 40em">
                    <div class="card-body">
                        <div class="row ml-1">
                            <h5 class="display-1" style="font-size: 25px">Cliente: {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</h5>
                        </div>
                        <hr>
                        <div class="row table-responsive ml-1"> 
                            <table id="table-contratos" class="table table-sm table-hover bg-gray">
                                <thead>
                                    <tr>
                                    <th class="text-center">#Contrato</th>
                                    <th class="text-center">Tipo</th>
                                    <th scope="col"></th> 
                                    </tr>
                                </thead>
                                <tbody id="tableinsertfila">
        
                                </tbody>
                                <tbody>
                                    @foreach ($contratos as $contrato)
                                        <tr class="fila{{$contrato->id}} ">
                                            <td class="text-center">{{$contrato->num_contrato}}</td>
                                            <td class="text-center">{{$contrato->tipo_contrato}}</td>
                                            <td><button class="btn btn-amarillo btn-delete-modal btn-sm" data-id="{{$contrato->id}}"><span class="fas fa-trash"></span></button>
                                            
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
        
                            </table>
                        </div>
                        <hr>
                        <div class="row justify-content-end">
                            <button type="button" class="btn btn-gray" data-toggle="modal" data-target="#modalinsertar">
                                <span class="fas fa-plus"></span>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>#Contrato</label>
                                <input id="num_contratoShow" type="text" class="form-control form-control-sm" value="" disabled>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label >Tipo</label>
                                <input id="tipo_contratoShow" type="text" class="form-control form-control-sm" value="" disabled>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Envío</label>
                                <input id="precio_transporteShow" type="text" class="form-control form-control-sm" value="" disabled>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="">Dirección</label>
                                <textarea id="direccionShow" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="">Referencia</label>
                                <textarea id="referenciaShow" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
                            </div>
                        </div>
                        <hr>

                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="mr-2">Asignación: </label>
                                    <div class="input-group-prepend">
                                        <button class="btn btn-amarillo" type="button" id="btn-asignacion-minus"><span class="fas fa-minus"></span></button>
                                    </div>
                                    <input type="text" class="form-control text-center" id="asignacion_tanquesShow" aria-label="Example text with button addon" aria-describedby="button-addon1" disabled>
                                    <div class="input-group-prepend">
                                        <button class="btn btn-amarillo" type="button" id="btn-asignacion-plus"><span class="fas fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                    
                            
                            <div class="col-md-8 text-right">
                                <button class="btn btn-gray btn-sm" id="btn-edit-modal" value=""><span class="fas fa-edit"></span> Editar</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card mt-2">
                    <div class="card-header">Notas</div>
                    <div class="card-body"  id="cardtablas">
                    </div>
                </div>
            </div>
        </div>
        

    </div>
    
    <!-- Modal insertar-->
    <div class="modal fade bd-example-modal-md" id="modalinsertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h3 class="modal-title" id="modalinsertarTitle">Nuevo Contrato</h3>
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




    {{--------------------------------- MODALES PARA ASIGNACION ------------------------------------------------------}}+
    <!-- -->
    <div class="modal fade bd-example-modal-md" id="modalinsertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h3 class="modal-title" id="modalinsertarTitle">Nuevo Contrato</h3>
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


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/cruds/contratos.js') }}"></script>
<!--Fin Scripts-->
