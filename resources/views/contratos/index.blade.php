@extends('layouts.navbar')
@section('contentnavbar')
    

    <div class="container" >
        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert">
            </div>
        </center>

        <input type="hidden" name="cliente_id" id="cliente_id" value={{$cliente->id}}>
        <div class="row ">
            <div class="col-md-5 text-center">
                <h4>CONTRATROS </h4> 
                <p>Cliente: <strong>{{$cliente->nombre}}  {{$cliente->apPaterno}}  {{$cliente->apMaterno}}</strong></p>
            </div>
            <div class="col-md-5 text-right">
                <button type="button" class="btn btn-gray" data-toggle="modal" data-target="#modalinsertar">
                    <span class="fas fa-plus"></span>
                    Agregar
                </button>
            </div>
        </div>
        
        <div class="row table-responsive mt-2"> 
            <table id="tablecruddata" class="table table-sm">
                <thead>
                    <tr>
                    <th scope="col">Num. Contrato</th>
                    {{-- <th scope="col">Cliente</th> --}}
                    <th scope="col">Tipo Contrato</th>
                    {{-- <th scope="col">Precio</th> --}}
                    <th scope="col">Transporte</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th> 
                    </tr>
                </thead>
            </table>
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


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/cruds/contratos.js') }}"></script>
<!--Fin Scripts-->
