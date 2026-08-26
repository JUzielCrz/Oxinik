<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Nota Remisión</title>
        <!--Styles -->
        <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- icon -->
    </head>

    <body style="font-size: 13px">
        <main>
            <table class="table table-borderless mb-0">
                <tbody>
                    <tr id="tablaencabezado">
                        <td class="text-center">
                            <img src="img/logo.png" style="width: 200px" alt=""></td>
                        <td>
                            <p >
                                {{$empresa->direccion}}<br>
                                {{$empresa->telefono1}} / {{$empresa->telefono2}} <br>
                                {{$empresa->email}}
                            </p>
                        </td>
                    </tr>
                </tbody>

                <tbody class="mb-0">
                    <tr>
                        <td  class="text-right">
                            Fecha: {{$note->created_at}}
                        </td>
                        <td>
                            Folio Nota General: <span style="color: red">{{$note->id}}</span>
                        </td>
                        <td  class="text-right" >
                            Folio Nota Pago: <span style="color: red">{{$payment->id}}</span>
                        </td>
                    </tr>
                </tbody>
            </table>


            <table class="table mt-1 mb-3">
                <tbody>
                    <tr>
                        <td>
                            <strong>Cliente:</strong> {{$note->name}} <br>
                            <strong>Telefono: </strong> {{$note->phone_number}} <br>
                            <strong>Correo: </strong> {{$note->email}} <br>
                            <strong>Direccion: </strong> {{$note->address}} 
                        </td>
                        {{-- <td >
                            <p><strong>Entregar en: </strong> <br> {{$note->direccion_envio}} <br> 
                                <strong>Referencia: </strong> <br> {{$note->referencia_envio}}
                            </p>
                        </td> --}}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
            
            
            <span class="mt-2"><strong>Concentrador de Oxigeno Medicinal</strong></span>
            
            <p>Esta nota se anexa a la nota general, Número de Nota General: {{$note->id}}
                </p>
            <p>A continuación se muestra el tiempo de renta  y cantidad a pagar:</p>

            <table class="table table-bordered  table-sm">
                <thead>
                    <tr>
                        <th>Tiempo</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dia(s)</td>
                        <td>{{$payment->day}}</td>
                        <td>$ {{$payment->price_day}}</td>
                        <td>$ {{$payment->day * $payment->price_day}}</td>                        
                    </tr>
                    <tr>
                        <td>Semanas(s)</td>
                        <td>{{$payment->week}}</td>
                        <td>$ {{$payment->price_week}}</td>
                        <td>$ {{$payment->week * $payment->price_week}}</td>                        
                    </tr>
                    <tr>
                        <td>Mes(es)</td>
                        <td>{{$payment->mount}}</td>
                        <td>$ {{$payment->price_mount}}</td>
                        <td>$ {{$payment->mount * $payment->price_mount}}</td>                        
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <tbody >
                    <tr>
                        @php
                            $iva = $payment->total * 0.16;
                            $subtotal = $payment->total - $iva;
                        @endphp
                        <td>SUBTOTAL: <br>$ {{number_format($subtotal, 2)}}</td>
                        <td>TASA 16% IVA: <br>$ {{number_format($iva,2)}}</td>
                        {{-- <td>ENVÍO: <br>$ {{number_format($note->precio_envio,2)}}</td> --}}
                        <td>TOTAL: <br> $ {{number_format($payment->total,2)}}</td>
                    </tr>
                </tbody>
            </table>

            @if ($note->observaciones!=null)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><strong>Observaciones:</strong> <br>{{$note->observaciones}}</td>
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
                </tbody>
            </table>
            @include('pdf.partials.cuentas_bancarias')
            




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
    
