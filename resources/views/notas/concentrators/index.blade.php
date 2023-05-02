@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

<style>
    .width-column {
        width: 5rem;
    }
</style>

    <div class="container-fluid" >
        
    <form id="idFormNewVenta">
        @csrf
        <div class="row">
            <div class="col-md-8">
                {{-- Entrada --}}
                <div class="card">
                    <div class="card-header">
                        <h5>Renta Concentradores</h5>
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-center">
                            
                            <div class="col">
                                {!! Form::label('# Serie') !!}
                                {!! Form::text('serial_concentrator', null, ['id'=>'serial_concentrator', 'class' => 'form-control form-control-sm', 'placeholder'=>'#Serie',  'required' ]) !!}
                            </div>
                            <div class="col align-self-end">
                                <button type="button" class="btn btn-verde" id="btn-insert"> <span class="fas fa-plus"></span>Añadir</button>
                            </div> 
                        </div>
                        <span  id="serial_concentratorError" class="text-danger"></span>

                        <hr>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">MARCA</th>
                                        <th scope="col">CAPACIDAD</th>
                                        <th scope="col">DESCRIPCION</th>
                                        <th scope="col">RENTA</th>
                                        <th scope="col">D. GARANTIA</th>
                                        
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
                            <button type="button" class="btn btn-verde" id="btnCancelar">Cancelar</button>
                            <button type="button" class="btn btn-verde ml-2" id="btn-pagar-nota">Pagar</button>
                            {{-- <button type="button" class="btn btn-amarillo" id="btn-pdf-nota"> Nota de remision</button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>

    
    <!-- Modal Pagar-->
    <div class="modal fade" id="static-modal-pago" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Resumén</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            
                {{-- FOrmulario --}}
                @include('notas.mostrador.modal_pago')
                {{--  --}}
                
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-verde" data-dismiss="modal">Cancelar</button> --}}
            <button id="guardar-nota" type="button" class="btn btn-verde">Guardar</button>
            </div>
        </div>
        </div>
    </div>

@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/concentrators/index.js') }}"></script>
<script src="{{ asset('js/clientes_sc/edit_save.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#id-menu-concentrators").addClass('active');
    });
</script>
<!--Fin Scripts-->