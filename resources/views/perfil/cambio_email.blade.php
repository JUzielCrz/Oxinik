
<center>
    <div id="divmsgedit" style="display:none" class="alert" role="alert">
    </div>
</center>

{{-- {!! Form::hidden('user_idedit', null, ['id'=>'user_idedit']) !!} --}}

<div class="form-row">
    <div class="form-group col-md-12">
        {!! Form::label('Correo') !!}
        {!! Form::text('emailedit', $user->email, ['id'=>'emailedit', 'class' => 'form-control', 'placeholder'=>'Nuevo Email']) !!}
        <span  id="emaileditError" class="text-danger"></span>
    </div>

    <div class="form-group col-md-12">

        {!! Form::label('Ingresa tu contraseña') !!}
        {{-- {!! Form::password('passwordedit', ['id'=>'passwordedit', 'class' => 'form-control', 'placeholder'=>'Contraseña' ]) !!} --}}
        
            <div class="input-group mb-3">
                <input type="password" id="passwordedit" name="passwordedit" class="form-control showpassword" placeholder="Contraseña">
                <div class="input-group-append">
                    <button class="btn btn-amarillo mostrarpassword" type="button"><span class="fas fa-eye-slash icon"></span></button>
                </div>
            </div>
            <span  id="passwordeditError" class="text-danger"></span>
    </div>
    
</div>