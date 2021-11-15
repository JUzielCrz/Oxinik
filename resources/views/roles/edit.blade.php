<center>
    <div id="divmsgedit" style="display:none" class="alert" role="alert">
    </div>
</center>

    <form id="editformRole">
    @csrf
        
    {!! Form::hidden('idedit', null, ['id'=>'idedit']) !!}

    <!-- nombre-->
    <div class="form-row">
        <div class="form-group col">
        {!! Form::label('Nombre') !!}
        {!! Form::text('nameedit', null, ['id'=>'nameedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'Nombre']) !!}
        <span  id="nameeditError" class="text-danger"></span>
        </div>

        <div class="form-group col">
        {!! Form::label('Slug') !!}
        {!! Form::text('slugedit', null, ['id'=>'slugedit', 'class' => 'form-control form-control-sm', 'placeholder'=>'slug']) !!}
        <span  id="slugeditError" class="text-danger"></span>
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
        {!! Form::label('Descripción') !!}
        {!! Form::textarea('descriptionedit', null, ['id'=>'descriptionedit', 'class' => 'form-control form-control-sm', 'rows' => 2,'placeholder'=>'Descripción']) !!}
        <span  id="descriptioneditError" class="text-danger"></span>
        </div>
    </div>


    <hr>

    <h3>Permisos</h3>

    <div class="table-responsive">
        <table class="table table-sm" style="font-size: 13px">
            <thead>
                <tr>
                <th></th>
                <th>PERMISO</th>
                <th>DESCRIPCIÓN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>{!! Form::checkbox('permissionedit[]', $permission->id, false, ['id' => 'permissionedit[]'])!!}  </td>
                    <td><span class="font-weight-bold">{{$permission->name}}: </span></td>
                    <td>{{$permission->description}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- {!! dd(old())!!} --}}

    </form>


