<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>

  <form id="idFormContrato">
    @csrf
    <label class="text-danger">* OBLIGATORIO </label>
    <hr>

    <input type="hidden" name="idedit" id="idedit" value="">
        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('Número de Contrato*') !!}
                {!! Form::number('num_contratoedit', null, ['id'=>'num_contratoedit', 'class' => 'form-control', 'placeholder'=>'Número de Contrato', 'required' ]) !!}
            <span  id="num_contratoeditError" class="text-danger"></span>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('Tipo de Contrato*') !!}
                {{ Form::select('tipo_contratoedit',['PERMANENTE INDUSTRIAL' => 'PERMANENTE INDUSTRIAL', 
                                                'PERMANENTE MEDICINAL' => 'PERMANENTE MEDICINAL',  
                                                'EVENTUAL' => 'EVENTUAL' 
                                                ],null,['id' => 'tipo_contratoedit','class'=>'form-control', 'placeholder'=>'Selecciona'])}}
                <span  id="tipo_contratoeditError" class="text-danger"></span>
            </div>
        
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('Precio Transporte*') !!}
                {!! Form::number('precio_transporteedit', null, ['id'=>'precio_transporteedit', 'class' => 'form-control', 'placeholder'=>'$000.00']) !!}
                <span  id="precio_transporteeditError" class="text-danger"></span>
            </div>
        </div>
        
</form>
