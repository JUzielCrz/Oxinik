<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Contrato</title>
        <!--Styles -->
        <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            @page {
                margin: 0cm 0cm;
                /* font-size: 1.5em; */
            }
            /* .logo {
                background-image: url("./img/logo.png");
            } */

            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                /* background-color: #46C66B;
                color: white; */
                text-align: center;
                line-height: 12px;
            }
            
            body {
                margin: 2.2cm 2cm 2cm;
                font-family: Arial, Helvetica, Sans-serif;
                color: black;
                font-size: 12px;
                text-align: justify;
                /* text-indent: 1.5em; */
                
            }

            .page-break {
                page-break-after: always;
            }

            span {
                text-transform: uppercase;
            }

            footer {
                position: fixed;
                bottom: 0.7cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                /* background-color: #46C66B; */
                /* color: white; */
                text-align: center;
                line-height: 14px;
                color: #636b6f;
                
            }
        </style>
    </head>


    <body>

        <header>
            <table class="table table-borderless ">
                <tbody>
                    <td class="ml-3"> <img src="img/logo.jpg" style="width: 200px" alt=""></td></td>
                    <td class="mt-4 mr-3 text-right"> N° CONTRATO: <strong>{{$contrato->id}}</strong> </td>
                </tbody>
            </table> 
        </header>

        <main>
            <h5 style="font-size: 16px; text-align: center">CONTRATO DE ARRENDAMIENTO DE EQUIPO INSTRUMENTAL MEDICO Y EQUIPO DE OXIGENO MEDICINAL Y ACCESORIOS</h5>
            
            <p class="mt-4">Que celebran por una parte el señor <strong>Juan Manuel Contreras Gómez</strong>, propietario del establecimiento OXINIK GASES ESPECIALES, a quién en lo sucesivo se le denominara “El Contratante” 
                y por la otra parte el sr (a). <span><strong>{{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</strong></span>, a quién se le denominara “El Contratista”, los cuales se sujetarán a las siguientes CLÁUSULAS: </p>

            <p><strong>PRIMERA:</strong> “El Contratante”, entrega a “El Contratista” en calidad de alquiler:
                @foreach ($tanques as $item)
                    <span>{{$item->cilindros}}</span> cilindro(s) de <span>{{$item->material}}</span> de <span>{{$item->nombre}}</span> <span>{{$item->tipo_tanque}}</span>, 
                @endforeach
                @if ($contrato->reguladores>0)
                y {{$contrato->reguladores}} regulador(es) {{$contrato->modelo_regulador}},
                @endif
                @if ($contrato->frecuency == "")
                con un costo de renta $80.00 (ochenta pesos 00/100 m.n.) diarios,
                @else
                con un costo de renta  {{$contrato->precio_renta}} ({{$preciorenta}} 00/100 m.n.) {{$contrato->frecuency}},
                @endif
                 que inicia el día {{date('Y-m-d', strtotime($contrato->created_at))}}, el cual será utilizado en el domicilio ubicado en {{$contrato->direccion}}, entre las calles de {{$contrato->calle1}} y {{$contrato->calle2}}, quien cuenta con número telefónico {{$cliente->telefono}} y {{$cliente->telefonorespaldo}}. </p>


            <p><strong>SEGUNDA:</strong> El equipo dado en renta a “El Contratista” por parte de “El Contratante”, no podrá bajo ninguna circunstancia ser prestado, sub arrendado ó cedido en forma alguna a terceras personas, constituyéndose “El Contratista” como el responsable directo del buen uso y de la conservación del equipo alquilado y se obliga a pagar el doble del importe de todo el equipo alquilado en el caso de robo, destrucción ó daños que sufra el equipo alquilado y tendrá que pagar las reparaciones que sufra el equipo mencionado.</p>

            <p><strong>TERCERA:</strong> “El Contratista” deberá informar a “El Contratante”, con veinticuatro horas de anticipación al de concluir el presente contrato de alquiler, por vía telefónica si dará por concluido el contrato de alquiler y de no hacerlo se tendrá el contrato de alquiler por renovado automáticamente por el mismo tiempo y precio que se contrató inicialmente, “El Contratista” tendrá como plazo de dos días naturales para pagar en las oficinas que ocupan el establecimiento OXI NIK GASES ESPECIALES, la cantidad correspondiente del equipo alquilado por la renovación del contrato, ya que de lo contrario se le realizara un cobro extra por el cobro a domicilio, y en caso de demora de pago, esto causara una sanción de un 20 % sobre el monto del presente contrato, y la cantidad que sirvió como depósito no se le devolverá bajo ninguna circunstancia.</p>

            <p><strong>CUARTA:</strong> “El Contratista” tiene la obligación de hacer su consumo exclusivamente con el establecimiento OXI NIK GASES ESPECIALES, y no puede bajo ninguna circunstancia trasladar los tanques, para su llenado en ninguna otra empresa o cambio/ canjeo por su número de serie de dichos cilindros.  </p>

            <p><strong>QUINTA:</strong> “El Contratista” debe entregar un depósito en garantía de ${{number_format($tanques->sum('deposito_garantia'), 2, '.', ',')}} ({{$precioLetras}} 00/100 m.n.), por CADA UNO de los envases solicitados en alquiler y proporcionados por “El Contratante”, el cual podrá satisfacerse mediante tarjeta de crédito, transferencia bancaria o en efectivo en el domicilio del establecimiento OXI NIK GASES ESPECIALES, ubicado en la calle Ignacio Zaragoza, número 213, letra “A”, en la colonia Fernando Gómez Sandoval, del Municipio de Santa Lucia del Camino, Oaxaca, c. p. 71243, cuyo justificante se adjuntará al presente contrato.</p>

            @php
                $multa=0;
                $multa=$tanques->sum('cilindros') * 15000;
                
            @endphp
             @inject('num_letras','App\Http\Controllers\ConvertNumberController')
            <p>En la ciudad de Oaxaca de Juárez, Oaxaca, debo y pagaré incondicionalmente y a la orden del señor Juan Manuel Contreras Gómez, la cantidad de ${{number_format($multa, 2, '.', ',')}} ({{$num_letras->toMoney($multa, 2, 'PESOS','CENTAVOS')}} 00/100 MONEDA NACIONAL), valor recibido a mi entera satisfacción, con fecha de vencimiento _______________, sujeto a la condición de que de no hacer pago de acuerdo al artículo 79 y 152 de la Ley General de Títulos y Operaciones de Crédito, causara en interes moratorio de _____%, por cada mes o fracción.</p>


            <br>
            <br>
            <p class="text-center">________________________ <br>
                Nombre y firma. 
            </p>


            <script type="text/php">
                if ( isset($pdf) ) {
                    $pdf->page_script('
                        $font = $fontMetrics->get_font("Arial", "normal");
                        $pdf->text(270, 820, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
                    ');
                }
            </script>
        </main>
        
        <footer>
            <p >Calle: Ignacio Zaragoza, número 213, letra “A”, colonia Fernando Gómez Sandoval, Santa Lucia del Camino, Oax. 71243. <br>
            Tel:  951 1950 200 &nbsp; &nbsp; &nbsp; 951 240 06 67 &nbsp; &nbsp; &nbsp; 951 503 12 28 sge. &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; correo: oxinik@gmail.com</p>
        </footer>
    </body>

</html>