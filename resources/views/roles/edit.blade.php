<center>
    <div id="divmsgedit" style="display:none" class="alert" role="alert">
    </div>
</center>

    <form id="editformRole">
    @csrf
        
    {!! Form::hidden('idedit', null, ['id'=>'idedit']) !!}

    <!-- nombre-->
    <div class="form-row">
        <div class="form-group col-md-6">
        {!! Form::label('Nombre') !!}
        {!! Form::text('nameedit', null, ['id'=>'nameedit', 'class' => 'form-control', 'placeholder'=>'Nombre']) !!}
        <span  id="nameeditError" class="text-danger"></span>
        </div>

        <div class="form-group col-md-6">
        {!! Form::label('Slug') !!}
        {!! Form::text('slugedit', null, ['id'=>'slugedit', 'class' => 'form-control', 'placeholder'=>'slug']) !!}
        <span  id="slugeditError" class="text-danger"></span>
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
        {!! Form::label('Descripción') !!}
        {!! Form::textarea('descriptionedit', null, ['id'=>'descriptionedit', 'class' => 'form-control', 'rows' => 2,'placeholder'=>'Descripción']) !!}
        <span  id="descriptioneditError" class="text-danger"></span>
        </div>
    </div>


    <hr>

    <h3>Permisos</h3>

    @foreach ($permissions as $permission)
    <div class="ml-3">
        {!! Form::checkbox('permissionedit[]', $permission->id, false, ['id' => 'permissionedit[]'])!!} 
        <span class="font-weight-bold">{{$permission->name}}: </span>
        {{$permission->description}}
        <br>
        </div>
    @endforeach

    {{-- {!! dd(old())!!} --}}

    </form>


