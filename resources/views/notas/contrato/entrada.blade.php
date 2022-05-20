@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

<style>
    .width-column {
        width: 5rem;
    }
</style>

<div class="container-fluid">
    
    <form id="form-entrada-nota">
    
        <div class="row">
            <div class="col-md-8">
                <fieldset class="InputsFilaEntrada" disabled="disabled">
                <div class="card">
                    <div class="card-header">
                        <h5>Tanques Entrada</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="row justify-content-center">
                            @csrf
                            <div class="col">
                                {!! Form::label('# Serie') !!}
                                {!! Form::text('serie_tanque', null, ['id'=>'serie_tanque', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}
                            </div>
                            {{-- <div class="col">
                                {!! Form::label('Tapa') !!}
                                <div class="input-group  input-group-sm">
                                    {{ Form::select('tapa_tanque',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input id="tapa_tanque_check" type="checkbox" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col align-self-end">
                                <button type="button" class="btn btn-verde" id="btnInsertFila"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>
                        <span  id="serie_tanqueError" class="text-danger"></span> <span id="span_no_existe" ></span>
                        
                        <hr>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">DESCRIPCIÓN</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">CAMBIO</th>
                                        <th scope="col">RECARGOS</th>
                                        <th scope="col">OBSERV.</th>
                                        
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                
                                <tbody id="tablelistaTanques">
                                </tbody>
            
                            </table>
                        </div>
                        <center>
                            <div id="msg-tanques" style="display:none" class="alert" role="alert">
                            </div>
                        </center>
                    </div>
                </div>
                </fieldset>

                
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Pendientes</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table-tanques-nota" class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr style="font-size: 13px">
                                            <th scope="col">#</th>
                                            <th scope="col">#SERIE</th>
                                            <th scope="col">DESCRIPCIÓN</th>
                                            <th scope="col">TAPA</th>
                                            <th scope="col">FECHA</th>
                                            <th scope="col">NOTA</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody id="tbody-tanques-nota">
                                    </tbody>
                                </table>
                            </div>
                            <center>
                                <div id="msg-tanques" style="display:none" class="alert" role="alert">
                                </div>
                            </center>
                        </div>
                    </div>
            </div>
            
            <div class="col-md-4">
                <div class="card " >
                    <div class="card-body">
                        @csrf
                        <center>
                            <div id="msg-contrato" style="display:none" class="alert" role="alert">
                            </div>
                        </center>

                        <div class="row">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-search" id="inputGroup-sizing-sm"></span>
                                </div>
                                <input id="search-contrato-id" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                            </div>
                        </div>
                        <div id="listar-contratos"></div>
                    </div>
                    <div class="card-body">
                        {{-- Cliente--}}
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Cliente:</span>
                                </div>
                                <input id="nombre_cliente" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled>
                            </div>
                        </div>
                        {{-- Numero contrato--}}
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"># Contrato:</span>
                                </div>
                                <input id="contrato_id" name="contrato_id" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        {{-- tipo contrato--}}
                        <div class="form-row">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Tipo:</span>
                                </div>
                                <input id="tipo_contrato" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <div class="row" >
                            <div class="col">
                                <p>ASIGNACIONES</p>
                            </div>
                            {{-- <div class="col-4-md">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-amarillo" type="button" id="btn-modal-asignacion-minus"> <span class="fas fa-minus"></span></button>
                                    </div>
                                    <div class="input-group-prepend">
                                        <button class="btn btn-amarillo" type="button" id="btn-modal-asignacion-plus"> <span class="fas fa-plus"></span></button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                            <div id="content-asignaciones">
                                
                            </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col">
                                <label for="">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-verde" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-verde ml-2" id="btn-pagar-nota">Continuar</button>
                            {{-- <button type="button" class="btn btn-amarillo" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div> 

        
        <!-- Modal Pagar-->
        <div class="modal fade" id="static-modal-pago" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Resumén</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    @include('notas.contrato.modal_pago_entrada')                    
                </div>
                <div class="modal-footer">
                {{-- <button type="button" class="btn btn-verde" data-dismiss="modal">Cancelar</button> --}}
                <button id="guardar-nota" type="button" class="btn btn-verde">Guardar</button>
                </div>
            </div>
            </div>
        </div>

    </form>
    
</div>




  


    <!-- Modal generico-->
    {{-- <div class="modal fade bd-example-modal-lg" id="modal_generico" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"> --}}
    <div class="modal fade" id="modal_generico" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-onix">
                    <h4 class="modal-title" id="modal_generico_titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center"></div>
                        <div id='modal_general_contenido'>
                            {{-- contenido insertado con js --}}
                        </div>
                    <div class="row justify-content-center" >
                        <div id='modal_general_botones' ></div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>


    
@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/contrato/entrada.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#id-menu-contrato").addClass('active');
    });
</script>

<!--Fin Scripts-->
