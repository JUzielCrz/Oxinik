<center>
    <div id="msg-edit-envio" style="display:none" class="alert" role="alert">
    </div>
  </center>

  <form id="form-edit-envio">
        @csrf
        <div class="form-row">
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
