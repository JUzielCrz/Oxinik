<fieldset disabled>

            <!-- Nombre Completo-->
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('Número de serie') !!}
                    {!! Form::text('num_serieinfo', null, ['id'=>'num_serieinfo', 'class' => 'form-control', 'placeholder'=>'Número de serie', 'required' ]) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('PH') !!}
                    {!! Form::text('phinfo', null, ['id'=>'phinfo', 'class' => 'form-control', 'placeholder'=>'PH']) !!}
            </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('Capacidad') !!}
                    {!! Form::text('capacidadinfo', null, ['id'=>'capacidadinfo', 'class' => 'form-control', 'max'=>'10','placeholder'=>'Capacidad']) !!}
                </div>
    
                <div class="form-group col-md-6">
                    {!! Form::label('Material') !!}
                    {!! Form::text('materialinfo', null, ['id'=>'materialinfo', 'class' => 'form-control', 'max'=>'10','placeholder'=>'Capacidad']) !!}
                </div>
                
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('Fabricante') !!}
                    {!! Form::text('fabricanteinfo', null, ['id'=>'fabricanteinfo', 'class' => 'form-control', 'placeholder'=>'Número de serie', 'required' ]) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('Tipo de Gas') !!}
                    {{-- {!! Form::text('gas_nombreinfo', null, ['id'=>'tipo_gasinfo', 'class' => 'form-control', 'placeholder'=>'Tipo de Gas', 'required' ]) !!} --}}
                    {{ Form::select('tipo_gasinfo', $catalogo, null, ['id'=>'tipo_gasinfo', 'class' => 'form-control form-control-sm']) }}

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('Tipo') !!}
                    {!! Form::text('tipo_tanqueinfo', null, ['id'=>'tipo_tanqueinfo', 'class' => 'form-control', 'placeholder'=>'Número de serie', 'required' ]) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('Estatus') !!}
                    {!! Form::text('estatusinfo', null, ['id'=>'estatusinfo', 'class' => 'form-control', 'placeholder'=>'Tipo de Gas', 'required' ]) !!}
                </div>
            </div>
    
    </form>
    
</fieldset>