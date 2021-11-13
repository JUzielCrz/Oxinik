@extends('layouts.navbar')
@section('contentnavbar')

<style>
    body {
        background-color: #e8ebf7;
    }
</style>

    <div class="container ">
    <form id="idFormNewNota">
        <div class="card" >
            <div class="card-body">
                <center>
                    <div id="divmsgnota" style="display:none" class="alert" role="alert">
                    </div>
                </center>
                @csrf
                <label class="text-danger">* OBLIGATORIO </label>

                {!! Form::hidden('num_contrato', $notas->num_contrato, ['id'=>'num_contrato']) !!}
                {!! Form::hidden('ideditnota', $notas->id, ['id'=>'ideditnota']) !!}
                {!! Form::hidden('idcliente', $idcliente, ['id'=>'idcliente']) !!}

                <!-- Nombre Completo-->
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
    
            </div>
        </div>


        <div class="card mt-4">
            <div class="card-header">
                <div class="row justify-content-center">
                    @csrf
                    <div class="col-md-4">
                        {!! Form::label('# Serie') !!}
                        {!! Form::text('serie_tanque', null, ['id'=>'serie_tanque', 'class' => 'form-control', 'placeholder'=>'#Serie', 'required' ]) !!}
                        <span  id="serie_tanqueError" class="text-danger"></span>
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('Precio') !!}
                        {!! Form::number('precio', null, ['id'=>'precio', 'class' => 'form-control', 'placeholder'=>'$0.0', 'required' ]) !!}
                        <span  id="precioError" class="text-danger"></span>
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('Regulador') !!}
                        {{ Form::select('regulador',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'regulador','class'=>'form-control ml-2', 'placeholder'=>'Selecciona', 'required'])}}
                        <span  id="reguladorError" class="text-danger"></span>
                    </div>  
                    <div class="col-md-2">
                        {!! Form::label('Tapa') !!}
                        {{ Form::select('tapa_tanque',['SI' => 'SI', 'NO' => 'NO'],null,['id' => 'tapa_tanque','class'=>'form-control ml-2', 'placeholder'=>'Selecciona', 'required'])}}
                        <span  id="tapa_tanqueError" class="text-danger"></span>
                    </div>  
                    <div class="col-md-2">
                        <button type="button" class="btn btn-verde m-auto" id="btnInsertFila"> <span class="fas fa-plus"></span>Agregar</button>
                    </div> 
                </div>
            </div>
            


            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"># SERIE</th>
                                <th scope="col">DESCRIPCIÓN</th>
                                <th scope="col">PRECIO</th>
                                <th scope="col">REGULADOR</th>
                                <th scope="col">TAPA</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        
                        <tbody id="tablelistaTanques">
                            @foreach ($notasTanques as $tanqs)
                                <tr class='classfilatanque' >
                                    <td>{{$tanqs->num_serie}}</td> <input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value={{$tanqs->num_serie}}>
                                    <td>{{$tanqs->capacidad}} {{$tanqs->material}} {{$tanqs->fabricante }} </td>
                                    <td>{{$tanqs->precio}} </td> <input type='hidden' name='inputPrecio[]' value={{$tanqs->precio}} >
                                    <td>{{$tanqs->regulador}} </td> <input type='hidden' name='inputRegulador[]' value={{$tanqs->regulador}}>
                                    <td>{{$tanqs->tapa_tanque}} </td> <input type='hidden' name='inputTapa[]' value={{$tanqs->tapa_tanque}}>
                                    <td> <button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button> </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
    
                    </table>
                </div>
                <hr>
                <div class="row ">
                    <div class="col-md-9 text-right">
                        <label for="">TOTAL:</label>
                    </div>
                    <div class="col-md-1 text-right">
                        <div id="preciototal">
                            <label id='total'>{{$notas->total}}</label>
                        </div>
                        <input type="hidden" id="inputTotal" name="inputTotal" value={{$notas->total}}>
                    </div>
                </div>
                <center>
                    <div id="divmsgtanque" style="display:none" class="alert" role="alert">
                    </div>
                </center>
            </div>
        </div>

    </form>

        <div class="card ">
            <div class="card-body ">
                <div class="row justify-content-center">
                        <button class="btn btn-verde" id="btnCancelar">Cancelar</button>
                        <button class="btn btn-verde ml-2" id="btnGuardar">Guardar</button>
                </div>
            </div>
        </div>
        
    </div>



                

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/notatanqueedit.js') }}"></script>
<!--Fin Scripts-->
