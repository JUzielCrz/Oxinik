@extends('layouts.sidebar')

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
        
        <div class="card">
            <div class="card-header">
                <div class="row ">
                    <div class="col">
                        <h5>Clientes</h5>
                    </div>
                    <div class="col text-right">
                        @if($user->permiso_con_admin('cliente_create')) 
                            <button type="button" class="btn btn-sm btn-amarillo" data-toggle="modal" data-target="#modalinsertar">
                                <span class="fas fa-plus"></span>
                                Agregar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="font-size:13px">
                    <table id="tablecruddata" class="table table-sm " style="font-size:13px">
                        <thead>
                            <tr >
                            <th scope="col">#ID</th>
                            <th scope="col">Ap. Paterno</th>
                            <th scope="col">Ap. Materno</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">2° Teléfono</th>
                            <th scope="col"></th>
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
    <div class="modal fade bd-example-modal-md" id="modalinsertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="font-size: 13px">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 class="modal-title" id="modalinsertarTitle">Agregar Cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('clientes.create')
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
    
    <!-- Modal mostrar datos-->
    <div class="modal fade bd-example-modal-md" id="modalmostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 class="modal-title" id="modalmostrarTitle">Informacion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('clientes.info')
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
    <div class="modal fade bd-example-modal-md" id="modalactualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 class="modal-title" id="modalactualizarTitle">Actualizar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('clientes.edit')
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



@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/cliente/index.js') }}"></script>
<!--Fin Scripts-->
