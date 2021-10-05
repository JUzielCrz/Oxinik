<center>
    <div id="divmsgedit" style="display:none" class="alert" role="alert">
    </div>
  </center>

  <form id="idFormClienteedit">

    {!! Form::hidden('idedit', null, ['id'=>'idedit']) !!}
    <input type="hidden" name="tipo-clienteedit" id="tipo-clienteedit">

        <!-- Cliente o empresa-->
        <div id="empresa-clienteedit"></div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('RFC*') !!}
                {!! Form::text('rfcedit', null, ['id'=>'rfcedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'RFC']) !!}
                <span  id="rfceditError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('Correo Electronico*') !!}
                {!! Form::email('emailedit', null, ['id'=>'emailedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'Correo Electronico']) !!}
                <span  id="emaileditError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('1° Teléfono*') !!}
                {!! Form::number('telefonoedit', null, [ 'id'=>'telefonoedit', 'class' => 'form-control form-control-sm telefono', 'placeholder'=>'1° Teléfono']) !!}
                <span  id="telefonoeditError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('2° Teléfono*') !!}
                {!! Form::number('telefonorespaldoedit', null, [ 'id'=>'telefonorespaldoedit', 'class' => 'form-control form-control-sm telefono', 'placeholder'=>'2° Teléfono']) !!}
                <span  id="telefonorespaldoeditError" class="text-danger"></span>
            </div>
        </div>


        <!-- Direccion y telefono-->
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('Dirección') !!}
                {!! Form::textarea('direccionedit', null, [ 'id'=>'direccionedit', 'class' => 'form-control form-control-sm', 'rows' => 3,'placeholder'=>'Dirección']) !!}
                <span  id="direccioneditError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-12">
                {!! Form::label('Referencia*') !!}
                {!! Form::textarea('referenciaedit', null, [ 'id'=>'referenciaedit', 'class' => 'form-control form-control-sm', 'rows' => 3,'placeholder'=>'Referencia']) !!}
                <span  id="referenciaeditError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">
            
            <div class="form-group col-md-12">
                {!! Form::label('Estatus*') !!}
                {{ Form::select('estatusedit',['Activo' => 'Activo', 'Inactivo' => 'Inactivo', 'Cancelado' => 'Cancelado' ],null,['id' => 'estatusedit','class'=>'form-control form-control-sm', 'placeholder'=>'estatus'])}}
                <span  id="estatuseditError" class="text-danger"></span>
            </div>
        </div>
        
</form>
