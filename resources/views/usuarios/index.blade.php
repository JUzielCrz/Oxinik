@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('usuarios.submenu_navbar')
@endsection

@section('content-sidebar')
    

    <div class="container" >
        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert">
            </div>
        </center>
            
        <div class="card">
            <div class="card-header">
                <div class="row ">
                    <div class="col ml-2">
                        <h5>USUARIOS</h5>
                    </div>
        
                    <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-amarillo" data-toggle="modal" data-target="#modalinsertar">
                            <span class="fas fa-plus"></span>
                            Agregar
                        </button>
                    </div>
        
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" > 
                    <table id="tablecruddata" class="table table-sm" style="font-size: 13px">
                        <thead>
                            <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col"></th>
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
            <h5 class="modal-title" id="modalinsertarTitle">NUEVO USUARIO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('auth.register')
            <!-- botones Aceptar y cancelar-->
                <div class="row justify-content-center" >
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-verde" id="btnaccept">Aceptar</button>
                        <button type="reset" class="btn btn-verde ml-2" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
            
        </div>
        </div>
    </div>
    
    <!-- Modal mostrar datos-->
    <div class="modal fade bd-example-modal-sm" id="modalmostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 class="modal-title" id="modalmostrarTitle">INFORMACIÓN</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
                @include('usuarios.info')
                <!-- botones Aceptar y cancelar-->
                <div class="row justify-content-center" >
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="reset" class="btn btn-sm btn-verde ml-2" data-dismiss="modal">Aceptar</button>
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
                <h5 class="modal-title" id="modalactualizarTitle">ACTUALIZAR USUARIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                    <span aria-hidden="true" class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                @include('usuarios.edit')
                <!-- botones Aceptar y cancelar-->
                <div class="row justify-content-center" >
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-verde" id="btnactualizar">Actualizar</button>
                        <button type="reset" class="btn btn-verde ml-2" data-dismiss="modal">Cancelar</button>
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
            <h5 class="modal-title" id="modaleliminarTitle">ELIMINAR</h5>
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
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-verde" id="btneliminar">Eliminar</button>
                        <button type="reset" class="btn btn-sm btn-verde ml-2" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
            
        </div>
        </div>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/usuarios/index.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-usuario").addClass('active');
    });
</script>
<!--Fin Scripts-->
