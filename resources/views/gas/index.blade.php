@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('tanques.submenu_navbar')
@endsection

@php
        $idauth=Auth::user()->id;
        $user=App\User::find($idauth);
@endphp

@section('content-sidebar')

    <div class="container" >

        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert">
            </div>
        </center>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h5>CATALOGO DE GASES</h5>
                    </div>
                    <div class="col text-right">
                        <button type="button" class="btn  btn-sm btn-amarillo" data-toggle="modal" data-target="#modal-tanque">
                            <span class="fas fa-plus"></span>
                            Agregar
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table id="tablecruddata" class="table table-sm" style="font-size: 13px">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Abreviatura</th> 
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
    <div class="modal fade bd-example-modal-md" id="modal-tanque" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 class="modal-title" id="modalinsertarTitle">NUEVO GAS</h5 >
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('gas.create')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto"  >
                <button type="button" class="btn  btn-sm btn-amarillo" id="btnaccept">Aceptar</button>
                </div>
                <div class="btn-group col-auto" >
                <button  class="btn  btn-sm btn-amarillo" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>
    

    <!-- Modal actualizar datos-->
    <div class="modal fade bd-example-modal-md" id="modal-tanqueedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 class="modal-title" id="modalactualizarTitle">Actualizar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('gas.edit')
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto "  >
                <button type="button" class="btn btn-sm btn-amarillo form-control" id="btnactualizar">Actualizar</button>
                </div>
                <div class="btn-group col-auto" >
                <button type="reset" class="btn  btn-sm btn-amarillo form-control" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
  </div>




@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/cruds/gas.js') }}"></script>
<!--Fin Scripts-->

<script>
    $(document).ready(function () {
        $("#id-menu-gas").addClass('active');
    });
</script>
