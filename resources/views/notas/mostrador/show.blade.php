@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        NOTA SALIDA
                    </div>
                    <div class="col text-right" style="font-size: 13px">
                        Fecha: {{$nota->fecha}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-4 mr-0">
                <div class="card" style="height: 25rem">
                    <div class="card-body table-responsive">
                        <span><i class="far fa-clipboard fa-1x" ></i> INFORMACIÓN</span>
                        <table class="table table-sm mt-3" style="font-size: 13px">
                            <tbody>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>Nota id: </strong></td>
                                    <td class="pl-3 p-0"> {{$nota->id}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>Cliente: </strong></td>
                                    <td class="pl-3 p-0"> {{$nota->nombre_cliente}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>Telefono: </strong></td>
                                    <td class="pl-3 p-0"> {{$nota->telefono}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>Correo: </strong></td>
                                    <td class="pl-3 p-0"> {{$nota->email}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>Direccion: </strong></td>
                                    <td class="pl-3 p-0"> {{$nota->direccion}}</td>
                                </tr>
                            </tbody>

                        </table>
                        <span style="font-size: 15px"><i class="fas fa-truck"></i> ENVIO</span>
                        <table class="table table-sm mt-1" style="font-size: 13px">
                            <tbody>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>Entregar en: </strong><br> {{$nota->direccion_envio}} </td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>Referencia:</strong> <br> {{$nota->referencia_envio}} </td>
                                </tr>
                            </tbody>
                        </table>

                        <span style="font-size: 15px"><i class="fas fa-truck"></i> DATOS FACTURACIÓN</span>
                        <table class="table table-sm mt-1" style="font-size: 13px">
                            <tbody>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>Dirección: </strong>{{$nota->direccion_factura}} </td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>RFC: </strong>{{$nota->rfc}} </td>
                                </tr>
                                <tr>
                                    <td class="pl-3 p-0"> <strong>CFDI: </strong>{{$nota->rfc}} </td>
                                </tr>
                            </tbody>
                        </table>

                        <span style="font-size: 13px"><i class="fas fa-search"></i> OBSERVACIONES</span>
                        <table class="table table-sm mt-1" style="font-size: 13px">
                            <tbody>
                                <tr>
                                    <td class="pl-3 p-0"> {{$nota->observaciones}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @inject('tipoeva','App\Http\Controllers\CatalogoGasController')

            <div class="col ml-0">
                <div class="card table-responsive" style="height: 25rem">
                    <div class="card-body">
                        CILINDROS ENTRADA
                        <hr class="mt-0">
                            <table class="table table-bordered  table-sm" style="font-size: 13px">
                                <thead >
                                    <tr >
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">CAPACIDAD</th>
                                        <th scope="col">MATERIAL</th>
                                        <th scope="col">FABRICANTE</th>
                                        <th scope="col">GAS</th>
                                        <th scope="col">TIPO</th>
                                    </tr>
                                </thead>
                                <tbody id="tablelistaTanques" >
                                    @foreach ($tanques as $tanq)
                                    @if ($tanq->insidencia=='ENTRADA')
                                        <tr>
                                            <td>{{$tanq->num_serie}}</td>
                                            <td>{{$tanq->ph}}</td>
                                            <td>{{$tanq->capacidad}}</td>
                                            <td>{{$tanq->material}}</td>
                                            <td>{{$tanq->fabricante}}</td>
                                            <td>{{$tipoeva->nombre_gas($tanq->tipo_gas)}}</td>
                                            <td>{{$tanq->tipo_tanque}}</td>
                                        </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        
                        CILINDROS SALIDA
                        <hr class="mt-0">
                        <table class="table table-bordered  table-sm" style="font-size: 13px">
                            <thead >
                                <tr >
                                    <th scope="col">#SERIE</th>
                                    <th scope="col">CANT.</th>
                                    <th scope="col">U. M.</th>
                                    <th scope="col">GAS</th>
                                    <th scope="col">TAPA</th>
                                    <th scope="col">DESCRIPCIÓN</th>
                                    <th scope="col">P.U.</th>
                                    <th scope="col">IVA</th>
                                    <th scope="col">IMPORTE</th>
                                </tr>
                            </thead>
                            <tbody id="tablelistaTanques" >
                                @foreach ($tanques as $tanq)
                                @if ($tanq->insidencia=='SALIDA')
                                    <tr>
                                        <td>{{$tanq->num_serie}}</td>
                                        <td>{{$tanq->cantidad}}</td>
                                        <td>{{$tanq->unidad_medida}}</td>
                                        <td>{{$tipoeva->nombre_gas($tanq->tipo_gas)}}</td>
                                        <td>{{$tanq->tapa_tanque}}</td>
                                        <td>PH: {{$tanq->ph}}, {{$tanq->material}}, {{$tanq->fabricante}}, {{$tanq->tipo_tanque}}</td>
                                        <td>$ {{number_format($tanq->precio_unitario,2)}}</td>
                                        <td>$ {{number_format($tanq->iva_particular,2)}}</td>
                                        <td>$ {{number_format($tanq->importe,2)}}</td>
                                    </tr>
                                @endif
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
                    </div>
                </div>

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
