<form id="form-edit-asignacion">
    <center>
        <div id="msg-modal-asignacion" style="display:none" class="alert" role="alert">
        </div>
    </center>

    @csrf
    <div class="form-row">
        <div class="form-group col">
            {!! Form::label('Incidencia*') !!}
            {{ Form::select('incidencia',['AUMENTO' => 'AUMENTO', 
                                            'DISMINUCION' => 'DISMINUCION',
                                            ],null,['id' => 'incidencia','class'=>'form-control', 'placeholder'=>'Selecciona'])}}
            <span  id="incidenciaError" class="text-danger"></span>
        </div>

        <div class="form-group col">
            {!! Form::label('Cantidad de Tanques*') !!}
            {!! Form::number('contidadtanques', null, ['id'=>'contidadtanques', 'class' => 'form-control', 'placeholder'=>'#']) !!}
            <span  id="contidadtanquesError" class="text-danger"></span>
        </div> 
    </div>
</form>