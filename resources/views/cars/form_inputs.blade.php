
<form id="form_car" method="POST">
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
                {!! Form::label('Modelo*') !!}
                {!! Form::text('modelo', null, ['id'=>'modelo', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="modeloError" class="text-danger"></span>
            </div>
            <div class="form-group col-12">
                {!! Form::label('kilometraje*') !!}
                {!! Form::text('kilometraje', null, ['id'=>'kilometraje', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="kilometrajeError" class="text-danger"></span>
            </div>
        </div>


</form>
