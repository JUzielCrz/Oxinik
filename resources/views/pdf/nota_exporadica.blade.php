<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Nota Remisión</title>
        <!--Styles -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- icon -->
    </head>

    <body style="font-size: 11px">
        <main>
            <table class="table table-borderless">
                <tbody>
                    <tr id="tablaencabezado">
                        <td class="text-center">
                            <img src="img/logo.svg" style="width: 200px" alt=""></td>
                        <td >
                            <p >
                                Calle Ignacio Zaragoza 213 A <br> 
                                Col. Fernando Gómez Sandoval. <br>
                                Santa Lucia del Camino, Oaxaca. <br>
                                951 195 02 00 / 951240 06 67 <br>
                                sge.oxinik@gmail.com
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

                    <table class="mb-3">
                        <tbody>
                            <tr>
                                <td style="width: 2rem"><strong>Cliente:</strong> </td>
                                <td style="width: 15rem">{{$nota->nombre_cliente}}</td>
                                <td rowspan="4"><p><strong>Entregar en: </strong> <br> {{$nota->direccion_envio}} <br> <strong>Referencia: </strong> <br> {{$nota->referencia_envio}}</p></td>
                            </tr>
                            <tr>
                                <td style="width: 2rem"><strong>Telefono: </strong></td>
                                <td>{{$nota->telefono}}</td>
                                <td >{{$nota->direccion_envio}} </td>
                            </tr>
                            <tr>
                                <td style="width: 2rem"><strong>Correo: </strong></td>
                                <td>{{$nota->email}} </td>
                            </tr>
                            <tr>
                                <td style="width: 2rem"><strong>Direccion: </strong></td>
                                <td>{{$nota->direccion}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            

            {{-- tanques de entrada --}}
            <span><strong>CILINDROS ENTRADA</strong></span>
            <table class="table table-bordered  table-sm">
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
                        @inject('tipoeva','App\Http\Controllers\CatalogoGasController')
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

            <span class="mt-2"><strong>CILINDROS SALIDA</strong></span>
            <table class="table table-bordered  table-sm">
                    <thead >
                        <tr >
                            <th scope="col">#SERIE</th>
                            <th scope="col">CANTIDAD</th>
                            <th scope="col">U. M.</th>
                            <th scope="col">GAS</th>
                            <th scope="col">TAPA</th>
                            <th scope="col">DESCRIPCIÓN</th>
                            <th scope="col">PRECIO UNITARIO</th>
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
                                    <td>{{$tanq->tipo_gas}} </td>
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


            <table class="table table-bordered">
                <tbody >
                    <tr>
                        <td>SUBTOTAL: <br>$ {{number_format($nota->subtotal, 2)}}</td>
                        <td>TASA 16% IVA: <br>$ {{number_format($nota->iva_general,2)}}</td>
                        <td>ENVÍO: <br>$ {{number_format($nota->precio_envio,2)}}</td>
                        <td>TOTAL: <br> $ {{number_format($nota->total,2)}}</td>
                    </tr>
                </tbody>
            </table>
            
            <table class="table table-sm table-bordered mt-2">
                <tbody >
                    <tr style="background: black">
                        <td colspan="2"><div class="text-center text-white" > CUENTAS BANCARIAS PARA TRANSFERENCIAS</div></td>
                    </tr>
                    <tr>
                        <td>
                            <p class="p-0 m-0">
                                DENOMINACIÓN : <strong>JUAN MANUEL CONTRERAS GÓMEZ </strong> <br>
                                BANCO: <strong>BANORTE</strong> <br>
                                RFC: <strong>COGJ940414C74</strong> <br>
                                # CUENTA: <strong>1159955737</strong> <br>
                                CLABE: <strong>072610011599557374</strong> <br>
                                # SUCURSAL: <strong>_2376</strong> <br>
                                
                            </p>
                        </td>
                        <td>
                            <p class="p-0 m-0">
                                ASÍ MISMO SE LES PIDE ENVIAR COMPROBANTE DE PAGO AL SIGUIENTE CORREO: <strong>sge.oxinik@gmail.com</strong><br>
                                HACIENDO REFERENCIA EN CONCEPTO ALGUNO DE LOS SIGUIENTES:<br>
                                    * FOLIO DE FACTURA<br>
                                    * NÚMERO DE VALE O TICKET DE VENTA<br>
                                    * NÚMERO DE FOLIO DE HOJA DE CONTRATO.<br>
                                ESTAMOS A SUS ORDENES
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            




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
    

