<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>

  <form id="idFormCliente">
    @csrf
    <label class="text-danger">* OBLIGATORIO </label>
    <hr>

        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Número de serie*') !!}
                {!! Form::text('num_serie', null, ['id'=>'num_serie', 'class' => 'form-control', 'placeholder'=>'#serie', 'required' ]) !!}
                <span  id="num_serieError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('PH*') !!}
                {!! Form::month('ph', null, ['id'=>'ph', 'class' => 'form-control', 'placeholder'=>'PH']) !!}
                <span  id="phError" class="text-danger"></span>
        </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('Capacidad*') !!}
                {!! Form::number('capacidadnum', null, ['id'=>'capacidadnum', 'class' => 'form-control', 'max'=>'10','placeholder'=>'#']) !!}
                <span  id="capacidadError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('*') !!}
                {{ Form::select('unidadmedida',['Carga' => 'Carga','m3' => 'm3', 'kilos' => 'kilos' ],null,['id' => 'unidadmedida','class'=>'form-control'])}}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('Material*') !!}
                {{ Form::select('material',['Acero' => 'Acero', 'Aluminio' => 'Aluminio' ],null,['id' => 'material','class'=>'form-control', 'placeholder'=>'selecciona'])}}
                <span  id="materialError" class="text-danger"></span>
            </div>
            
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Fabricante*') !!}
                {{ Form::select('fabricanteoficial',['Infra' => 'Infra', 'Plaxair' => 'Plaxair', 'Otros' => 'Otros' ],null,['id' => 'fabricanteoficial','class'=>'form-control', 'placeholder'=>'selecciona'])}}
                <span  id="fabricanteError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('*') !!}
                {!! Form::text('otrofabricante', null, ['id'=>'otrofabricante', 'class' => 'form-control',  'required', 'disabled' ]) !!}
                <span  id="fabricanteotrosError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">

            <div class="form-group col-md-6">
                {!! Form::label('Tipo de Gas*') !!}
                {{ Form::select('tipo_gas', $catalogo, null, ['id'=>'tipo_gas', 'class' => 'form-control', 'required' ]) }}
                <span  id="tipo_gasError" class="text-danger"></span>
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('estatus*') !!}
                {{ Form::select('estatus',['VACIO-ALMACEN' => 'VACIO-ALMACEN', 'LLENO-ALMACEN' => 'LLENO-ALMACEN', 'INFRA' => 'INFRA', 'ENTREGADO-CLIENTE' => 'ENTREGADO-CLIENTE' ,'MANTENIMIENTO' => 'MANTENIMIENTO' ],null,['id' => 'estatus','class'=>'form-control', 'placeholder'=>'selecciona'])}}
                <span  id="estatusError" class="text-danger"></span>
            </div>

        </div>

</form>
