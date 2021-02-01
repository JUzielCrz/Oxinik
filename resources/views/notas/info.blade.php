<fieldset disabled>
        <label class="text-danger">* OBLIGATORIO </label>
        <hr>
            @csrf
            <!-- Nombre Completo-->
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('Número de Contrato*') !!}
                    {!! Form::number('num_contratoinfo', null, ['id'=>'num_contratoinfo', 'class' => 'form-control', 'placeholder'=>'Número de Contrato', 'required' ]) !!}
                    <span  id="num_contratoinfoError" class="text-danger"></span>
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('Tipo Contrato*') !!}
                    {{ Form::select('tipo_contratoinfo',['Eventual' => 'Eventual', 'Permanente Industrial' => 'Permanente Industrial', 'Permanente Medicinal' => 'Permanente Medicinal' ],null,['id' => 'tipo_contratoinfo','class'=>'form-control', 'placeholder'=>'Tipo Contrato'])}}
                    <span  id="tipo_contratoinfoError" class="text-danger"></span>
            </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('Precio Definido*') !!}
                    {!! Form::number('precio_definidoinfo', null, ['id'=>'precio_definidoinfo', 'class' => 'form-control', 'placeholder'=>'Precio', 'required' ]) !!}
                    <span  id="precio_definidoinfo" class="text-danger"></span>
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('Precio Transporte*') !!}
                    {!! Form::number('precio_transporteinfo', null, ['id'=>'precio_transporteinfo', 'class' => 'form-control', 'placeholder'=>'Precio', 'required' ]) !!}
                    <span  id="precio_transporteinfo" class="text-danger"></span>
                </div>
            </div>
</fieldset>