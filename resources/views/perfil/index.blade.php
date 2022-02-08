@extends('layouts.sidebar')

@section('content-sidebar')

    <div class="container" >
        <div class="card">
            <div class="card-header">
                <h5>Mis Datos</h5>
            </div>
            <div class="card-body">
                <center>
                    <div id="msg-mis-datos" style="display:none" class="alert" role="alert">
                    </div>
                </center>
                <div class="row">
                    <div class="col">
                        <label for="">Nombre:</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Nombre" value="{{auth()->user()->name}}">
                        <span  id="name_userError" class="text-danger"></span>
                    </div>
                    <div class="col">
                        <label for="">Rol Usuario:</label>
                        <input type="text" class="form-control" placeholder="Rol" disabled value="{{$rol->name}}">
                    </div>
                    <div class="col">
                        <label for="">Descripción:</label>
                        <input type="text" class="form-control" placeholder="Descripción de Rol" disabled value="{{$rol->description}}">
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col text-right">
                        <!-- Button password modal -->
                        <button type="button" class="btn btn-verde" id="guardar-datos">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Datos Cuenta</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-10">
                        {!! Form::label('Correo Electronico') !!}
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset disabled>
                                    {!! Form::email('email', $user->email, ['id'=>'email', 'class' => 'form-control']) !!}
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <!-- Button email modal -->
                                <button type="button" class="btn btn-verde" data-toggle="modal" data-target="#emailmodal">
                                    Cambiar
                                </button>
                            </div>
                        </div>
                    </div>
            
                    <div class="form-group col-md-10">
                        {!! Form::label('Contraseña') !!}
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset disabled>
                                    {!! Form::password('password', ['id'=>'password', 'class' => 'form-control', 'placeholder'=>'*************']) !!}
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <!-- Button password modal -->
                                    <button type="button" class="btn btn-verde" data-toggle="modal" data-target="#passwordmodal">
                                        Cambiar
                                    </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- -->
        
    </div>

        <!-- Modal email-->
        <div class="modal fade bd-example-modal-md" id="emailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-onix">
                <h4 class="modal-title" id="modaleliminarTitle">Cambiar Correo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                    <span aria-hidden="true" class="fas fa-times"></span>
                </button>
                </div>
                <div class="modal-body">
                    <p style="text-align: center"> <strong>Nota: </strong> Al cambiar el correo electrónico tendrá que confirmarlo.
                        </p>
                        <hr>
                {{-- contenido--}}
                    @include('perfil.cambio_email')
                <!-- botones Aceptar y cancelar-->
                <div class="row justify-content-center" >
                    <div class="btn-group col-md-2" style="margin:10px" >
                    <button type="submit" class="btn btn-amarillo" id="btnnewemail">Aceptar</button>
                    </div>
                    <div class="btn-group col-md-2" style="margin:10px">
                    <button type="reset" class="btn btn-verde" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                </div>
                
            </div>
            </div>
        </div>
    
    
        <!-- Modal Password-->
        <div class="modal fade bd-example-modal-md" id="passwordmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-onix">
                <h4 class="modal-title" id="modaleliminarTitle">Cambiar Contraseña</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff">
                    <span aria-hidden="true" class="fas fa-times"></span>
                </button>
                </div>
                <div class="modal-body">
                {{-- contenido--}}
                @include('perfil.cambio_password')       
                <!-- botones Aceptar y cancelar-->
                <div class="row justify-content-center" >
                    <div class="btn-group col-md-2" style="margin:10px" >
                    <button type="submit" class="btn btn-amarillo" id="btnnewpassword">Aceptar</button>
                    </div>
                    <div class="btn-group col-md-2" style="margin:10px">
                    <button type="reset" class="btn btn-verde" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                </div>
                
            </div>
            </div>
        </div>

@endsection
@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/perfil/index.js') }}"></script>
<!--Fin Scripts-->

