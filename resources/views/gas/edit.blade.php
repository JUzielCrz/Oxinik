        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col">
                {!! Form::label('Nombre*') !!}
                {!! Form::text('nombreedit', null, ['id'=>'nombreedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="nombreeditError" class="text-danger"></span>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col">
                {!! Form::label('Abreviatura*') !!}
                {!! Form::text('abreviaturaedit', null, ['id'=>'abreviaturaedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'...', 'required' ]) !!}
                <span  id="abreviaturaeditError" class="text-danger"></span>
            </div>
        </div>

        <input type="hidden" name="idedit" id="idedit"> 
