<center>
    <div id="divmsgedit" style="display:none" class="alert" role="alert">
    </div>
</center>

<form id="idFormUseredit">
    @csrf
        {!! Form::hidden('idedit', null, ['id'=>'idedit']) !!}
        <!-- Nombre Completo-->
        <div class="form-row justify-content-center">
            <div class="form-group col-md-11">
                {!! Form::label('Nombre') !!}
                {!! Form::text('nameedit', null, ['id'=>'nameedit', 'class' => 'form-control form-control-sm solo-text', 'placeholder'=>'Nombre', 'required']) !!}
                <span  id="nameeditError" class="text-danger"></span>
            </div>
        </div>

        <!-- nacimiento, sexo, email-->
        <div class="form-row justify-content-center">
            <div class="form-group col-md-11">
                {!! Form::label('Correo Electronico') !!}
                {!! Form::email('emailedit', null, ['id'=>'emailedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'Correo Electronico', 'required']) !!}
                <span  id="emaileditError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row justify-content-center">
            <div class="form-group col-md-11">
                {!! Form::label('Rol de Usuario') !!}
                {{ Form::select('roleidedit', $roles , null,['id' => 'roleidedit','class'=>'form-control form-control-sm', 'required'])}}
                <span  id="roleideditError" class="text-danger"></span>
            </div>
        </div>
</form>
