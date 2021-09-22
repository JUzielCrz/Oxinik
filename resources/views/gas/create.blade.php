
<form id="idFormCliente">
    @csrf

        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col">
                {!! Form::label('Nombre*') !!}
                {!! Form::text('nombre', null, ['id'=>'nombre', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="nombreError" class="text-danger"></span>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col">
                {!! Form::label('Abreviatura*') !!}
                {!! Form::text('abreviatura', null, ['id'=>'abreviatura', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="abreviaturaError" class="text-danger"></span>
            </div>
        </div>

</form>
