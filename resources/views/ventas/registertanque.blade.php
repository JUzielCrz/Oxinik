<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>
    @csrf
    <label class="text-danger">* OBLIGATORIO </label>
    <hr>

        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Número de serie*') !!}
                {!! Form::text('num_seriefila', null, ['id'=>'num_seriefila', 'class' => 'form-control', 'placeholder'=>'Número de serie', 'required' ]) !!}
                <span  id="num_seriefilaError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('PH*') !!}
                {!! Form::month('phfila', null, ['id'=>'phfila', 'class' => 'form-control']) !!}
                <span  id="phfilaError" class="text-danger"></span>
        </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('Capacidad*') !!}
                {!! Form::number('capacidadnum', null, ['id'=>'capacidadnum', 'class' => 'form-control', 'max'=>'10','placeholder'=>'Capacidad']) !!}
                <span  id="capacidadfilaError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('*') !!}
                {{ Form::select('unidadmedida',['m3' => 'm3', 'kilos' => 'kilos' ],null,['id' => 'unidadmedida','class'=>'form-control'])}}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('Material*') !!}
                {{ Form::select('materialfila',['Acero' => 'Acero', 'Aluminio' => 'Aluminio' ],null,['id' => 'materialfila','class'=>'form-control', 'placeholder'=>'Selecciona'])}}
                <span  id="materialfilaError" class="text-danger"></span>
            </div>
            
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Fabricante*') !!}
                {{ Form::select('fabricanteoficial',['Infra' => 'Infra', 'Plaxair' => 'Plaxair', 'Otros' => 'Otros' ],null,['id' => 'fabricanteoficial','class'=>'form-control', 'placeholder'=>'Fabricante'])}}
                <span  id="fabricantefilaError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('*') !!}
                {!! Form::text('otrofabricante', null, ['id'=>'otrofabricante', 'class' => 'form-control', 'placeholder'=>'Fabricante', 'required', 'disabled' ]) !!}
                <span  id="fabricanteotrosError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Tipo de Gas*') !!}
                {!! Form::text('tipo_gasfila', null, ['id'=>'tipo_gasfila', 'class' => 'form-control', 'placeholder'=>'Tipo de Gas', 'required' ]) !!}
                <span  id="tipo_gasfilaError" class="text-danger"></span>
            </div>
        </div>

