@extends("layouts.headerindex")
@section('contenido')

<style>
    .width-column {
        width: 5rem;
    }
</style>

    <div class="container mt-4" >
        <nav class="nav bg-blue-dark mb-3" >
            <button class="btn btn-sm btn-verde m-2" onclick="return window.history.back();"><span class="fas fa-arrow-circle-left"></span> Atras</button>
            <ul class="navbar-nav justify-content-center">
                <h5 class="nav-item">
                    <span>Editar Nota Concentrador</span>
                </h5>
            </ul>
        </nav>

         {{-- DATA NOTE --}}
         <div class="card">
            <div class="card-header">
                <h5>Datos Generales</h5>
            </div>

            <div class="card-body">
                <h5 class="mt-3">Datos Nota</h5>
                <hr>
                <div class="row justify-content-center">
                    <div class="col">
                        <label for="">#ID Nota</label>
                        <input id="note_id" type="text" value="{{$note->id}}" class="form-control" disabled>
                    </div>
                    <div class="col">
                        <label for="">Creador:</label>
                        <input type="text" value="{{$user->name}}" class="form-control" disabled>
                    </div>
                </div>
            </div>

            
            <div class="card-body">
                <h5 class="mt-3">Datos Cliente</h5>
                <hr>
                <div class="row">
                    <div class="col">
                        <label for="">Num. Cliente</label>
                        <input type="text" value="{{$note->num_client}}" class="form-control form-control-sm" disabled>
                    </div>
                    <div class="col">
                        <label for="">Nombre</label>
                        <input type="text" value="{{$note->name}}" class="form-control form-control-sm" disabled>
                    </div>
                    <div class="col">
                        <label for="">Teléfono</label>
                        <input type="text" value="{{$note->phone_number}}" class="form-control form-control-sm" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">RFC</label>
                        <input type="text" value="{{$note->rfc}}" class="form-control form-control-sm" disabled>
                    </div>
                    <div class="col">
                        <label for="">CFDI</label>
                        <input type="text" value="{{$note->cfdi}}" class="form-control form-control-sm" disabled>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Dirección</label>
                        <textarea name="" id="" cols="30" rows="2" class="form-control form-control-sm" disabled>{{$note->address}}</textarea>
                    </div>
                    <div class="col">
                        <label for="">Dirección Factura</label>
                        <textarea name="" id="" cols="30" rows="2" class="form-control form-control-sm" disabled>{{$note->address_facture}}</textarea>
                    </div>
                </div>
            </div>

            

            <div class="card-body">
                <h5 >Datos Concentrador</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr style="font-size: 13px">
                                <th scope="col">ID</th>
                                <th scope="col">#SERIE</th>
                                <th scope="col">MARCA</th>
                                <th scope="col">CAPACIDAD</th>
                                <th scope="col">ESTATUS</th>
                                <th scope="col">DESCRIPCION</th>
                            </tr>
                        </thead>
                        
                        <tbody id="tbody-concentrators" style="font-size: 13px">
                            <tr>
                                <td>{{$concentrator->id}}</td> <input type="hidden" value="{{$concentrator->id}}" id="concentrator_id">
                                <td>{{$concentrator->serial_number}}</td>
                                <td>{{$concentrator->brand}}</td>
                                <td>{{$concentrator->capacity}}</td>
                                <td>{{$concentrator->status}}</td>
                                <td>{{$concentrator->description}}</td>
                            </tr>
                        </tbody>

                    </table>
                </div> 
                <hr>

            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header ">
                <div class="row">
                    <div class="col">
                        <h5>Rentas y Pagos</h5>
                    </div>
                    <div class="col text-right">
                        
                        <button type="button" class="btn  btn-sm btn-amarillo" id="new-rent" >
                            <span class="fas fa-plus"></span>
                            Agregar
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">   
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered m-0">
                        <thead>
                            <tr style="font-size: 13px">
                                <th rowspan="2" scope="col">ID</th>

                                <th colspan="6" class="text-center">Tiempo</th>
                                <th colspan="2" rowspan="1" scope="col" class="text-center">Fecha</th>
                                <th rowspan="2" scope="col">Horas Salida.</th>
                                <th rowspan="2" scope="col">Dep. Gar.</th>
                                <th rowspan="2" scope="col">Total</th>
                                <th rowspan="2" scope="col">Metodo Pago</th>
                                <th rowspan="2" scope="col">Estatus</th>
                                <th rowspan="2" scope="col">Usuarios</th>
                                <th rowspan="2">Acciones</th >
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
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{$payment->id}}</td>
                                    <td>{{$payment->day}}</td>
                                    <td>$ {{$payment->price_day}}</td>
                                    <td>{{$payment->week}}</td>
                                    <td>$ {{$payment->price_week}}</td>
                                    <td>{{$payment->mount}}</td>
                                    <td>$ {{$payment->price_mount}}</td>
                                    <td>{{$payment->date_start}}</td>
                                    <td>{{$payment->date_end}}</td>
                                    <td>{{$payment->work_hours_output}}</td>
                                    <td>$ {{$payment->deposit_garanty}}</td>
                                    <td>$ {{$payment->total}}</td>
                                    <td>{{$payment->payment_method}}</td>
                                    <td>
                                        {{$payment->status}}
                                    </td>
                                    <td>{{$payment->user_id}}</td>
                                    <td>
                                        @if ($payment->work_hours_output != null)
                                        <a class="btn btn-sm btn-verde text-white" href="{{route('payment.pdf', ['note_id' => $note->id, 'payment_id' => $payment->id])}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Ver PDF"><i class="fas fa-file-pdf"></i></a>
                                        @else
                                            <button class="btn btn-sm btn-verde btn_paymen_edit disabled_element" data-id="{{$payment->id}}" data-toggle="tooltip" data-placement="top" title="Editar Pago"><i class="fas fa-money-check-alt"></i></button>
                                            <a class="btn btn-sm btn-verde text-white" href="{{route('payment.pdf', ['note_id' => $note->id, 'payment_id' => $payment->id])}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Ver PDF"><i class="fas fa-file-pdf"></i></a>
                                            <button class="btn btn-sm btn-verde btn_destroy_paymen disabled_element" data-id="{{$payment->id}}" data-toggle="tooltip" data-placement="top" title="Eliminar"><span class="fas fa-trash"></span></button>
                                        @endif
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>                            
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <div class="card-title"><h5>Registrar Entrada</h5></div>
                    </div>
                    <div class="col text-right">
                        @if ($note->return_concentrator != null)
                            
                        @else
                            <button type="button" class="btn  btn-sm btn-amarillo disabled_element" data-toggle="modal" data-target="#modal_return_concentrator">
                                <span class="fas fa-plus"></span>
                                Agregar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p>Aquí puedes registrar el retorno del concentrado a almacén:</p>
                <table class="table table-sm table-hover table-bordered m-0">
                    <thead>
                        <tr>
                            <th>#SERIE CONCENTRADOR</th>
                            <th>FECHA ENTRADA</th>
                            <th>HORAS CONSUMO</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_return_concentrator">
                        <tr>
                            <td>{{$concentrator->serial_number}}</td>
                            <td>{{$note->return_concentrator}}</td>
                            <td>{{$note->hours_works_consumed}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <div class="card-title"><h5>Estatus Nota</h5></div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p>Selecciona nota cerrada si todos los pagos estas en estatus pagado y el concentrador ha sido entregado:</p>
                <form id="form-close-note">
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col">
                            <select name="close_note" id="close_note" class="form-control form-control-sm">
                                <option value="{{$note->status}}" selected>{{$note->status}}</option>
                                <option value="CERRADA" >CERRADA</option>
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-amarillo" type="button" id="btn_close_note">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- OBSERVACIONES --}}
        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="">Observaciones Generales</label>
                        <textarea name="observaciones" id="observaciones" cols="30" rows="1" class="form-control">{{$note->observations}}</textarea>
                    </div>
                </div>
            </div>
        </div>


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
                    <form id="form-payment">
                        @csrf
                        @include('concentrator.note.edit.payments.create')
                    </form>
                    {{--  --}}
                    
                </div>
                <div class="modal-footer">
                {{-- <button type="button" class="btn btn-verde" data-dismiss="modal">Cancelar</button> --}}
                <button id="insert-rent" type="button" class="btn btn-verde">Guardar</button>
                </div>
            </div>
            </div>
        </div>

        {{-- Modal Pay Rent --}}
        <div class="modal fade" id="modal_pay_rent" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" >Pago Renta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        @include('concentrator.note.edit.payments.edit_pay')
                    </div>
                    <div class="modal-footer">
                    <button id="btn-pay-save" type="button" class="btn btn-verde">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- Modal return Concentrator --}}
        <div class="modal fade" id="modal_return_concentrator" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        @include('concentrator.note.edit.return_concentrator')
                        
                    </div>
                    <div class="modal-footer">
                    <button id="btn-save-return" type="button" class="btn btn-verde">Guardar</button>
                    </div>
                </div>
            </div>
        </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/concentrator/note_edit.js') }}"></script>
<script src="{{ asset('js/clientes_sc/edit_save.js') }}"></script>


<!--Fin Scripts-->
