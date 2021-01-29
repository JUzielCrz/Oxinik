<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>
  
  
    <form id="idformRole">
      @csrf
  
      <!-- nombre-->
      <div class="form-row">
        <div class="form-group col-md-6">
          {!! Form::label('Nombre') !!}
          {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control', 'placeholder'=>'Nombre']) !!}
          <span  id="nameError" class="text-danger"></span>
        </div>
  
        <div class="form-group col-md-6">
          {!! Form::label('Slug') !!}
          {!! Form::text('slug', null, ['id'=>'slug', 'class' => 'form-control', 'placeholder'=>'slug']) !!}
          <span  id="slugError" class="text-danger"></span>
        </div>
  
      </div>
  
      <div class="form-row">
        <div class="form-group col-md-12">
          {!! Form::label('Descripción') !!}
          {!! Form::textarea('description', null, ['id'=>'description', 'class' => 'form-control', 'rows' => 2,'placeholder'=>'Descripción']) !!}
          <span  id="descriptionError" class="text-danger"></span>
        </div>
      </div>
  
      <hr>
  
      <h3>Permisos</h3>
  
      @foreach ($permissions as $permission)
      <div class="ml-3">
          {!! Form::checkbox('permission[]', $permission->id, null)!!} 
          <span class="font-weight-bold">{{$permission->name}}: </span>
          {{$permission->description}}
          <br>
        </div>
      @endforeach
  
      {{-- {!! dd(old())!!} --}}
  
    </form>
  
  
  