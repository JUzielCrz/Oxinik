
    <fieldset disabled>
        <!-- Nombre Completo-->
        <div class="form-row justify-content-center">
            <div class="form-group col-md-11">
                {!! Form::label('Nombre*') !!}
                {!! Form::text('nameinfo', null, ['id'=>'nameinfo', 'class' => 'form-control solo-text']) !!}
                <span  id="nombreinfoError" class="text-danger"></span>
            </div>
        </div>

        <!-- nacimiento, sexo, email-->
        <div class="form-row justify-content-center">
            <div class="form-group col-md-11">
                {!! Form::label('Correo Electronico*') !!}
                {!! Form::email('emailinfo', null, ['id'=>'emailinfo', 'class' => 'form-control', ]) !!}
                <span  id="emailinfoError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row justify-content-center">
            <div class="form-group col-md-11">
                {!! Form::label('Rol*') !!}
                {{ Form::select('roleidinfo', $roles , null,['id' => 'roleidinfo','class'=>'form-control', ])}}
                <span  id="roleidinfoError" class="text-danger"></span>
            </div>
        </div>
    </fieldset>
