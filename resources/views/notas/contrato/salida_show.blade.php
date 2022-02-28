@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')
    <div class="container">
        <div class="card">
            <div class="card-header">
                NOTA SALIDA
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-4 mr-0">
                <div class="card" style="height: 25rem">
                    <div class="card-body">
                        <span><i class="far fa-clipboard fa-1x"></i> INFORMACIÓN</span>
                        <table class="table table-sm mt-3" style="font-size: 13px">
                            <tbody>
                                <tr>
                                    <td class="pl-3 p-0">Nota id: </td>
                                    <td class="pl-3 p-0">{{$nota->id}}</td>
                                </tr>
                                @if ($cliente->empresa != null)
                                <tr>
                                    <td class="pl-3 p-0">Empresa: </td>
                                    <td class="pl-3 p-0">{{$cliente->empresa}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0">Representante: </td>
                                    <td class="pl-3 p-0">{{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</td>
                                </tr>
                                @else
                                <tr>
                                    <td class="pl-3 p-0">Cliente: </td>
                                    <td class="pl-3 p-0">{{$cliente->nombre}} {{$cliente->apPaterno}}  {{$cliente->apMaterno}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="pl-3 p-0">Contrato: </td>
                                    <td class="pl-3 p-0">{{$contrato->id}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0">Tipo: </td>
                                    <td class="pl-3 p-0">{{$contrato->tipo_contrato}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0">1° Telefono: </td>
                                    <td class="pl-3 p-0">{{$cliente->telefono}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0">2° Telefono: </td>
                                    <td class="pl-3 p-0">{{$cliente->telefonorespaldo}}</td>
                                </tr>
                                <tr>
                                </tr>
                            </tbody>

                        </table>
                        <span style="font-size: 13px"><i class="fas fa-truck"></i> ENVIO</span>
                        <table class="table table-sm mt-1" style="font-size: 13px">
                            <tbody>
                                <tr>
                                    <td>Entregar en: <br> {{$contrato->direccion}} </td>
                                </tr>
                                <tr>
                                    <td>Referencia: <br> {{$contrato->referencia}} </td>
                                </tr>
                            </tbody>
                        </table>
                        <span style="font-size: 13px"><i class="fas fa-search"></i> OBSERVACIONES</span>
                        <table class="table table-sm mt-1" style="font-size: 13px">
                            <tbody>
                                <tr>
                                    <td>{{$nota->obaservaciones}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col ml-0">
                <div class="card table-responsive" style="height: 25rem">
                    <div class="card-body">
                        CILINDROS
                        <hr class="mt-0">
                            <table class="table table-bordered  table-sm" style="font-size: 13px">
                                <thead >
                                    <tr >
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">CANTIDAD</th>
                                        <th scope="col">U. M.</th>
                                        <th scope="col">GAS</th>
                                        <th scope="col">TAPA</th>
                                        <th scope="col">PRECIO UNITARIO</th>
                                        <th scope="col">IMPORTE</th>
                                        <th scope="col">IVA</th>
                                    </tr>
                                </thead>
                                <tbody id="tablelistaTanques" >
                                    @foreach ($tanques as $tanq)
                                        <tr>
                                            <td>{{$tanq->num_serie}}</td>
                                            <td>{{$tanq->cantidad}}</td>
                                            <td>{{$tanq->unidad_medida}}</td>
                                            <td>{{$tanq->tipo_gas}}</td>
                                            <td>{{$tanq->tapa_tanque}}</td>
                                            <td>$ {{number_format($tanq->precio_unitario,2)}}</td>
                                            <td>$ {{number_format($tanq->importe,2)}}</td>
                                            <td>$ {{number_format($tanq->iva_particular,2)}}</td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row mt-1">
            <div class="col">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered" style="font-size: 13px">
                            <tbody>
                                <tr>
                                    <td><strong>SUBTOTAL:</strong> $ {{number_format($nota->subtotal, 2, '.', ',')}}</td>
                                    <td><strong>ENVÍO:</strong> $ {{number_format($nota->envio,2)}}</td>
                                    <td><strong>IVA 16%:</strong> $ {{number_format($nota->iva_general,2)}}</td>
                                    <td><strong>TOTAL: </strong> $ {{number_format($nota->total,2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($nota->primer_pago < $nota->total)
                            <table class="table table-bordered mt-2" style="font-size: 13px">
                                <tbody>
                                    <tr>
                                        <td><strong>Abono: </strong> $ {{number_format($nota->primer_pago,2)}}</td>
                                        <td><strong>Adeudo: </strong> $ {{number_format($nota->total - $nota->primer_pago,2)}}</td>
                                    </tr>  
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                @if ($nota->primer_pago < $nota->total)
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th class="text-center">MONTO PAGO</th>
                                            <th class="text-center">METODO DE PAGO</th>
                                            <th class="text-center">FECHA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pagos as $pago)
                                        <tr>
                                            <td class="text-center">{{$pago->monto_pago}}</td>
                                            <td class="text-center">{{$pago->metodo_pago}}</td>
                                            <td class="text-center">{{$pago->created_at}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@include('layouts.scripts')

<script>
    $(document).ready(function () {
        $("#id-menu-contrato").addClass('active');
    });
</script>
<!--Fin Scripts-->
