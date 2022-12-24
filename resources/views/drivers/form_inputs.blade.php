
<form id="form_driver" method="POST">
    @csrf
        <input type="hidden" name="id" id="id" >
        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col">
                {!! Form::label('Nombre*') !!}
                {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="nameError" class="text-danger"></span>
            </div>
            <div class="form-group col">
                {!! Form::label('Apellidos*') !!}
                {!! Form::text('last_name', null, ['id'=>'last_name', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="last_nameError" class="text-danger"></span>
            </div>

        </div>


</form>
