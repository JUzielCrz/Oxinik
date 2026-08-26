<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Nota Remisión</title>
        <!--Styles -->
        <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- icon -->
    </head>


    <body style="font-size: 14px">
        <main>
            
            <table class="table table-borderless">
                <tbody>
                    <tr id="tablaencabezado">
                        <td class="text-center">
                            <img src="img/logo.png" style="width: 200px" alt=""></td>
                        <td >
                            <p >
                                {{$empresa->direccion}}<br>
                                {{$empresa->telefono1}} / {{$empresa->telefono2}} <br>
                                {{$empresa->email}}
                            </p>
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td  class="text-right">
                            Fecha: {{$nota->fecha}}
                        </td>
                        <td  class="text-right" >
                            Folio: <span style="color: red">{{$nota->id}}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class=" table table-sm">
                <tbody>
                    <tr >
                        <td style="width: 15rem">
                            <p > 
                                @if ($cliente->empresa != null)
                                <strong>Empresa: </strong>{{$cliente->empresa}} <br>
                                <strong>Representante: </strong>  {{$cliente->nombre}} {{$cliente->apPaterno}}  {{$cliente->apMaterno}} <br>
                                @else
                                <strong>Cliente: </strong> {{$cliente->nombre}} {{$cliente->apPaterno}}  {{$cliente->apMaterno}}  <br>
                                @endif
                                <strong>#Contrato:  </strong> {{$contrato->id}}<br>
                                <strong>Tipo Contrato: </strong> {{$contrato->tipo_contrato}}<br>
                                <strong>1° Telefono: </strong> {{$cliente->telefono}}<br>
                                <strong>2° Telefono: </strong> {{$cliente->telefonorespaldo}}<br>
                                
                            </p>
                        </td>
                        <td>
                            <p>
                                <strong>Entregar en: </strong> {{$contrato->direccion}} <br>
                                <strong>Referencia: </strong> {{$contrato->referencia}} 
                            </p> 
                        </td> 
                    </tr>           
                </tbody>
            </table>

            
            <table class="table table-bordered  table-sm">
                    <thead >
                        <tr >
                            <th scope="col">#SERIE</th>
                            <th scope="col">CANT</th>
                            <th scope="col">U.M.</th>
                            <th scope="col">GAS</th>
                            <th scope="col">TAPA</th>
                            <th scope="col">P.U.</th>
                            <th scope="col">IMPORTE</th>
                            <th scope="col">IVA</th>
                        </tr>
                    </thead>
                    @inject('tipoeva','App\Http\Controllers\CatalogoGasController')
                    <tbody id="tablelistaTanques" >
                        @foreach ($tanques as $tanq)
                            <tr>
                                <td>{{$tanq->num_serie}}</td>
                                <td>{{$tanq->cantidad}}</td>
                                <td>{{$tanq->unidad_medida}}</td>
                                <td>{{$tipoeva->nombre_gas($tanq->tipo_gas)}}</td>
                                <td>{{$tanq->tapa_tanque}}</td>
                                <td>${{number_format($tanq->precio_unitario,2)}}</td>
                                <td>${{number_format($tanq->importe,2)}}</td>
                                <td>${{number_format($tanq->iva_particular,2)}}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
            </table>

            

            <table class="table table-bordered">
                <tbody >
                    <tr>
                        <td>SUBTOTAL: <br>$ {{number_format($nota->subtotal, 2, '.', ',')}}</td>
                        <td>ENVÍO: <br>$ {{number_format($nota->envio,2)}}</td>
                        <td>TASA 16% IVA: <br>$ {{number_format($nota->iva_general,2)}}</td>
                        <td>TOTAL: <br> $ {{number_format($nota->total,2)}}</td>
                    </tr>
                </tbody>
            </table>
            @if ($nota->primer_pago < $nota->total)
                <table class="table table-bordered mt-2">
                    <tbody>
                        <tr>
                            <td>Abono: <br> $ {{number_format($nota->primer_pago,2)}}</td>
                            <td>Adeudo: <br> $ {{number_format($nota->total - $nota->primer_pago,2)}}</td>
                        </tr>  
                    </tbody>
                </table>
            @endif
            
            <table class="table table-sm mt-2">
                <tbody>
                <tr>
                    <td class="text-center">_________________________</td>
                </tr>
                <tr>
                    <td class="text-center">Recibido (Nombre y Firma)</td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size: 12px"> <strong>OBSERVACIONES:</strong> {{$nota->observaciones}}</p>
                    </td>
                </tr>
                </tbody>
            </table>
            
            @include('pdf.partials.cuentas_bancarias', ['bankTableFontSize' => '11px'])
            





            <script type="text/php">
                if ( isset($pdf) ) {
                    $pdf->page_script('
                        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                        $pdf->text(270, 780, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
                    ');
                }
            </script>
        </main>

        
    </body>

    </html>
    
