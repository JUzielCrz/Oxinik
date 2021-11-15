<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>
  
  
    <form id="idformRole">
      @csrf
  
      <!-- nombre-->
      <div class="form-row">
        <div class="form-group col">
          {!! Form::label('Nombre') !!}
          {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control form-control-sm', 'placeholder'=>'Nombre']) !!}
          <span  id="nameError" class="text-danger"></span>
        </div>
  
        <div class="form-group col">
          {!! Form::label('Slug') !!}
          {!! Form::text('slug', null, ['id'=>'slug', 'class' => 'form-control form-control-sm', 'placeholder'=>'slug']) !!}
          <span  id="slugError" class="text-danger"></span>
        </div>
  
      </div>
  
      <div class="form-row">
        <div class="form-group col-md-6">
          {!! Form::label('Descripción') !!}
          {!! Form::textarea('description', null, ['id'=>'description', 'class' => 'form-control form-control-sm', 'rows' => 2,'placeholder'=>'Descripción']) !!}
          <span  id="descriptionError" class="text-danger"></span>
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
                <td>{!! Form::checkbox('permission[]', $permission->id, null)!!} </td>
                <td><span class="font-weight-bold">{{$permission->name}}: </span></td>
                <td>{{$permission->description}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{-- {!! dd(old())!!} --}}
  
    </form>
  
  
  