@extends("layouts.headerindex")
@section('contenido')

<style>
    .width-column {
        width: 5rem;
    }
</style>

    <div class="container-fluid mt-4" >
        <nav class="nav bg-blue-dark mb-3" >
            <button class="btn btn-sm btn-verde m-2" onclick="return window.history.back();"><span class="fas fa-arrow-circle-left"></span> Atras</button>
            <ul class="navbar-nav justify-content-center">
                <h5 class="nav-item">
                    <span>Nueva Nota Concentrador</span>
                </h5>
            </ul>
        </nav>
    <form id="form-note">
        @csrf
        <div class="row">
            <div class="col-md-8">
                
                {{-- Entrada --}}
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col">
                                <label for=""># Serie</label>
                                {!! Form::text('serial_concentrator', null, ['id'=>'serial_concentrator', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}
                            </div>
                            <div class="col align-self-end">
                                <button type="button" class="btn btn-verde" id="btn-insert"> <span class="fas fa-plus"></span>Añadir</button>
                            </div>
                        </div>
                        <span  id="serial_concentratorError" class="text-danger"></span>

                        <hr>
                        <span><strong>CONCENTRADOR:</strong></span>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">MARCA</th>
                                        <th scope="col">CAPACIDAD</th>
                                        <th scope="col">HORAS TRABAJO</th>
                                        <th scope="col">DESCRIPCION</th>
                                        
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                
                                <tbody id="tbody-concentrators" style="font-size: 13px">
                                    
                                </tbody>
            
                            </table>
                        </div>
                        <center>
                            <div id="msg-concentrators-entrada" style="display:none" class="alert" role="alert">
                            </div>
                        </center>

                        <hr>

                        <div class="card-header mx-md-3">
                            <div class="row">
                                <div class="col">
                                    <h5>Renta</h5>
                                </div>
                                <div class="col text-right">
                                    <button type="button" class="btn  btn-sm btn-amarillo" id="new-rent">
                                        <span class="fas fa-plus"></span>
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 mx-md-3">                               
                            <div class="table-responsive">
                                <table class="table table-sm table-hover table-bordered m-0">
                                    <thead>
                                        <tr style="font-size: 13px">
                                            <th colspan="6" class="text-center">Tiempo</th>
                                            <th colspan="2" rowspan="1" scope="col" class="text-center">Fecha</th>
                                            <th rowspan="2" scope="col">Dep. Gar.</th>
                                            <th rowspan="2" scope="col">Total</th>
                                            <th rowspan="2"></th >
                                        </tr>
                                        <tr style="font-size: 13px">
                                            <th colspan="2" scope="col">Días</th>
                                            <th colspan="2" scope="col">Semanas</th>
                                            <th colspan="2" scope="col">Meses</th>
                                            <th scope="col">Inicio</th>
                                            <th scope="col">Termino</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-rents" style="font-size: 13px">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- OBSERVACIONES --}}
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Observaciones Generales</label>
                                <textarea name="observaciones" id="observaciones" cols="30" rows="1" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">          
                @include('clientes_sc.search')
                @include('clientes_sc.show')

                <div class="card mt-2">
                    <div class="card-body">


                        <div class="row justify-content-center">
                            <a href="{{route("concentrator.notes")}}" class="btn btn-verde" id="btnCancelar">Cancelar</a>
                            <button type="button" class="btn btn-verde ml-2" id="save-note">Aceptar</button>
                            {{-- <button type="button" class="btn btn-amarillo" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Modal Pay --}}
        <div class="modal fade" id="modal-pay" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Resumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body bg-soft-gray">
                    {{-- Formulario --}}
                    @include('concentrator.note.modal_pay')                
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-verde" data-dismiss="modal">Cancelar</button>
                <button id="btn-store" type="button" class="btn btn-verde">Guardar</button>
                </div>
            </div>
            </div>
        </div>

    </form>

    {{-- Modal new rent --}}
    <div class="modal fade" id="modal-rent" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Agregar Renta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body bg-soft-gray">
                {{-- Formulario --}}
                @include('concentrator.note.payments.create')
                {{--  --}}
                
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-verde" data-dismiss="modal">Cancelar</button> --}}
            <button id="insert-rent" type="button" class="btn btn-verde">Guardar</button>
            </div>
        </div>
        </div>
    </div>



@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/concentrator/note.js') }}"></script>
<script src="{{ asset('js/clientes_sc/edit_save.js') }}"></script>


<!--Fin Scripts-->
