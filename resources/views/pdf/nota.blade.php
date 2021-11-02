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

            <table class=" table table-sm">
                <tbody>
                    <tr >
                        <td rowspan="2" style="width: 4rem">
                            <p > 
                                @if ($cliente->empresa != null)
                                Empresa:  <br>
                                Representante:  <br>
                                @else
                                Cliente:  <br>
                                @endif
                                #Contrato:  <br>
                                Tipo Contrato: <br>
                                Asignación: <br>
                                1° telefono: <br>
                                2° telefono: <br>
                                
                            </p>
                        </td>
                        <td rowspan="2" style="width: 8rem">
                                <p > 
                                    @if ($cliente->empresa != null)
                                    {{$cliente->empresa}} <br>
                                    @endif
                                    {{$cliente->nombre}} {{$cliente->apPaterno}}  {{$cliente->apMaterno}} <br>
                                    {{$contrato->num_contrato}} <br>
                                    {{$contrato->tipo_contrato}} <br>
                                    {{$contrato->asignacion_tanques}} tanques <br>
                                    {{$cliente->telefono}} <br>
                                    {{$cliente->telefonorespaldo}} <br>
                                    
                                </p>
                            
                        </td>

                        <td style="width: 4rem"><p >Entregar en:</p> </td>
                        <td style="width: 8rem"><p >{{$contrato->direccion}} </p></td>  
                    </tr>
                    <tr>
                        <td style="width: 4rem"><p >Referencia:</p> </td>
                        <td style="width: 8rem"><p >{{$contrato->referencia}} </p></td> 
                    </tr>              
                </tbody>
            </table>

            
            <table class="table table-bordered  table-sm">
                    <thead >
                        <tr >
                            <th scope="col">#SERIE</th>
                            <th scope="col">CANTIDAD</th>
                            <th scope="col">U. M.</th>
                            <th scope="col">GAS</th>
                            <th scope="col">TAPA</th>
                            {{-- <th scope="col">DESCRIPCIÓN</th> --}}
                            <th scope="col">PRECIO UNITARIO</th>
                            <th scope="col">IMPORTE</th>
                            <th scope="col">IVA</th>
                            {{-- <th scope="col">TOTAL</th> --}}
                        </tr>
                    </thead>

                    <tbody id="tablelistaTanques" >
                        @foreach ($tanques as $tanq)
                            {{-- @php
                                $subtotal=$subtotal+$tanq->precio;  
                            @endphp --}}
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

            

            <table class="table table-bordered">
                <tbody >
                    <tr>
                        @php
                            
                            $subtotl= $nota->subtotal-($nota->subtotal * 0.16);
                        @endphp
                        <td>SUBTOTAL: <br>$ {{number_format($subtotl, 2, '.', ',')}}</td>
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
            {{-- @else
            <table class="table table-bordered mt-2">
                <tbody  >
                    <tr>
                        <td>PAGO CUBIERTO</td>
                    </tr>  
                </tbody>
            </table> --}}
            @endif
            
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
    

