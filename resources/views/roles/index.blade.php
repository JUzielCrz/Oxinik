@extends('layouts.sidebar')

@section('content-sidebar')

    <div class="container" >

        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert">
            </div>
        </center>
        
        <div class="card">
            <div class="card-footer">
                <div class="row ">
                    <div class="col-md-5 text-center">
                        <h5>Roles</h5>
                    </div>
                    <div class="col-md-5 text-right">
                        <button type="button" class="btn btn-amarillo" data-toggle="modal" data-target="#modalinsertar">
                            <span class="fas fa-plus"></span>
                            Agregar
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-center table-responsive mt-2"> 
                    <table id="tablecruddata" class="table table-sm">
                        <thead>
                            <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">slug</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        
        
        
    </div>


      <!-- Modal insertar-->
      <div class="modal fade bd-example-modal-md" id="modalinsertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 class="modal-title" id="modalinsertarTitle">Nuevo Rol de Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('roles.create')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-md-2" style="margin:10px" >
                <button type="submit" class="btn btn-primary" id="btnaccept">Aceptar</button>
                </div>
                <div class="btn-group col-md-2" style="margin:10px">
                <button  class="btn btn-primary" data-dismiss="modal">Cancelar</button>
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
            <h1 class="modal-title" id="modalactualizarTitle">Actualizar Usuario</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('roles.edit')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-md-2" style="margin:10px" >
                <button type="submit" class="btn btn-primary" id="btnactualizar">Actualizar</button>
                </div>
                <div class="btn-group col-md-2" style="margin:10px">
                <button type="reset" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
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
                ¿Estas seguro dar de baja?
                <input type="hidden" name="" id = "ideliminar">
                <span class="hidden id"></span>
            </div>          
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-md-2" style="margin:10px" >
                <button type="submit" class="btn btn-primary" id="btneliminar">Eliminar</button>
                </div>
                <div class="btn-group col-md-2" style="margin:10px">
                <button type="reset" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/roles/index.js') }}"></script>
<!--Fin Scripts-->
