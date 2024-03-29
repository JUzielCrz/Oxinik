@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('tanques.submenu_navbar')
@endsection

@section('content-sidebar')

    <div class="container" >
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h5>TANQUES</h5>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="input-group m-0 p-0">
                            <input type="text" name="serie_tanque" id="serie_tanque" class="form-control form-control-sm" placeholder="#Serie" >
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-amarillo" id="add-cilindro">
                                    <span class="fas fa-plus"></span>
                                    Agregar
                                </button>
                            </div>
                        </div>
                        <span  id="serie_tanqueError" class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table id="tablecruddata" class="table table-sm" style="font-size: 13px">
                        <thead>
                            <tr>
                            <th class="text-center">#Serie</th>
                            <th class="text-center">Gas</th>
                            <th class="text-center">P.Hidrostática</th>
                            <th class="text-center">Fabricante</th>
                            <th class="text-center">Material</th>
                            <th class="text-center">Estatus</th>
                            <th class="text-center">Usuarios</th>
                            <th class="text-center"></th>
                            <th class="text-center"></th> 
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        
    </div>


    <!-- Modal insertar-->
    <div class="modal fade bd-example-modal-xl" id="modal-tanque" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 class="modal-title" id="modalinsertarTitle">Nuevo tanque</h5 >
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('tanques.create')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto" style="margin:10px" >
                <button type="button" class="btn btn-amarillo" id="btnaccept">Aceptar</button>
                </div>
                <div class="btn-group col-auto" style="margin:10px">
                <button  class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
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
            <h5 class="modal-title" id="modalmostrarTitle">Información</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('tanques.info')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto" style="margin:10px">
                <button type="reset" class="btn btn-amarillo" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>

    <!-- Modal actualizar datos-->
    <div class="modal fade bd-example-modal-lg" id="modal-tanqueedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 class="modal-title" id="modalactualizarTitle">Actualizar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('tanques.edit')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto " style="margin:10px" >
                <button type="button" class="btn btn-amarillo form-control" id="btnactualizar">Actualizar</button>
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
            <h5 class="modal-title text-center" id="modaleliminarTitle">BAJA DE CILINDRO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            <div class="deleteContent text-center m-5">
                Se dara de baja este cilindro. <br>
                ¿Estas seguro?
                <input type="hidden" name="" id = "ideliminar">
                <span class="hidden id"></span>
            </div>          
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto" style="margin:10px" >
                <button type="submit" class="btn btn-amarillo" id="btneliminar">Eliminar</button>
                </div>
                <div class="btn-group col-auto" style="margin:10px">
                <button type="reset" class="btn btn-verde" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/tanque/index.js') }}"></script>
<!--Fin Scripts-->

<script>
    $(document).ready(function () {
        $("#id-menu-index").addClass('active');
    });
</script>