@extends('layouts.navbar')
@section('contentnavbar')
    
<style>
    body {
        background-color: #e8ebf7;
    }
</style>

    <div class="container" >

        <div class="card">
            <div class="card-body">
                
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <h5>Cliente: {{$cliente->apPaterno}} {{$cliente->apMaterno}} {{$cliente->nombre}}</h5>
                    <hr>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <p>Número de Contrato:</p>
                        <h6>{{$contrato->num_contrato}}</h6>
                        {!! Form::hidden('num_contrato', $contrato->num_contrato, ['id'=>'num_contrato']) !!}

                    </div>
                    <div class="form-group col-md-4">
                        <p>Tipo Contrato:</p>
                        <h6>{{$contrato->tipo_contrato}}</h6>
                    </div>
                    <div class="form-group col-md-4">
                        <p>Precio Transporte:</p>

                        <h6> $ 
                            @php
                                $precioformato= number_format($contrato->precio_transporte,2);
                            @endphp
                            {{$precioformato}}</h6>

                    </div>
                </div>


            </div>
        </div>


        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert">
            </div>
        </center>

        <div class="card mt-3">
            <div class="card-body">

                <div class="row ">
                    <div class="col-md-5 text-center">
                        <p><strong>NOTAS</strong></p>
                    </div>
                    <div class="col-md-5 text-right">
                        <a href="{{ url("/newnota/{$contrato->num_contrato}") }}" class="btn btn-sm btn-gray">
                            <span class="fas fa-plus"></span>
                            Agregar
                        </a>
                    </div>
        
                </div>
                
                <div class="row d-flex justify-content-center table-responsive"> 
                    <table id="tablecruddata" class="table table-sm table-striped table-hover">
                        <thead>
                            <tr>
                            <th scope="col" style="font-size: 15px">Folio</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Pago Realizado</th>
                            <th scope="col">Metodo Pago</th>
                            <th scope="col">Núm. Contrato</th>
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
<script src="{{ asset('js/notas/notas.js') }}"></script>
<!--Fin Scripts-->
