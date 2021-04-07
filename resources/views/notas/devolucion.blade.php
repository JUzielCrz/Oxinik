{{-- @extends('layouts.navbar')
@section('contentnavbar')


<style>
    body {
        background-color: #e8ebf7;
    }
</style>

    <div class="container ">
    <form id="idFormDevolucionNota">
        @csrf
        <div class="card">
            <div class="card-body">
                <h1 class="display-1" style="font-size: 30px"> <strong>Devoluciones</strong></h1>
            </div>
        </div>
        <hr>
        <div class="card" >
            <div class="card-body">
                <center>
                    <div id="divmsgnota" style="display:none" class="alert" role="alert">
                    </div>
                </center>
                @csrf
                {!! Form::hidden('num_contrato', $notas->num_contrato, ['id'=>'num_contrato']) !!}
                {!! Form::hidden('ideditnota', $notas->id, ['id'=>'ideditnota']) !!}
                {!! Form::hidden('idcliente', $idcliente, ['id'=>'idcliente']) !!}

                <fieldset disabled>
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('Folio Nota*') !!}
                            {!! Form::number('folio_nota', $notas->folio_nota, ['id'=>'folio_nota', 'class' => 'form-control', 'placeholder'=>'Folio', 'required' ]) !!}
                            <span  id="folio_notaError" class="text-danger"></span>
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('Fecha*') !!}
                            {!! Form::date('fecha', $notas->fecha, ['id'=>'fecha', 'class' => 'form-control', 'required' ]) !!}
                            <span  id="fechaError" class="text-danger"></span>
                        </div>
                    </div>
                    
                    @php
                        if( $notas->pago_realizado != 'NO'){
                            $porciones = explode(" ", $notas->pago_realizado);
                            $pago1=$porciones[0];
                            $pago2=$porciones[1];
                            $disabled='';

                        }else{
                            $pago1='NO';
                            $pago2='';
                            $disabled='disabled';
                        }
                        
                    @endphp
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            {!! Form::label('Pago Realizado*') !!}
                            {{ Form::select('pago_realizado1',['SI' => 'SI', 'NO' => 'NO'], $pago1,['id' => 'pago_realizado1','class'=>'form-control', 'placeholder'=>'Selecciona'])}}
                            <span  id="pago_realizadoError" class="text-danger"></span>
                        </div>

                        <div class="form-group col-md-3">
                            {!! Form::label('*') !!}
                            {!! Form::date('pago_realizado2', $pago2, ['id'=>'pago_realizado2', 'class' => 'form-control', 'required', $disabled ]) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('Metodo de Pago*') !!}
                            {{ Form::select('metodo_pago',[
                                'Efectivo' => 'Efectivo',
                                'Transferencia' => 'Transferencia', 
                                'Tarjeta Credito' => 'Tarjeta Credito', 
                                'Tarjeta Debito' => 'Tarjeta Debito',  
                                'Cheque' => 'Cheque'
                                ], $notas->metodo_pago,['id' => 'metodo_pago','class'=>'form-control', 'placeholder'=>'Selecciona'])}}
                            <span  id="metodo_pagoError" class="text-danger"></span>
                        </div>
                    </div>
                </fieldset>
    
            </div>
        </div>

        

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="display-1" style="font-size: 20px"> <strong>Tanques Entregados</strong></h5>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                {{-- <th scope="col">CHECK</th> --}}
                                <th scope="col"># SERIE</th>
                                <th scope="col">DESCRIPCIÓN</th>
                                <th scope="col">PRECIO</th>
                                <th scope="col">REGULADOR</th>
                                <th scope="col">TAPA</th>
                            </tr>
                        </thead>
                        
                        <tbody id="tablelistaTanques">
                            @foreach ($notasTanques as $tanqs)
                                <tr class='classfilatanque'>
                                    
                                    <td>{{$tanqs->num_serie}}</td> 
                                    <td>{{$tanqs->capacidad}}, {{$tanqs->material}}, {{$tanqs->fabricante }} </td>
                                    <td>{{$tanqs->precio}} </td> 
                                    <td>{{$tanqs->regulador}} </td>
                                    <td>{{$tanqs->tapa_tanque}} </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
    
                    </table>
                </div>

                <hr>
                <div class="row ">
                    <div class="col-md-9 text-right">
                        <label>TOTAL:</label>
                    </div>
                    <div class="col-md-1 text-right">
                        <div>
                            <label>{{$notas->total}}</label>
                        </div>
                    </div>
                </div>

                <center>
                    <div id="divmsgtanque" style="display:none" class="alert" role="alert">
                    </div>
                </center>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <div class="row">
                    @csrf
                    <div class="col-md-3">
                        <h5 class="display-1" style="font-size: 20px"> <strong>Devolución de tanques</strong></h5>
                    </div>
                    @csrf
                    <div class="col-md-4">
                        {!! Form::text('serie_tanque', null, ['id'=>'serie_tanque', 'class' => 'form-control eliminar-espacio', 'placeholder'=>'#Serie', 'required' ]) !!}
                        <span  id="serie_tanqueError" class="text-danger"></span>
                    </div>
                    <div class="col-md-5 align-self-end text-right">
                        <button type="button" class="btn btn-grisclaro m-auto" id="btnModalDevolucion"> <span class="fas fa-plus"></span>Agregar</button>
                    </div> 
                </div>
                
            </div>
            <div class="card-body">
                
                <div class="table-responsive ">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#SERIE</th>
                                <th scope="col">DESCRIPCIÓN</th>
                                <th scope="col">REGULADOR</th>
                                <th scope="col">TAPA</th>
                                <th scope="col">MULTA</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="filadevolucion">
                            
                        </tbody>

                        <tbody>
                            @foreach ($devolucionTanques as $devt)
                            <tr class='classfilasdevolucion'>
                                <td>{{$devt->num_serie}}</td> <input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value={{$devt->num_serie}}>
                                <td>{{$tanqs->capacidad}}, {{$tanqs->material}}, {{$tanqs->fabricante }}</td><input type='hidden' name='inputDescripcion[]' value={{$tanqs->capacidad}}, {{$tanqs->material}}, {{$tanqs->fabricante }}>
                                <td>{{$devt->regulador}}</td> <input type='hidden' name='inputRegulador[]' value={{$devt->regulador}}>
                                <td>{{$devt->tapa_tanque}}</td> <input type='hidden' name='inputTapa[]' value={{$devt->tapa_tanque}}>
                                <td>{{$devt->multa}}</td> <input type='hidden' name='inputMulta[]' value={{$devt->multa}}>
                                <td><button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button> </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row ">
                    <div class="col-md-9 text-right">
                        <label for="">SUB-TOTAL:</label>
                    </div>
                    <div class="col-md-1 text-right">
                            <label id='subtotal'>{{$notas->total}}</label>
                            <input type="hidden" id="subtotalhid" value={{$notas->total}}>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-9 text-right">
                        <label for="">MULTAS:</label>
                    </div>
                    <div class="col-md-1 text-right">
                            <label id='sumamultas'>0</label>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-9 text-right">
                        <label for="">TOTAL:</label>
                    </div>
                    <div class="col-md-1 text-right">
                        <label id='total'>{{$notas->total}}</label>
                    </div>
                </div>

            </div>
            
        </div>
    </form>

        <div class="card ">
            <div class="card-body ">
                <div class="row justify-content-center">
                        <button class="btn btn-grisclaro" id="btnCancelar">Cancelar</button>
                        <button class="btn btn-grisclaro ml-2" id="btnGuardar">Guardar</button>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Modal devolucion tanque encontrado-->
    <div class="modal fade bd-example-modal-md" id="modaldevolucion1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-onix">
                    <h4 class="modal-title" id="modalinsertarTitle">Devolucion Tanque</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button> --}}
                </div>
                <div class="modal-body">
                        {{-- input --}}
                        <div class='col-md-12'>
                            {!! Form::label('#Serie') !!}
                            {!! Form::text('serie_modal', null, ['id'=>'serie_modal', 'class' => 'form-control', 'placeholder'=>'#Serie', 'required', 'disabled' ]) !!}                           
                            <span  id='serie_modalError' class='text-danger'></span>
                        </div>
                        <div class='col-md-12'>
                            {!! Form::label('#Descripción') !!}
                            {!! Form::textarea('descripcion', null, ['id'=>'descripcion', 'class' => 'form-control', 'placeholder'=>'#Serie', 'rows'=>2, 'required', 'disabled' ]) !!}                           
                            <span  id='descripcionError' class='text-danger'></span>
                        </div>  
                        <div class='col-md-12'>
                            {!! Form::label('Regulador') !!}
                            {{ Form::select('regulador',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'regulador','class'=>'form-control', 'placeholder'=>'Selecciona', 'required'])}}
                            <span  id='reguladorError' class='text-danger'></span>
                        </div>  
                        <div class='col-md-12'>
                            {!! Form::label('Tapa') !!}
                            {{ Form::select('tapa_tanque',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque','class'=>'form-control', 'placeholder'=>'Selecciona', 'required'])}}
                            <span  id='tapa_tanqueError' class='text-danger'></span>
                        </div>
                        <div class='col-md-12'>
                            {!! Form::label('Multa') !!}
                            {!! Form::number('multa', null, ['id'=>'multa', 'class' => 'form-control precio', 'placeholder'=>'$0.0' ]) !!}
                            <span  id='multaError' class='text-danger'></span>
                        </div>
                        
                        {{-- endinputs --}}
                    <!-- botones Aceptar y cancelar-->
                    <div class="row justify-content-center" >
                        <div class="btn-group col-auto" style="margin:10px" >
                        <button type="button" class="btn btn-gray" id="btnInsertFila">Aceptar</button>
                        </div>
                        <div class="btn-group col-auto" style="margin:10px">
                        <button  class="btn btn-gray" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Modal devolucion tanque NO encontrado-->
    <div class="modal fade bd-example-modal-lg" id="modaldevolucion2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-onix">
                    <h4 class="modal-title" id="modalinsertarTitle">Registrar Tanque</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
                <div class="modal-body">
                        {{-- input --}}
                        
                        @include('notas.registertanque')
                        
                        {{-- endinputs --}}
                    <!-- botones Aceptar y cancelar-->
                    <div class="row justify-content-center" >
                        <div class="btn-group col-auto" style="margin:10px" >
                        <button type="button" class="btn btn-gray" id="btnInsertFilaRegtanque">Aceptar</button>
                        </div>
                        <div class="btn-group col-auto" style="margin:10px">
                        <button  class="btn btn-gray" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>



@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/notatanquedevolucion.js') }}"></script>
<!--Fin Scripts-->
