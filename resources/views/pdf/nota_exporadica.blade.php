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
                                Cliente:  <br>
                                Telefono: <br>
                                Correo: <br>
                                direccion: <br>
                            </p>
                        </td>
                        <td rowspan="2" style="width: 8rem">
                                <p > 
                                    {{$nota->nombre_cliente}} <br>
                                    {{$nota->telefono}} <br>
                                    {{$nota->email}} <br>
                                    {{$nota->direccion}}<br>
                                </p>
                            
                        </td>

                        <td style="width: 4rem"><p >Entregar en:</p> </td>
                        <td style="width: 8rem"><p >{{$nota->direccion_envio}} </p></td>  
                    </tr>
                    <tr>
                        <td style="width: 4rem"><p >Referencia:</p> </td>
                        <td style="width: 8rem"><p >{{$nota->referencia_envio}} </p></td> 
                    </tr>              
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
            
            <table class="table table-bordered mt-2">
                <tbody >
                    <tr>
                        <td colspan="4">
                            <p>
                                <div class="text-center text-white" style="background: black"> CUENTAS BANCARIAS PARA TRANSFERENCIAS</div> <br>
                                BANCO: <strong>HSBC</strong> <br>
                                RFC: <strong>COGJ940414C74</strong> <br>
                                #CUENTA: <strong>4065355091</strong> <br>
                                CLABE: <strong>021610040653550912</strong> <br>
                                Al hacer esta transferencia electrónica, favor de poner como referencia su numero de nota.
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
    

