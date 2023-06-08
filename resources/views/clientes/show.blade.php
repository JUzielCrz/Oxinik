@extends('layouts.sidebar')

@section('menu-navbar') 
@endsection

@section('content-sidebar')

    <div class="card">
        <div class="card-header">Datos Cliente</div>
        <div class="card-body">
            <div class="form-row">
                <div class="col">
                    <label for="">Nombre</label>
                    <input type="text" value='{{$client->nombre." ".$client->apPaterno." ".$client->apMaterno}}' class='form-control form-control-sm' disabled>
                </div>
                <div class="col">
                    <label for="">Empresa</label>
                    <input type="text" value='{{$client->empresa}}' class='form-control form-control-sm' disabled>
                </div>
                <div class="col">
                    <label for="">RFC</label>
                    <input type="text" value='{{$client->rfc}}' class='form-control form-control-sm' disabled>
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="col">
                    <label for="">Correo</label>
                    <input type="text" value='{{$client->email}}' class='form-control form-control-sm' disabled>
                </div>
                <div class="col">
                    <label for="">Telefono</label>
                    <input type="text" value='{{$client->telefono}}' class='form-control form-control-sm' disabled>
                </div>
                <div class="col">
                    <label for="">Telefono 2</label>
                    <input type="text" value='{{$client->telefonorespaldo}}' class='form-control form-control-sm' disabled>
                </div>
                <div class="col">
                    <label for="">Estatus</label>
                    <input type="text" value='{{$client->estatus}}' class='form-control form-control-sm' disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    Contratos
                </div>
                <div class="col text-right">
                    <a href="/agreement/{{$client->id}}" class="btn btn-sm btn-success">Nuevo Contrato</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col text-right">
                    <button type="button" class="btn btn-sm btn-primary">Editar</button>
                    <button type="button" class="btn btn-sm btn-primary">Ver PDF</button>
                    <button type="button" class="btn btn-sm btn-primary">Ver Asignaciones</button>
                    <button type="button" class="btn btn-sm btn-primary">Ver Notas</button>
                    <button type="button" class="btn btn-sm btn-primary">Eliminar</button>
                </div>
            </div>
            <hr>
            <div class="row table-responsive"> 
                <table class="table table-sm table-hover" >
                    <thead style="background: #fff; color: black">
                        <tr>
                            <th  class="text-center">Selecciona</th>
                            <th class="text-center">#Contrato</th>
                            <th class="text-center">Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agreements as $agreement)
                            <tr>
                                <td class="text-center"> <div class="form-check"><input class="form-check-input" type="radio" name="agreement_id" id="agreement_id" value="{{$agreement->id}}" checked></div> </td>
                                <td class="text-center">{{$agreement->id}}</td>
                                <td class="text-center">{{$agreement->tipo_contrato}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
            <div></div>
            
        </div>
    </div>
@endsection
@include('layouts.scripts')

<script src="{{ asset('js/agreement/index.js') }}"></script>