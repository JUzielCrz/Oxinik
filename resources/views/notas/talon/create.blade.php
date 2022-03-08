@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

    <div class="container" >
        
    <form id="idFormNewVenta" style="font-size: 13px">
        @csrf
        <div class="row">
            <div class="col-md-8">
                {{-- SALIDA --}}
                <div class="card">
                    <div class="card-header bg-gris text-white">
                        <div class="row m-0 p-0">
                            <div class="col m-0">
                                <h5>NUEVO TALON</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <strong>REGISTRA TANQUES DE ENTRADA</strong>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="col">
                                {!! Form::label('# Serie') !!}
                                {!! Form::text('serie_tanque_entrada', null, ['id'=>'serie_tanque_entrada', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}

                            </div>
                            <div class="col ">
                                {!! Form::label('Tapa') !!}
                                {{ Form::select('tapa_tanque',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                <span  id="tapa_tanqueError" class="text-danger"></span>
                            </div>
                            
                            <div class="col align-self-end">
                                <button type="button" class="btn btn-verde" id="btn-insert-fila-entrada"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>
                        <span  id="serie_tanque_entradaError" class="text-danger"></span>
                        <div class="table-responsive mt-2">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">DESCRIPCIÓN</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-tanques-entrada" style="font-size: 13px">
                                </tbody>
            
                            </table>
                        </div>
                        <center>
                            <div id="msg-tanques-entrada" style="display:none" class="alert" role="alert">
                            </div>
                        </center>
                    </div>
                </div>
                {{-- OBSERVACIONES --}}
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Observaciones Generales</label>
                                <textarea name="observaciones" id="observaciones" cols="30" rows="1" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('clientes_sc.search')
                @include('clientes_sc.show')

                <div class="card mt-2">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-verde" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-verde ml-2" id="btn-guardar-nota">Guardar</button>
                            {{-- <button type="button" class="btn btn-amarillo" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>

</div>


    <!-- Modal registrar tanque-->
    <div class="modal fade bd-example-modal-lg" id="modal-registrar-tanque" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-onix">
                    <h4 class="modal-title" id="modalinsertarTitle">Registrar Tanque</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
                <div class="modal-body">
                        {{-- input --}}
                        
                        @include('tanques.create')
                        
                        {{-- endinputs --}}
                    <!-- botones Aceptar y cancelar-->
                    <div class="row justify-content-center" >
                        <div class="btn-group col-auto" style="margin:10px" >
                        <button type="button" class="btn btn-amarillo" id="btn-registrar-tanque">Aceptar</button>
                        </div>
                        <div class="btn-group col-auto" style="margin:10px">
                        <button  class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/talon/create.js') }}"></script>
<script src="{{ asset('js/clientes_sc/edit_save.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#id-menu-talon").addClass('active');
    });
</script>
<!--Fin Scripts-->