
<form id="form_driver" method="POST">
    @csrf
        <input type="hidden" name="id" id="id" >
        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-12">
                {!! Form::label('Nombre*') !!}
                {!! Form::text('nombre', null, ['id'=>'nombre', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="nombreError" class="text-danger"></span>
            </div>
            <div class="form-group col-12">
                {!! Form::label('Apellidos*') !!}
                {!! Form::text('apellido', null, ['id'=>'apellido', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="apellidoError" class="text-danger"></span>
            </div>
            <div class="form-group col-12">
                {!! Form::label('Tipo Licencia*') !!}
                {!! Form::text('licencia_tipo', null, ['id'=>'licencia_tipo', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="licencia_tipoError" class="text-danger"></span>
            </div>
            <div class="form-group col-12">
                {!! Form::label('Número Licencia*') !!}
                {!! Form::text('licencia_numero', null, ['id'=>'licencia_numero', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="licencia_numeroError" class ="text-danger"></span>
            </div>

        </div>


</form>
