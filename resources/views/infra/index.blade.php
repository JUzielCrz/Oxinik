@extends('layouts.navbar')
@section('contentnavbar')

<style>
    body {
        background-color: #e8ebf0;
    }
</style>

    

    <div class="container" >
        @if(Session::has('alertas'))
            
            <div class="alert alert-danger">{{ session('alertas') }} </div>
        @endif
        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert"></div>
        </center>
        
        <div class="card">
            <div class="card-header">
                <div class="row ">
                    <div class="col-md-5 text-center">
                        <h3>INFRA</h3>
                    </div>
        
                    <div class="col-md-5 text-right">
                        <a class="btn btn-gray btn-sm" href="{{ url('/createinfra') }}">
                            <span class="fas fa-plus"></span>
                            Agregar
                        </a>
                    </div>
        
                </div>
            </div>
            <div class="card-body">
                <div class="row table-responsive "> 
                    <table id="tablecruddata" class="table table-sm">
                        <thead>
                            <tr class="selected">
                            <th scope="col">id</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Incidencia</th>
                            {{-- <th scope="col"></th> --}}
                            <th scope="col"></th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    
    <!-- Modal mostrar datos-->
    <div class="modal fade bd-example-modal-md" id="modalmostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-onix">
            <h1 class="modal-title" id="modalmostrarTitle">Informacion Usuario</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                <span aria-hidden="true" class="fas fa-times"></span>
            </button>
            </div>
            <div class="modal-body">
            {{-- @include('usuarios.info') --}}
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-md-2" style="margin:10px">
                <button type="reset" class="btn btn-azul" data-dismiss="modal">Cancelar</button>
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
                ¿Estas seguro de eliminar?
                <input type="hidden" name="" id = "ideliminar">
                <span class="hidden id"></span>
            </div>          
            <!-- botones Aceptar y cancelar-->
            <div class="row justify-content-center" >
                <div class="btn-group col-md-2" style="margin:10px" >
                <button type="submit" class="btn btn-rojo" id="btneliminar">Eliminar</button>
                </div>
                <div class="btn-group col-md-2" style="margin:10px">
                <button type="reset" class="btn btn-azul" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/infra/index.js') }}"></script>
<!--Fin Scripts-->
