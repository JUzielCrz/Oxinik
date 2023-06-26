@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('concentrator.submenu_navbar')
@endsection

@section('content-sidebar')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row ">
                <div class="col">
                    <h5>Mantenimiento Concentradores</h5>
                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-sm btn-amarillo" id="btn_add">
                        <span class="fas fa-plus"></span>
                        Nuevo Registro
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="font-size:13px">
                <table id="table-data" class="table table-sm " style="font-size:13px">
                    <thead><tr>
                        <th>ID REGISTRO</th>
                        <th># SERIE</th>
                        <th>ESTATUS</th>
                        <th>FECHA ENTRADA</th>
                        <th>FECHA SALIDA</th>
                        <th>USUARIO</th>
                        <th></th>
                    </tr></thead>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Modal insertar-->
    <div class="modal fade bd-example-modal-md" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 id="modal_title">Agregar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
                @include('concentrator.maintenance.form')
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

    <div class="modal fade bd-example-modal-md" id="modal_return" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h5 id="modal_title">Registrar Devolución</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
                @include('concentrator.maintenance.edit')
            <!--Botones Aceptar y Cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-auto">
                    <button type="button" class="btn  btn-sm btn-amarillo" id="btn_update">Guardar</button>
                </div>
                <div class="btn-group col-auto" >
                    <button  class="btn  btn-sm btn-amarillo" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>

@endsection
@include('layouts.scripts')

<!--Scripts-->
<script src="{{ asset('js/concentrator/maintenance.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#navbar_concentrators_maintenance").addClass('active');
    });
</script>
<!--Fin Scripts-->