<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>

  <form id="idFormContrato">
    @csrf
    <label class="text-danger">* OBLIGATORIO </label>
    <hr>

        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('Número de Contrato*') !!}
                {!! Form::number('num_contrato', null, ['id'=>'num_contrato', 'class' => 'form-control', 'placeholder'=>'Número de Contrato', 'required' ]) !!}
            <span  id="num_contratoError" class="text-danger"></span>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('Tipo de Contrato*') !!}
                {{ Form::select('tipo_contrato',['PERMANENTE INDUSTRIAL' => 'PERMANENTE INDUSTRIAL', 
                                                'PERMANENTE MEDICINAL' => 'PERMANENTE MEDICINAL',  
                                                'EVENTUAL' => 'EVENTUAL' 
                                                ],null,['id' => 'tipo_contrato','class'=>'form-control', 'placeholder'=>'Selecciona'])}}
                <span  id="tipo_contratoError" class="text-danger"></span>
            </div>
        
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Asignación tanques*') !!}
                {!! Form::number('asignacion_tanques', null, ['id'=>'asignacion_tanques', 'class' => 'form-control', 'placeholder'=>'#']) !!}
                <span  id="asignacion_tanquesError" class="text-danger"></span>
            </div>  
            <div class="form-group col-md-6">
                {!! Form::label('Precio Transporte*') !!}
                {!! Form::number('precio_transporte', null, ['id'=>'precio_transporte', 'class' => 'form-control', 'placeholder'=>'$0.0']) !!}
                <span  id="precio_transporteError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12">
                <label for="">Dirección</label>
                <textarea name="direccion" id="direccion" class="form-control" cols="30" rows="2"></textarea>
            </div>
            <div class="col-md-12">
                <label for="">Referencia</label>
                <textarea name="referencia" id="referencia" class="form-control" cols="30" rows="2"></textarea>
            </div>
        </div>
        
</form>
