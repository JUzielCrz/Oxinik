<fieldset disabled>

            <!-- Nombre Completo-->
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('Número de serie*') !!}
                    {!! Form::text('num_serieinfo', null, ['id'=>'num_serieinfo', 'class' => 'form-control', 'placeholder'=>'Número de serie', 'required' ]) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('PH*') !!}
                    {!! Form::month('phinfo', null, ['id'=>'phinfo', 'class' => 'form-control', 'placeholder'=>'PH']) !!}
            </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    {!! Form::label('Capacidad*') !!}
                    {!! Form::number('capacidadnuminfo', null, ['id'=>'capacidadnuminfo', 'class' => 'form-control', 'max'=>'10','placeholder'=>'Capacidad']) !!}
                    <span  id="capacidadinfoError" class="text-danger"></span>
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('*') !!}
                    {{ Form::select('unidadmedidainfo',['m3' => 'm3', 'kilos' => 'kilos' ],null,['id' => 'unidadmedidainfo','class'=>'form-control'])}}
                </div>
    
                <div class="form-group col-md-6">
                    {!! Form::label('Material*') !!}
                    {{ Form::select('materialinfo',['Acero' => 'Acero', 'Aluminio' => 'Aluminio' ],null,['id' => 'materialinfo','class'=>'form-control', 'placeholder'=>'Material'])}}
                    <span  id="materialinfoError" class="text-danger"></span>
                </div>
                
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('Fabricante*') !!}
                    {{ Form::select('fabricanteoficialinfo',['Infra' => 'Infra', 'Plaxair' => 'Plaxair', 'Otros' => 'Otros' ],null,['id' => 'fabricanteoficialinfo','class'=>'form-control', 'placeholder'=>'Fabricante'])}}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('*') !!}
                    {!! Form::text('otrofabricanteinfo', null, ['id'=>'otrofabricanteinfo', 'class' => 'form-control', 'placeholder'=>'Fabricante', 'required', 'disabled' ]) !!}
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('Tipo de Gas*') !!}
                    {!! Form::text('tipo_gasinfo', null, ['id'=>'tipo_gasinfo', 'class' => 'form-control', 'placeholder'=>'Tipo de Gas', 'required' ]) !!}
                </div>
            </div>
    
    </form>
    
</fieldset>