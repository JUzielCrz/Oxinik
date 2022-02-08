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
                        <td>
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


            <table class="table mt-1 mb-3">
                <tbody>
                    <tr>
                        <td>
                            <strong>Cliente:</strong> {{$nota->nombre}} <br>
                            <strong>Telefono: </strong> {{$nota->telefono}} <br>
                            <strong>Correo: </strong> {{$nota->email}} <br>
                            <strong>Direccion: </strong> {{$nota->direccion}} 
                        </td>
                        <td >
                            <p><strong>Entregar en: </strong> <br> {{$nota->direccion_envio}} <br> 
                                <strong>Referencia: </strong> <br> {{$nota->referencia_envio}}
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
            
            
            @inject('tipoeva','App\Http\Controllers\CatalogoGasController')
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
                                    <td>{{$tipoeva->nombre_gas($tanq->tipo_gas)}} </td>
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

            @if ($nota->observaciones!=null)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><strong>Observaciones:</strong> <br>{{$nota->observaciones}}</td>
                    </tr>
                </tbody>
            </table>
            @endif
            
            <table class="table table-sm table-bordered mt-2">
                <tbody >
                    <tr style="background: black">
                        <td colspan="3"><div class="text-center text-white" > CUENTAS BANCARIAS PARA TRANSFERENCIAS</div></td>
                    </tr>
                    <tr>
                        <td colspan="3"  class="text-center">
                            RFC: <strong>{{$empresa->rfc}}</strong> <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="p-0 m-0">
                                Titular: <strong>{{$empresa->titular1}} </strong> <br>
                                BANCO: <strong>{{$empresa->banco1}}</strong> <br>
                                # CUENTA: <strong>{{$empresa->num_cuenta1}}</strong> <br>
                                CLABE: <strong>{{$empresa->clave1}}</strong> <br>                                
                            </p>
                        </td>
                        <td>
                            <p class="p-0 m-0">
                                Titular: <strong>{{$empresa->titular2}} </strong> <br>
                                BANCO: <strong>{{$empresa->banco2}}</strong> <br>
                                # CUENTA: <strong>{{$empresa->num_cuenta2}}</strong> <br>
                                CLABE: <strong>{{$empresa->clave2}}</strong> <br>                                
                            </p>
                        </td>
                        <td>
                            <p class="p-0 m-0">
                                ASÍ MISMO SE LES PIDE ENVIAR COMPROBANTE DE PAGO AL SIGUIENTE CORREO: <strong>{{$empresa->email}}</strong><br>
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
    

