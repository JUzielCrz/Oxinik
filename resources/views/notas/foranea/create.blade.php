@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

    <div class="container-fluid" >
        
    <form id="idFormNewVenta" style="font-size: 13px">
        @csrf
        <div class="row">
            <div class="col-md-8">
        
                {{-- SALIDA --}}
                <div class="card">
                    <div class="card-header bg-gris text-white">
                        <div class="row m-0 p-0">
                            <div class="col m-0">
                                <h5>NUEVA NOTA FORANEA</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <strong>TANQUES SALIDA</strong>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="col">
                                {!! Form::label('# Serie') !!}
                                {!! Form::text('serie_tanque', null, ['id'=>'serie_tanque', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}
                            </div>
                            <div class="col">
                                {!! Form::label('Tapa') !!}
                                <div class="input-group  input-group-sm">
                                    {{ Form::select('tapa_tanque',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input id="tapa_tanque_check" type="checkbox" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('Cantidad') !!}
                                <div class="input-group  input-group-sm">
                                    {!! Form::number('cantidad', null, ['id'=>'cantidad', 'class' => 'form-control form-control-sm numero-decimal-positivo', 'placeholder'=>'0', 'required', 'readonly' ]) !!}
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input id="cantidad_check" type="checkbox" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('U. M.') !!}
                                <div class="input-group  input-group-sm">
                                    {{ Form::select('unidad_medida',['CARGA' => 'CARGA','kg' => 'kg', 'M3' => 'M3'],null,['id' => 'unidad_medida','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona', 'required'])}}
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input id="unidad_medida_check" type="checkbox" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('Precio') !!}
                                <div class="input-group  input-group-sm">
                                    {!! Form::number('importe', null, ['id'=>'importe', 'class' => 'form-control form-control-sm numero-decimal-positivo', 'placeholder'=>'$0.0', 'required' ]) !!}
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input id="importe_check" type="checkbox" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col align-self-end">
                                <button type="button" class="btn btn-verde" id="btn-insert-fila-salida"> <span class="fas fa-plus"></span>Add</button>
                            </div> 
                        </div>
                        <span  id="serie_tanqueError" class="text-danger"></span>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover table-bordered" >
                                <thead >
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">GAS</th>
                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">U. M.</th>
                                        <th scope="col">IMPORTE</th>
                                        <th scope="col">IVA 16%</th>
                                        <th scope="col">OBSERV.</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                
                                <tbody id="tablelistaTanques">
                                </tbody>
            
                            </table>
                        </div>
                        <center>
                            <div id="msg-tanques-salida" style="display:none" class="alert" role="alert">
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
                            <button type="button" class="btn btn-verde ml-2" id="btn-pagar-nota">Pagar</button>
                            {{-- <button type="button" class="btn btn-amarillo" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>

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
            @include('notas.foranea.modal_pago_salida')
        </div>
        <div class="modal-footer">
        {{-- <button type="button" class="btn btn-verde" data-dismiss="modal">Cancelar</button> --}}
        <button id="guardar-nota" type="button" class="btn btn-verde">Guardar</button>
        </div>
    </div>
    </div>
</div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/foranea/salida.js') }}"></script>
<script src="{{ asset('js/clientes_sc/edit_save.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#id-menu-foranea").addClass('active');
    });
</script>
<!--Fin Scripts-->