@extends('layouts.sidebar')

@section('menu-navbar') 
   
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
                        <h5>Choferes</h5>
                    </div>
                    <div class="col text-right">
                        <button type="button" class="btn  btn-sm btn-amarillo" id="btn_add">
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
                            <th scope="col">Apellidos</th>
                            <th scope="col">Nombre(s)</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        
    </div>


    <!-- Modal insertar-->
    <div class="modal fade bd-example-modal-md" id="modal_driver" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 id="modal_title">Agregar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            @include('drivers.form_inputs')
            <!--Botones Aceptar y Cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto">
                    <button type="button" class="btn  btn-sm btn-amarillo" id="btn_save">Guardar</button>
                </div>
                <div class="btn-group col-auto" >
                    <button  class="btn  btn-sm btn-amarillo" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>
    

    {{-- <!-- Modal actualizar datos-->
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
  </div> --}}




@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/drivers/index.js') }}"></script>
<!--Fin Scripts-->

{{-- <script>
    $(document).ready(function () {
        $("#id-menu-gas").addClass('active');
    });
</script> --}}
