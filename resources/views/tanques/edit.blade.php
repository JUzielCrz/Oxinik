<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
</center>

    @csrf

    {!! Form::hidden('idedit', null, ['id'=>'idedit']) !!}
    
    <div class="form-row">
        <div class="form-group col-md-4">
            {!! Form::label('Número de serie') !!}
            {!! Form::text('num_serieedit', null, ['id'=>'num_serieedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'#serie', 'readonly' ]) !!}
            <span  id="num_serieeditError" class="text-danger"></span>
        </div>

        <div class="form-group col-md-2">
            {!! Form::label('Capacidad') !!}
            
            <select name="unidadmedidaedit" id="unidadmedidaedit" class="form-control form-control-sm">
                <option value="">Selecione</option>
                <option value="Carga">Carga</option>
                <option value="m3">m3</option>
                <option value="kilos">kilos</option>
            </select>
        </div>
        
        <div class="form-group col-md-2">
            {!! Form::label('*') !!}
            {!! Form::number('capacidadnumedit', null, ['id'=>'capacidadnumedit', 'class' => 'form-control form-control-sm', 'max'=>'10','placeholder'=>'#']) !!}
            <span  id="capacidadeditError" class="text-danger"></span>
        </div>

        <div class="form-group col-md-2">
            {!! Form::label('PH') !!}
            <select name="ph_mesedit" id="ph_mesedit" class="form-control form-control-sm">
                <option value="">Mes</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            <span  id="pheditError" class="text-danger"></span>
        </div>
        <div class="form-group col-md-2">
            {!! Form::label('.') !!}
            {!! Form::number('ph_anioedit', null, ['id'=>'ph_anioedit', 'class' => 'form-control form-control-sm anio_format', 'placeholder'=>'Año']) !!}
        </div>
    </div>
    
    <div class="form-row">
        
        
        <div class="form-group col-md-3">
            {!! Form::label('Material') !!}
            {{ Form::select('materialedit',['Acero' => 'Acero', 'Aluminio' => 'Aluminio' ],null,['id' => 'materialedit','class'=>'form-control form-control-sm', 'placeholder'=>'selecciona'])}}
            <span  id="materialeditError" class="text-danger"></span>
        </div>
        <div class="form-group col-md-3">
            {!! Form::label('Tipo') !!}
            {{ Form::select('tipo_tanqueedit',['Industrial' => 'Industrial', 'Medicinal' => 'Medicinal' ],null,['id' => 'tipo_tanqueedit','class'=>'form-control form-control-sm', 'placeholder'=>'selecciona'])}}
            <span  id="tipo_tanqueeditError" class="text-danger"></span>
        </div>

        <div class="form-group col-md-2">
            {!! Form::label('Fabricante') !!}
            {{ Form::select('fabricanteoficialedit',['Infra' => 'Infra', 'Praxair' => 'Praxair', 'Otros' => 'Otros' ],null,['id' => 'fabricanteoficialedit','class'=>'form-control form-control-sm', 'placeholder'=>'selecciona'])}}
            <span  id="fabricanteeditError" class="text-danger"></span>
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('*') !!}
            {!! Form::text('otrofabricanteedit', null, ['id'=>'otrofabricanteedit', 'class' => 'form-control form-control-sm',  'required', 'disabled' ]) !!}
            <span  id="fabricanteotroseditError" class="text-danger"></span>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-7">
            {!! Form::label('Gas') !!}
            {{ Form::select('tipo_gasedit', $catalogo, null, ['id'=>'tipo_gasedit', 'class' => 'form-control form-control-sm', 'required', 'placeholder'=>'selecciona' ]) }}
            <span  id="tipo_gaseditError" class="text-danger"></span>
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('estatus') !!}
            {{ Form::select('estatusedit',['VACIO-ALMACEN' => 'VACIO-ALMACEN', 'LLENO-ALMACEN' => 'LLENO-ALMACEN', 'INFRA' => 'INFRA', 'ENTREGADO-CLIENTE' => 'ENTREGADO-CLIENTE' ,'MANTENIMIENTO' => 'MANTENIMIENTO' ],null,['id' => 'estatusedit','class'=>'form-control form-control-sm', 'placeholder'=>'selecciona'])}}
            <span  id="estatuseditError" class="text-danger"></span>
        </div>

    </div>

