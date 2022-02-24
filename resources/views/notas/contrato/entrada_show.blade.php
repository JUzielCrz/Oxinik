@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')
    <div class="container">
        <div class="card">
            <div class="card-header">
                NOTA ENTRADA
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
                                    <td class="pl-3 p-0">{{$contrato->num_contrato}}</td>
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
                        <table class="table table-sm mt-1 mb-2" style="font-size: 13px">
                            <tbody>
                                <tr>
                                    <td>Entregar en: <br> {{$contrato->direccion}} </td>
                                </tr>
                                <tr>
                                    <td>Referencia: <br> {{$contrato->referencia}} </td>
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
                        @inject('tipoeva','App\Http\Controllers\CatalogoGasController')

                            <table class="table table-bordered  table-sm" style="font-size: 13px">
                                <thead >
                                    <tr >
                                        <th scope="col">#SERIE</th>
                                        <th scope="col">DESCRIPCION</th>
                                        <th scope="col">GAS</th>
                                        <th scope="col">TAPA</th>
                                    </tr>
                                </thead>
                                <tbody id="tablelistaTanques" >
                                    @foreach ($tanques as $tanq)
                                        <tr>
                                            <td>{{$tanq->num_serie}}</td>
                                            <td>{{$tanq->capacidad}}, {{$tanq->fabricante}}, PH: {{$tanq->ph}}, {{$tanq->material}}, {{$tanq->tipo_tanque}}</td>
                                            <td>{{$tipoeva->nombre_gas($tanq->tipo_gas)}}</td>
                                            <td>{{$tanq->tapa_tanque}}</td>
                                            
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
                                    <td><strong>RECARGOS:</strong> $ {{number_format($nota->recargos, 2, '.', ',')}}</td>
                                    <td><strong>METODO DE PAGO:</strong> {{$nota->metodo_pago}}</td>
                                    <td><strong><i class="fas fa-search"></i> OBSERVACIONES:</strong> {{$nota->observaciones}}</td>

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
        $("#nav-ico-notas").addClass('active');
    });
</script>
<script type="text/javascript">
    $("#nav-ico-notas").addClass('active');
</script>

<!--Fin Scripts-->
