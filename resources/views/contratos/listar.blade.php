@extends('layouts.sidebar')
@section('content-sidebar')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h5 id="titulo-tabla">CONTRATOS</h5>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm">
                            @csrf
                            <select name="tipo_contrato" id="tipo_contrato" class="form-control form-control-sm">
                                <option value="ALL">GENERAL</option>
                                <option value="INDUSTRIAL">INDUSTRIAL</option>
                                <option value="MEDICINAL">MEDICINAL</option>
                                <option value="EVENTUAL">EVENTUAL</option>
                            </select>
                            <select name="estatus" id="estatus" class="form-control form-control-sm">
                                <option value="ACTIVO">ACTIVOS</option>
                                <option value="INACTIVO">INACTIVOS</option>
                            </select>
                            <div class="input-group-prepend">
                                <button class="btn btn-amarillo" id="btn-estatus"> Aplicar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="insert-table" class="table-responsive"> 
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/contratos/listar.js') }}"></script>

<!--Fin Scripts-->
