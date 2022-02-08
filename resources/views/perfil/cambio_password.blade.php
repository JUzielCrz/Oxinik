<center>
    <div id="divmsgeditpass" style="display:none" class="alert" role="alert">
    </div>
</center>

{!! Form::hidden('user_idedit', null, ['id'=>'user_idedit']) !!}

<div class="form-row">

    <div class="form-group col-md-12">
        {!! Form::label('Contraseña Actual') !!}
        <div class="input-group mb-3">
            <input type="password" id="passwordoneedit" name="passwordoneedit" class="form-control" placeholder="Contraseña Actual">
            <div class="input-group-append">
                <button class="btn btn-amarillo mostrarpassword1" type="button"><span class="fas fa-eye-slash icon1"></span></button>
            </div>
        </div>
        <span  id="passwordoneeditError" class="text-danger"></span>
    </div>

    <div class="form-group col-md-12">
        {!! Form::label('Nueva contraseña') !!}
        <div class="input-group mb-3">
            <input type="password" id="passwordtwoedit" name="passwordtwoedit" class="form-control" placeholder="Contraseña Nueva">
            <div class="input-group-append">
                <button class="btn btn-amarillo mostrarpassword2" type="button"><span class="fas fa-eye-slash icon2"></span></button>
            </div>
        </div>
        <span  id="passwordtwoeditError" class="text-danger"></span>
    </div>
    <div class="form-group col-md-12">
        {!! Form::label('Confirma Nueva Contraseña') !!}
        <div class="input-group mb-3">
            <input type="password" id="passwordtreeedit" name="passwordtreeedit" class="form-control" placeholder="Confirmar Contraseña">
            <div class="input-group-append">
                <button class="btn btn-amarillo mostrarpassword3" type="button"><span class="fas fa-eye-slash icon3"></span></button>
            </div>
        </div>
        <span  id="passwordtreeError" class="text-danger"></span>
    </div>
    
</div>