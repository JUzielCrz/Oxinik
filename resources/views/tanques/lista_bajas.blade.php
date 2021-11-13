@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('tanques.submenu_navbar')
@endsection

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
                        <h5>LISTA DE BAJAS</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table id="tablecruddata" class="table table-sm" style="font-size: 13px">
                        <thead>
                            <tr>
                            <th scope="col">N. Serie</th>
                            <th scope="col">P.Hidrostática</th>
                            <th scope="col">Fabricante</th>
                            <th scope="col">Estatus</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th></th>
                            </tr>
                        </thead>
                    </table>
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
                Restablecer cilindro. <br>
                ¿Estas seguro?
                <input type="hidden" name="" id = "ideliminar">
                <span class="hidden id"></span>
            </div>          
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto" style="margin:10px" >
                <button type="submit" class="btn btn-naranja" id="btneliminar">Restablecer</button>
                </div>
                <div class="btn-group col-auto" style="margin:10px">
                <button type="reset" class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/tanque/bajas.js') }}"></script>
<!--Fin Scripts-->
<script>
    $(document).ready(function () {
        $("#id-menu-bajas").addClass('active');
    });
</script>
