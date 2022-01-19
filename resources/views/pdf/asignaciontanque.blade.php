<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Dotacion</title>
        <!--Styles -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <style>
            @page {
                margin: 0cm 0cm;
                font-size: 1.5em;
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
                line-height: 30px;
            }

            footer {
                position: fixed;
                bottom: 0.7cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                text-align: center;
                line-height: 35px;
            }
            
            body {
                margin: 3cm 2cm 2cm;
                font-family: Arial, Helvetica, Sans-serif;
                color: black;
                font-size: 14px;
                text-align: justify;
            }

            .page-break {
                page-break-after: always;
            }

            span {
                text-transform: uppercase;
            }
        </style>
    </head>
    <body style="font-size: 14px">
        <header>
            <table class="table table-borderless ">
                <tbody>
                    <td> <img src="img/logo.svg" style="width: 200px" alt=""></td></td>
                    <td class="mt-4 mr-3 text-right"> <img src="img/email.svg" style="height: 25px;" alt=""> </td>
                </tbody>
            </table> 
        </header>

        <main>
            <p class="text-center"><strong>{{$nota->incidencia}}</strong> DE DOTACION CON EL CLIENTE</p>
            
            <p> FECHA: <strong>{{$nota->fecha}}</strong><br>
                No. CONVENIO DE CLIENTE: <strong>{{$contrato->num_contrato}}</strong><br>
                NOMBRE DEL CLIENTE: <strong> {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}} </strong> <br>
            </p>

            @php
                if($nota->incidencia == 'AUMENTO'){
                    $optiontext='AUMENTO DE DOTACIÓN';
                    $thgarantia='DEP. GAR';
                }else{
                    $optiontext='DIMINUCIÓN  DE DOTACIÓN';
                    $thgarantia='DEV. DEP. GAR';
                }
            @endphp
            <p><img src="img/ico/checkcuadro2.svg" style="width: 20px" alt="" class="mr-2"> {{$optiontext}}</p>

            <table class="table table-sm text-center" style="font-size: 13px">
                <thead>
                    <tr>
                        <th style="padding: 0">CILINDROS</th>
                        <th style="padding: 0">GAS</th>
                        <th style="padding: 0">TIPO</th>
                        <th style="padding: 0">MATERIAL</th>
                        <th style="padding: 0">CAPACIDAD</th>
                        <th style="padding: 0">{{$thgarantia}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalleNota as $tanques)
                        @if ($tanques->cilindros > 0)
                            <tr>
                                <td style="padding: 0">{{$tanques->cilindros}}</td>
                                <td style="padding: 0">{{$tanques->nombre}}</td>
                                <td style="padding: 0">{{$tanques->tipo_tanque}}</td>
                                <td style="padding: 0">{{$tanques->material}}</td>
                                <td style="padding: 0">{{$tanques->capacidad}} {{$tanques->unidad_medida}}</td>
                                <td style="padding: 0">{{$tanques->deposito_garantia}}</td>
                            </tr>
                        @endif            
                    @endforeach
                </tbody>
            </table>

            <p>RESUMEN CILINDROS EN CONTRATO</p>

            <table class="table table-sm text-center" style="font-size: 13px;">
                <thead>
                    <tr>
                        <th style="padding: 0">CILINDROS</th>
                        <th style="padding: 0">GAS</th>
                        <th style="padding: 0">TIPO</th>
                        <th style="padding: 0">MATERIAL</th>
                        <th style="padding: 0">CAPACIDAD</th>
                    </tr>
                </thead>
                <tbody >
                    @foreach ($asignaciones_all as $tanque)
                        @if ($tanque->cilindros > 0)
                            <tr>
                                <td style="padding: 0">{{$tanque->cilindros}}</td>
                                <td style="padding: 0">{{$tanque->nombre}}</td>
                                <td style="padding: 0">{{$tanque->tipo_tanque}}</td>
                                <td style="padding: 0">{{$tanque->material}}</td>
                                <td style="padding: 0">{{$tanque->capacidad}} {{$tanque->unidad_medida}}</td>
                            </tr>
                        @endif            
                    @endforeach
                </tbody>
            </table>

            
            <p>LOS ENVASES RECIBIDOS MEDIANTE LA FIRMA DE ESTE DOCUMENTO ARRIBA RELACIONADOS SON PROPIEDAD DE OXINIK GASES ESPECIALES. </p>
            <p>EL PRESENTE DOCUMENTO HACE CONSTAR EL ACUERDO DE LAS PARTES QUE CELEBRARON EN EL CONVENIO ARRIBA MENCIONADO, PARA AUMENTAR O DISMINUIR LA DOTACIÓN DE ENVASES, RECONOCIENDO LOS FIRMANTES DEL PRESENTE INSTRUMENTO QUE ESTE FORMA PARTE INTEGRANTE DEL MISMO. </p>
                
            <table class="table table-borderless mt-5">
                <tbody class="text-center">
                    <tr>
                        <td>_____________________________</td>
                        <td>_____________________________</td>
                    </tr>
                    <tr>
                        <td>NOMBRE Y FIRMA <br> QUIEN ATIENDE</td>
                        <td>NOMBRE Y FIRMA <br> CLIENTE</td>
                    </tr>
                </tbody>
            </table>

            <div class="page-break"></div>

            <p class="text-right">DEPO. XXXX</p>

            @php
                $precioFormat= number_format($detalleNota->sum('deposito_garantia'), 2, '.', ',')
            @endphp
            <p class="mt-4">
                RECIBI DE: <strong> {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}} </strong><br>
                LA CANTIDAD DE: <strong>$ {{$precioFormat}}</strong><br>
            </p>

            <p class="mt-5">POR CONCEPTO DE DEPÓSITO EN GARANTIA DE <strong>{{$nota->incidencia}}</strong> DE CILINDROS. </p>

            @php
                $fechacontrato= $nota->fecha;
                $arrayFecha=explode("-", $fechacontrato);
                $mesingles=$arrayFecha[1];
                if($mesingles == '01') $mes='ENERO';
                if($mesingles == '02') $mes='FEBRERO';
                if($mesingles == '03') $mes='MARZO';
                if($mesingles == '04') $mes='ABRIL';
                if($mesingles == '05') $mes='MAYO';
                if($mesingles == '06') $mes='JUNIO';
                if($mesingles == '07') $mes='JULIO';
                if($mesingles == '08') $mes='AGOSTO';
                if($mesingles == '09') $mes='SEPTIEMBRE';
                if($mesingles == '10') $mes='OCTUBRE';
                if($mesingles == '11') $mes='NOVIEMBRE';
                if($mesingles == '12') $mes='DICIEMBRE';
                $fechaactual2 = $arrayFecha[2]." DE ".$mes." DE ".$arrayFecha[0];
            @endphp
            <p >PARA SU APLICACIÓN DE ACUERDO CON LO ESTABLECIDO POR LA CLAUSULA SEGUNDA, PARRAFO SEGUNDO DEL CONVENIO DE SUMINISTRO DE GAS Y COMODATO DE FECHA <strong>{{$fechaactual2}}</strong>. </p>

            <P class="text-right mt-5">OAXACA DE JUÁREZ A {{$fechaactual2}}</P>

            <p class="text-center mt-5"> __________________________ <br> NOMBRE Y FIRMA</p>

            <p class="mt-5"><strong>OBSERVACIONES</strong></p>
            <ul style="list-style-type: circle; ">
                <li>ES INDISPENSABLE LA PRESENTACIÓN DE ESTE RECIBO PARA LA DEVOLUCIÓN DE SU DINERO.</li>
                <li>-	POR SEGURIDAD, EL IMPORTE DE ESTE DEPÓSITO SOLO PODRÁ SER ENTREGADO A LA PERSONA A QUIEN REFERENCIA ESTE DOCUMENTO. EN CASO DE SER UNA TERCERA PERSONA TRAER CARTA PODER SIMPLE FIRMADA POR EL CONTRATANTE, CON COPIA DE INE DE AMBAS PARTES. </li>
            </ul>
        </main>

        <footer>
            <img src="img/membrete_footer.svg" style="width: 650px" alt="">
        </footer>
    </body>
</html>
