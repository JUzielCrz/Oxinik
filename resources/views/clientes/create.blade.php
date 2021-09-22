<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>

  <form id="idFormCliente">
    @csrf

        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('Apellido Paterno*') !!}
                {!! Form::text('apPaterno', null, ['id'=>'apPaterno', 'class' => 'form-control form-control-sm solo-text', 'placeholder'=>'Apellido Paterno', 'required' ]) !!}
            <span  id="apPaternoError" class="text-danger"></span>
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('Apellido Materno*') !!}
            {!! Form::text('apMaterno', null, ['id'=>'apMaterno', 'class' => 'form-control form-control-sm solo-text', 'placeholder'=>'Apellido Materno']) !!}
            <span  id="apMaternoError" class="text-danger"></span>
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('Nombre(s)*') !!}
            {!! Form::text('nombre', null, ['id'=>'nombre', 'class' => 'form-control form-control-sm solo-text', 'placeholder'=>'Nombre']) !!}
            <span  id="nombreError" class="text-danger"></span>
        </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('RFC*') !!}
                {!! Form::text('rfc', null, ['id'=>'rfc', 'class' => 'form-control form-control-sm', 'placeholder'=>'RFC']) !!}
                <span  id="rfcError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('Correo Electronico*') !!}
                {!! Form::email('email', null, ['id'=>'email', 'class' => 'form-control form-control-sm', 'placeholder'=>'Correo Electronico']) !!}
                <span  id="emailError" class="text-danger"></span>
            </div>
            
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('1° Teléfono*') !!}
                {!! Form::number('telefono', null, [ 'id'=>'telefono', 'class' => 'form-control form-control-sm telefono solo-numero', 'placeholder'=>'1° Teléfono']) !!}
                <span  id="telefonoError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('2° Teléfono*') !!}
                {!! Form::number('telefonorespaldo', null, [ 'id'=>'telefonorespaldo', 'class' => 'form-control form-control-sm telefono solo-numero', 'placeholder'=>'2° Teléfono']) !!}
                <span  id="telefonorespaldoError" class="text-danger"></span>
            </div>
        </div>

        <!-- Direccion y telefono-->
        <div class="form-row">
            
            <div class="form-group col-md-12">
                {!! Form::label('Dirección*') !!}
                {!! Form::textarea('direccion', null, [ 'id'=>'direccion', 'class' => 'form-control form-control-sm', 'rows' => 3,'placeholder'=>'Dirección']) !!}
                <span  id="direccionError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-12">
                {!! Form::label('Referencia*') !!}
                {!! Form::textarea('referencia', null, [ 'id'=>'referencia', 'class' => 'form-control form-control-sm', 'rows' => 3,'placeholder'=>'Referencia']) !!}
                <span  id="referenciaError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">
            
            <div class="form-group col-md-12">
                {!! Form::label('Estatus*') !!}
                {{ Form::select('estatus',['Activo' => 'Activo', 'Inactivo' => 'Inactivo', 'Cancelado' => 'Cancelado' ],null,['id' => 'estatus','class'=>'form-control form-control-sm', 'placeholder'=>'estatus'])}}
                <span  id="estatusError" class="text-danger"></span>
            </div>
        </div>
    
        
</form>
