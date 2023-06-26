@extends("layouts.headerindex")
@section('contenido')

<nav class="nav bg-blue-dark" >
    <button class="btn btn-sm btn-verde m-2" onclick="return window.history.back();"><span class="fas fa-arrow-circle-left"></span> Atras</button>
    <ul class="navbar-nav justify-content-center">
        <h5 class="nav-item">
            <span>Nuevo Contrato</span>
        </h5>
    </ul>
</nav>


<div class="container">
    

    <form id="idFormContrato" style="font-size: 13px">
        @csrf
        <div class="card mt-2">
            <div class="card-header">
                Datos Generales
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col">
                        <label for="">Tipo Contrato</label>
                        <select name="agreement_type" id="agreement_type" class="form-control form-control-sm">
                            <option value="">Selecciona</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Medicinal">Medicinal</option>
                            <option value="Eventual">Eventual</option>
                        </select>
                        <span  id="tipo_contratoError" class="text-danger"></span>
                    </div>
                    <div class="col">
                        <label for="">Nombre Comercial</label>
                        <input name="nombre_comercial" id="nombre_comercial" type="text" class="form-control form-control-sm" >
                        <span  id="nombre_comercialError" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="">Dirección</label>
                        <textarea name="address" id="address" class="form-control form-control-sm" cols="30" rows="2"></textarea>
                        <span  id="addressError" class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="">Referencia</label>
                        <textarea name="reference" id="reference" class="form-control form-control-sm" cols="30" rows="2"></textarea>
                        <span  id="referenceError" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row">Entre calles:</div>
                <div class="form-row">
                    <div class="col">
                        <textarea name="street1" id="street1" class="form-control form-control-sm" cols="30" rows="1"  placeholder="CALLE 1"></textarea>
                        <span  id="street1Error" class="text-danger"></span>
                    </div>
                    <div class="col">
                        <textarea name="street2" id="street2" class="form-control form-control-sm" cols="30" rows="1" placeholder="CALLE 2"></textarea>
                        <span  id="street2Error" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for=""> Precio Transporte</label>
                        <input type="number" id="transport_price" name="transport_price" class="form-control form-control-sm numero-decimal-positivo" placeholder="$0.0">
                        <span  id="transport_priceError" class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="">URL Ubicación</label>
                        <textarea name="url_location" id="url_location" class="form-control form-control-sm" cols="30" rows="1" placeholder="www.exmaple_ubicacion.com"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        Generar Asignaciones de Cilindros
                    </div>
                    <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-amarillo" data-toggle="modal" data-target="#modal_assignments">
                            Agregar
                          </button>
                    </div>
                </div> 
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm" style="font-size: 12px">
                    <thead>
                        <tr>
                            <td>DELETE</td>
                            <th>CILINDROS</th>
                            <th>GAS</th>
                            <th>TIPO</th>
                            <th>MATERIAL</th>
                            <th>CAPACIDAD</th>
                            <th>U.M.</th>
                            <th>PRECIO</th>
                            <th>DEP UNITARIO</th>
                            <th>DEP GARANTIA</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="line_assignment">
                    </tbody>
                </table>
            </div>
        </div>
            
            
    
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_assignments" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_assignmentsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_assignmentsLabel">Nueva Asignación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @include("agreement.assignment.create")
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="insert_assignment">Insertar</button>
        </div>
        </div>
  </div>
</div>

@endsection


@include('layouts.scripts_basics')

