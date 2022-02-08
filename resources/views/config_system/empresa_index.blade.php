@extends('layouts.sidebar')

@section('content-sidebar')

<form id="formData">
    <div class="container" >
        <div class="card">
            <div class="card-header">
                <h5>Datos Empresa</h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="Correo Electrónico" value="{{$empresa->email}}">
                        <span  id="emailError" class="text-danger"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">RFC</label>
                        <input type="text" id="rfc" name="rfc" class="form-control form-control-sm" placeholder="RFC" value="{{$empresa->rfc}}">
                        <span  id="rfcError" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col ">
                        <label for="">Teléfono 1</label>
                        <input type="number" id="telefono1" name="telefono1" class="form-control form-control-sm telefono numero-entero-positivo" placeholder="Teléfono 1" value="{{$empresa->telefono1}}">
                        <span  id="telefono1Error" class="text-danger"></span>
                    </div>
                    <div class="form-group col">
                        <label for="">Teléfono 2</label>
                        <input type="number" id="telefono2" name="telefono2" class="form-control form-control-sm telefono numero-entero-positivo" placeholder="Teléfono 2" value="{{$empresa->telefono2}}">
                        <span  id="telefono2Error" class="text-danger"></span>
                    </div>
                    <div class="form-group col">
                        <label for="">Teléfono 3</label>
                        <input type="number" id="telefono3" name="telefono3" class="form-control form-control-sm telefono numero-entero-positivo" placeholder="Teléfono 3" value="{{$empresa->telefono3}}">
                        <span  id="telefono3Error" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="">Dirección</label>
                        <textarea name="direccion" id="form-group"  cols="30" rows="2" class="form-control form-control-sm" > {{$empresa->direccion}}</textarea>
                        <span  id="direccionError" class="text-danger"></span>
                    </div>
                </div>
                <span class="mt-4"><strong>CUENTAS BANCARIAS</strong></span>
                <hr class="mt-0">
                <div class="row">
                    <div class="form-group col">
                        <label for="">N° Cuenta</label>
                        <input type="number" id="num_cuenta1" name="num_cuenta1" class="form-control form-control-sm" placeholder="N° Cuenta" value="{{$empresa->num_cuenta1}}">
                        <span  id="num_cuenta1Error" class="text-danger"></span>
                    </div>
                    <div class="form-group col">
                        <label for="">Clabe</label>
                        <input type="number" id="clave1" name="clave1" class="form-control form-control-sm" placeholder="Clabe" value="{{$empresa->clave1}}">
                        <span  id="clave1Error" class="text-danger"></span>
                    </div>
                    <div class="form-group col">
                        <label for="">Banco</label>
                        <input type="text" id="banco1" name="banco1" class="form-control form-control-sm" placeholder="Banco" value="{{$empresa->banco1}}">
                        <span  id="banco1Error" class="text-danger"></span>
                    </div>
                    <div class="form-group col">
                        <label for="">Titular</label>
                        <input type="text" id="titular1" name="titular1" class="form-control form-control-sm" placeholder="Titular" value="{{$empresa->titular1}}">
                        <span  id="titular1Error" class="text-danger"></span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col">
                        <label for="">N° Cuenta</label>
                        <input type="number" id="num_cuenta2" name="num_cuenta2" class="form-control form-control-sm" placeholder="N° Cuenta" value="{{$empresa->num_cuenta2}}">
                        <span  id="num_cuenta2Error" class="text-danger"></span>
                    </div>
                    <div class="form-group col">
                        <label for="">Clabe</label>
                        <input type="number" id="clave2" name="clave2" class="form-control form-control-sm" placeholder="Clabe" value="{{$empresa->clave2}}">
                        <span  id="clave2Error" class="text-danger"></span>
                    </div>
                    <div class="form-group col">
                        <label for="">Banco</label>
                        <input type="text" id="banco2" name="banco2" class="form-control form-control-sm" placeholder="Banco" value="{{$empresa->banco2}}">
                        <span  id="banco2Error" class="text-danger"></span>
                    </div>
                    <div class="form-group col">
                        <label for="">Titular</label>
                        <input type="text" id="titular2" name="titular2" class="form-control form-control-sm" placeholder="Titular" value="{{$empresa->titular2}}">
                        <span  id="titular2Error" class="text-danger"></span>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col form-group text-right">
                        <button class="btn btn-verde" id="btn-save"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
    

@endsection
@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/config_sytem/empresa_index.js') }}"></script>
<!--Fin Scripts-->

