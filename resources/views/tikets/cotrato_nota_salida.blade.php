<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Nota Remisión</title>
        <!--Styles -->
        <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- icon -->

        <style>
            @page {
                margin: 3mm 3mm;
            }

            * {
                font-size: 10px;
                font-family: 'DejaVu Sans', serif;
                line-height: 10px;
            }
            p{
                text-align: center;
            }

        </style>
    </head>


    <body>
        <main>
            <div class="text-center mt-0" style="">
                <img src="img/logo.svg" style="width: 200px" alt="">
            </div>
            <p>
                Calle Ignacio Zaragoza 213 A <br> 
                Col. Fernando Gómez Sandoval. <br>
                Santa Lucia del Camino, Oaxaca. <br>
                951 195 02 00 / 951240 06 67 <br>
                sge.oxinik@gmail.com
            </p>

                <div class="mt-2 mr-2 text-right">
                    {{$nota->created_at}}<br>
                </div>
                
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="ml-1 p-0">#User id</td>
                            <td class="p-0">{{$nota->user_id}}</td>
                        </tr>
                        <tr>
                            <td class="ml-1 p-0">#Folio Nota</td>
                            <td class="p-0">{{$nota->id}}</td>
                        </tr>
                    </tbody>
                </table>
                <hr class="m-2">
                @inject('tipoeva','App\Http\Controllers\CatalogoGasController')
                <table class="table table-borderless mt-0 mb-0">
                    <thead>
                        <tr>
                            <th class=" ml-1 p-0">#SERIE</th>
                            <th class="p-0">DESCRIPCION</th>
                            <th class="p-0">IMPORTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tanques as $tanq)
                            @php
                                $desc="";
                                $desc=strtoupper($tanq->cantidad." ".$tanq->unidad_medida.", ". $tipoeva->nombre_gas($tanq->tipo_gas).", ". $tanq->material.", ". $tanq->fabricante.", ". $tanq->tipo_tanque)
                            @endphp
                            <tr>
                                <td class="ml-1 p-0">{{$tanq->num_serie}}</td>
                                <td class="p-0" style="font-size: 10px">{{$desc}}</td>
                                <td class="p-0">$ {{number_format($tanq->importe,2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr class="m-2">
                <div class="text-right mt-0">
                    SUBTOTAL: ${{number_format($nota->subtotal, 2, '.', ',')}} <br>
                    ENVÍO: ${{number_format($nota->envio,2)}} <br>
                    TASA 16% IVA: ${{number_format($nota->iva_general,2)}} <br>
                    TOTAL: {{number_format($nota->total,2)}} 
                    
                </div>
                <div class="text-right mt-1">
                    @if ($nota->primer_pago < $nota->total)
                        <br>
                        Abono: $ {{number_format($nota->primer_pago,2)}}<br>
                        Adeudo: $ {{number_format($nota->total - $nota->primer_pago,2)}}
                    @endif
                </div>
                <hr class="m-2">
                <p style="margin: 0">
                    GRACIAS POR SU COMPRA <br>
                    FACEBOOK: OXINIK GASES ESPECIALES<br>
                    SGE.OXINIK@GMAIL.COM<br>
                    ESTA VENTA SE FACTURA EN LA VENTA GLOBAL DEL DIA.<br>
                    PIDA SU FACTURA AL MOMENTO DE SU COMPRA<br>
                </p>
        </main>

        
    </body>

    </html>
    

