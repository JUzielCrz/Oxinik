<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>

    @csrf
    <label class="text-danger">* OBLIGATORIO </label>
    <hr>

    <input type="hidden" name="idedit" id="idedit" value="">
        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Número de Contrato*') !!}
                {!! Form::number('num_contratoedit', null, ['id'=>'num_contratoedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'Número de Contrato', 'required' ]) !!}
            <span  id="num_contratoeditError" class="text-danger"></span>
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('Tipo de Contrato*') !!}
                {!! Form::text('tipo_contratoedit', null, ['id'=>'tipo_contratoedit', 'class' => 'form-control form-control-sm', 'required', 'readonly']) !!}

                {{-- {{ Form::select('tipo_contratoedit',['Industrial' => 'Industrial', 
                                                'Medicinal' => 'Medicinal',  
                                                'Eventual' => 'Eventual' 
                                                ],null,['id' => 'tipo_contratoedit','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}} --}}
                <span  id="tipo_contratoeditError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <label for="">Nombre Comercial</label>
                <input name="nombre_comercialedit" id="nombre_comercialedit" type="text" class="form-control form-control-sm" >
                <span  id="nombre_comercialeditError" class="text-danger"></span>
            </div>
            <div class="form-group col">
                <label for="">Mod. Regulador</label>
                <input name="modelo_reguladoredit" id="modelo_reguladoredit" type="text" class="form-control form-control-sm" >
                <span  id="modelo_reguladoreditError" class="text-danger"></span>
            </div>
        </div>        
        
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('#Reguladores*') !!}
                {!! Form::select('reguladoresedit',[0 => 0,1 => 1, 2 => 2,3 => 3, 4 => 4, 5 => 5,6 => 6 
                ] ,null, ['id'=>'reguladoresedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'#', 'required' ]) !!}
                <span  id="reguladoreseditError" class="text-danger"></span>
            </div>
            
            <div class="form-group col-md-6">
                {!! Form::label('Precio Transporte*') !!}
                {!! Form::number('precio_transporteedit', null, ['id'=>'precio_transporteedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'$0']) !!}
                <span  id="precio_transporteeditError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <label for="">Dirección envío</label>
                <textarea name="direccionedit" id="direccionedit" class="form-control form-control-sm" cols="30" rows="2"></textarea>
            </div>
            <div class="col-md-6">
                <label for="">Referencia</label>
                <textarea name="referenciaedit" id="referenciaedit" class="form-control form-control-sm" cols="30" rows="2"></textarea>
            </div>
        </div>

        <div class="form-row">Entre las calles:</div>
        <div class="form-row">
            <div class="col">
                <textarea name="calle1edit" id="calle1edit" class="form-control form-control-sm" cols="30" rows="1"  placeholder="CALLE 1"></textarea>
                <span  id="calle1editError" class="text-danger"></span>
            </div>
            <div class="col">
                <textarea name="calle2edit" id="calle2edit" class="form-control form-control-sm" cols="30" rows="1" placeholder="CALLE 2"></textarea>
                <span  id="calle2editError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <label for="">URL Ubicación</label>
                <textarea name="link_ubicacionedit" id="link_ubicacionedit" class="form-control form-control-sm" cols="30" rows="3"></textarea>
            </div>
            
        </div>

