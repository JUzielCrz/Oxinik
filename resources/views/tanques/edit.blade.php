<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>

    @csrf
    <label class="text-danger">* OBLIGATORIO </label>
    <hr>

    {!! Form::hidden('idedit', null, ['id'=>'idedit']) !!}
    
        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Número de serie*') !!}
                {!! Form::text('num_serieedit', null, ['id'=>'num_serieedit', 'class' => 'form-control', 'placeholder'=>'Número de serie', 'required' ]) !!}
                <span  id="num_serieeditError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('PH*') !!}
                {!! Form::month('phedit', null, ['id'=>'phedit', 'class' => 'form-control', 'placeholder'=>'PH']) !!}
                <span  id="pheditError" class="text-danger"></span>
        </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('Capacidad*') !!}
                {!! Form::number('capacidadnumedit', null, ['id'=>'capacidadnumedit', 'class' => 'form-control', 'max'=>'10','placeholder'=>'Capacidad']) !!}
                <span  id="capacidadeditError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('*') !!}
                {{ Form::select('unidadmedidaedit',['m3' => 'm3', 'kilos' => 'kilos' ],null,['id' => 'unidadmedidaedit','class'=>'form-control'])}}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('Material*') !!}
                {{ Form::select('materialedit',['Acero' => 'Acero', 'Aluminio' => 'Aluminio' ],null,['id' => 'materialedit','class'=>'form-control', 'placeholder'=>'Material'])}}
                <span  id="materialeditError" class="text-danger"></span>
            </div>
            
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Fabricante*') !!}
                {{ Form::select('fabricanteoficialedit',['Infra' => 'Infra', 'Plaxair' => 'Plaxair', 'Otros' => 'Otros' ],null,['id' => 'fabricanteoficialedit','class'=>'form-control', 'placeholder'=>'Fabricante'])}}
                <span  id="fabricanteeditError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('*') !!}
                {!! Form::text('otrofabricanteedit', null, ['id'=>'otrofabricanteedit', 'class' => 'form-control', 'placeholder'=>'Fabricante', 'required', 'disabled' ]) !!}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Tipo de Gas*') !!}
                {!! Form::text('tipo_gasedit', null, ['id'=>'tipo_gasedit', 'class' => 'form-control', 'placeholder'=>'Tipo de Gas', 'required' ]) !!}
                <span  id="tipo_gaseditError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('Estatus*') !!}
                {{ Form::select('estatusedit',['VACIO-ALMACEN' => 'VACIO-ALMACEN', 'LLENO-ALMACEN' => 'LLENO-ALMACEN', 'INFRA' => 'INFRA', 'ENTREGADO-CLIENTE' => 'ENTREGADO-CLIENTE' ,'MANTENIMIENTO' => 'MANTENIMIENTO' ],null,['id' => 'estatusedit','class'=>'form-control', 'placeholder'=>'selecciona'])}}
                <span  id="estatuseditError" class="text-danger"></span>
            </div>
        </div>

</form>
