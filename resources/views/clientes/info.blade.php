<fieldset disabled>
    
        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('Apellido Paterno*') !!}
                {!! Form::text('apPaternoinfo', null, ['id'=>'apPaternoinfo', 'class' => 'form-control form-control-sm solo-text', 'placeholder'=>'Apellido Paterno', 'required' ]) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('Apellido Materno*') !!}
                {!! Form::text('apMaternoinfo', null, ['id'=>'apMaternoinfo', 'class' => 'form-control form-control-sm solo-text', 'placeholder'=>'Apellido Materno']) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('Nombre*') !!}
                {!! Form::text('nombreinfo', null, ['id'=>'nombreinfo', 'class' => 'form-control form-control-sm solo-text', 'placeholder'=>'Nombre']) !!}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('RFC*') !!}
                {!! Form::text('rfcinfo', null, ['id'=>'rfcinfo', 'class' => 'form-control form-control-sm solo-text', 'placeholder'=>'RFC']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('Correo Electronico*') !!}
                {!! Form::email('emailinfo', null, ['id'=>'emailinfo', 'class' => 'form-control form-control-sm', 'placeholder'=>'Correo Electronico']) !!}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('1° Teléfono*') !!}
                {!! Form::number('telefonoinfo', null, [ 'id'=>'telefonoinfo', 'class' => 'form-control form-control-sm telefono', 'placeholder'=>'1° Teléfono']) !!}
                <span  id="telefonoinfoError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('2° Teléfono*') !!}
                {!! Form::number('telefonorespaldoinfo', null, [ 'id'=>'telefonorespaldoinfo', 'class' => 'form-control form-control-sm telefono', 'placeholder'=>'2° Teléfono']) !!}
            </div>
        </div>


        <!-- Direccion y telefono-->
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('Dirección') !!}
                {!! Form::textarea('direccioninfo', null, [ 'id'=>'direccioninfo', 'class' => 'form-control form-control-sm', 'rows' => 3,'placeholder'=>'Dirección']) !!}
                <span  id="direccioninfoError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-12">
                {!! Form::label('Referencia*') !!}
                {!! Form::textarea('referenciainfo', null, [ 'id'=>'referenciainfo', 'class' => 'form-control form-control-sm', 'rows' => 3,'placeholder'=>'Referencia']) !!}
            </div>
        </div>

        <div class="form-row">
            
            <div class="form-group col-md-12">
                {!! Form::label('Estatus*') !!}
                {{ Form::select('estatusinfo',['Activo' => 'Activo', 'Inactivo' => 'Inactivo', 'Cancelado' => 'Cancelado' ],null,['id' => 'estatusinfo','class'=>'form-control form-control-sm', 'placeholder'=>'estatus'])}}
            </div>
        </div>

</fieldset>