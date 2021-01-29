<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
</center>

<form id="idFormUser">
    @csrf

    <!-- nombre-->
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Form::label('Nombre') !!}
            {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control', 'placeholder'=>'Nombre']) !!}
            <span  id="nameError" class="text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Form::label('Email') !!}
            {!! Form::text('email', null, ['id'=>'email', 'class' => 'form-control', 'placeholder'=>'email@example.com']) !!}
            <span  id="emailError" class="text-danger"></span>
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
        {!! Form::label('Rol') !!}
        {{ Form::select('roleid', $roles , null,['id' => 'roleid','class'=>'form-control'])}}
        <span  id="roleidError" class="text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Form::label('Contraseña') !!}
            {{ Form::password('password', ['id' => 'password', 'class'=>'form-control', 'placeholder'=>'Contraseña'])}}
            <span  id="passwordError" class="text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Form::label('Contraseña') !!}
            {{ Form::password('password_confirmation', ['id' => 'password-confirm', 'class'=>'form-control', 'placeholder'=>'Contraseña'])}}
            <span  id="passwordError" class="text-danger"></span>
        </div>
    </div>


</form>