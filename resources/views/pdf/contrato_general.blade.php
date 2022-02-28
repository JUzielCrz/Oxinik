<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Contrato</title>
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


            
            body {
                margin: 2cm 2cm 2cm;
                font-family: Arial, Helvetica, Sans-serif;
                color: black;
                font-size: 14px;
                text-align: justify;
                /* text-indent: 1.5em; */
                
            }

            .page-break {
                page-break-after: always;
            }

            span {
                text-transform: uppercase;
            }
        </style>
    </head>


    {{-- <style>
        
        div {
        background-image: url("./img/tanque2.png");
        }

    </style> --}}

    <body>

        

        <main>
            <p class="text-right">Convenio: <strong>{{$contrato->id}}</strong></p>
            <h5 style="font-size: 20px; text-align: center">CONTRATO DE ARRENDAMIENTO DE CILINDROS DE OXIGÉNO MEDICINAL E INDUSTRIAL, GASES ESPECIALES Y ACCESORIOS.</h5>
            
            <p class="mt-4">Que celebran por una parte el <strong>C. Juan Manuel Contreras Gómez</strong>, como responsable y/o propietario del establecimiento que comercialmente se denomina OXI NIK Gases Especiales, persona que en lo subsecuente se le denominara “EL ARRENDADOR” y por la otra el <span><strong>C. {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</strong></span> con  @if ($cliente->email != '') correo electrónico <span><strong>{{$cliente->email}}</strong></span> @endif y número telefónico <span><strong>{{$cliente->telefono}}</strong></span>, quien en  lo subsecuente se le denominara “EL ARRENDATARIO”, quienes se sujetan al tenor de las siguientes declaraciones y clausulas: </p>
            
            <h5 style="font-size: 16px; text-align: center">DECLARACIONES:</h5>
 
            <p><strong>“EL ARRENDADOR”</strong>, declara que:</p>
            <p >
                <ul style="list-style-type: lower-latin; ">
                    <li style="">                
                        Es el responsable y/o propietario del establecimiento que comercialmente se denomina OXI   NIK Gases Especiales, con domicilio, en la calle Ignacio Zaragoza, número 213, letra “A”, en la Colonia Fernando Gómez Sandoval, del Municipio de Santa Lucia del Camino, Oaxaca, c. p. 71243.                    </li>
                    <li>Declara que es propietario de cilindros de oxígeno y de diversos gases y tamaños de los cuales se sirve para venderlos, así como de los equipos descritos en el anexo A, que se adjunta al presente contrato, y que se dedica profesionalmente a la venta, alquiler, distribución, suministro de diversos gases y accesorios, de los mismos. Para la prestación de sus servicios cuenta con los medios fiscales, organizativos y técnicos necesarios para su desempeño. </li>
                </ul>
            </p>
            <p><strong>“EL ARRENDATARIO"</strong>, declara que:</p>
            <p >
                <ul style="list-style-type: lower-latin; ">
                    <li style="">                
                        Que está interesado en recibir por parte de “EL ARRENDADOR” los bienes que posteriormente se describirán en los términos y condiciones designados en el presente contrato, a los efectos de arrendar por el precio estipulado en el presente contrato. De tal modo que adquiere la posesión y uso mientras se satisfaga el precio y se cumplan las condiciones estipuladas y convenidas, en el Anexo A.                    </li>
                    <li>
                        Señala como domicilio para todos los efectos de este contrato el ubicado en la <strong>{{$contrato->direccion}}</strong>
                        @if ($contrato->nombre_comercial != null)
                        , con nombre del establecimiento que se denomina <strong>{{$contrato->nombre_comercial }}</strong>
                        @else
                            .
                        @endif
                    </li>
                </ul>
            </p>

            <p><strong>AMABAS PARTES</strong>, declaran que:</p>

            <p>
                Ambas partes se reconocen mutuamente capacidad jurídica suficiente para intervenir en este acto, así como el carácter y representación con que respectivamente lo hacen, las partes convienen en celebrar el presente contrato sujetándose libremente al tenor de las siguientes:
            </p>

            <h5 style="font-size: 16px; text-align: center">CLÁUSULAS:</h5>

            <p><strong>PRIMERA:</strong> “EL ARRENDADOR”, se compromete a:</p>
            <p>
                <ul style="list-style-type: lower-latin; ">
                    <li>Que por medio del presente contrato “EL ARRENDADOR” se obliga a suministrar los gases en envases de diversos tamaños y servicios que comercializa, para el uso y disfrute en perfecto estado de funcionamiento.</li>
                    <li>Garantizar el suministro de los gases en envases de diversos tamaños y servicios que comercializa; así como del equipo por parte de “EL ARRENDATARIO”, durante el periodo de duración del contrato, siempre que este haga un buen uso debido y acorde con las instrucciones entregadas.
                    </li>
                </ul>	
            </p>

            <p><strong>SEGUNDA:</strong> “EL ARRENDATARIO”, se compromete a:</p>
            <p>Que durante la vigencia de este Contrato se compromete a consumir todos los gases y servicios que necesite con “EL ARRENDADOR”, los cuales solicitará por escrito mediante un mensaje de texto vía WhatsApp, mensaje de texto o llamada telefónica, siempre y cuando se encuentre al corriente en todas las obligaciones contraídas, y solo en caso de que “EL ARRENDADOR” no le suministre el servicio en tres días, podrá solicitar el suministro a cualquier otra compañía, salvo en caso fortuito, desastre natural, queda bien claro que el supuesto previsto en esta cláusula no podrá exceder de diez días hábiles. Si transcurre dicho plazo y “EL ARRENDADOR” no ha podido suministrar “EL ARRENDATARIO”, tendrá derecho a dar por terminado el presente contrato sin responsabilidad para él. </p>

            <p><strong>TERCERA:</strong> “EL ARRENDATARIO” se responsabiliza en mantener y preservar con la diligencia debida los productos cedidos en alquiler, y se obliga a pagar el doble del importe de su valor tomando como referencia el costo en el mercado actual en el momento en el que ocurrió el hecho, de todo el equipo alquilado, en el caso de robo, destrucción ó daños que sufra el equipo alquilado y tendrá que pagar las reparaciones que sufra el equipo mencionado, salvo en caso de catástrofe reconocida por  “EL ARRENDADOR”, o por vicios ocultos (que deberán ser aprobados por “EL ARRENDATARIO”).</p>

            <p><strong>CUARTA:</strong> “EL ARRENDATARIO” solicitara el suministro de gases y de los productos en el establecimiento comercial denominado OXI NIK Gases Especiales, con domicilio, en la calle Ignacio Zaragoza, número 213, letra “A”, en la colonia Fernando Gómez Sandoval, del Municipio de Santa Lucia del Camino, Oaxaca, c. p. 71243, en un horario de lunes a viernes de 08:00 a 18:00 horas y los días sábados de 08:00 a 15:00 horas, en los siguientes números telefónicos 951 195 02 00 y 951 240 06 67, en caso que el proveedor no laborará en un día sea por disposición oficial, festivo o por cuestiones meramente administrativos dará aviso al consumidor por medio de una circular con 15 días de anticipación.</p>

            <p><strong>QUINTA:</strong> “EL ARRENDATARIO” no podrá ceder, transferir o sub arrendar bajo ninguna circunstancia a terceros los Derechos consignados en este Contrato, sin la autorización fehaciente y por escrito de “EL ARRENDADOR”. Así mismo, queda prohibido que “EL ARRENDATARIO” suministre, canje o rellene los cilindros de oxígeno, ó envases por su cuenta en otra empresa y de realizarlo pagará a “EL ARRENDADOR” el costo íntegro del gas adquirido rellenado en otro establecimiento.</p>

            <p><strong>SEXTA:</strong> “EL ARRENDATARIO” está obligado a conservar en buen estado los cilindros  obtenidos en arrendamiento y, si no utilizara el servicio por más de seis meses, deberá pagar por gastos de mantenimiento de los cilindros o envases de diversos gases, la cantidad de $200.00 doscientos pesos, cero centavos, moneda nacional, por cada envase que arrende, de no hacerlo, “EL ARRENDADOR” podrá dar por cancelado el contrato, y “EL ARRENDATARIO” deberá realizar la devolución y entrega de los cilindros o envases de diversos gases, que tenga a su cargo.</p>

            

            <p><strong>SEPTIMA:</strong> “EL ARRENDATARIO” deberá entregar un depósito en garantía de por cada uno de los cilindros ó envases solicitados en alquiler y proporcionados por “EL ARRENDADOR”, que no representa de ninguna manera el precio de el o los envases que requiera, y que ampara el presente contrato, los cuales se mencionan en el cuadro siguiente y que se encuentran documentados, en la siguiente tabla. </p>


            <table class="table table-sm mt-4 mb-4 text-center">
                <thead>
                    <tr>
                        <th>CILINDROS</th>
                        {{-- <th>U.M.</th> --}}
                        <th>GAS</th>
                        <th>TIPO</th>
                        <th>MATERIAL</th>
                        <th>CAPACIDAD</th>
                        <th>DEP. GAR.</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($tanques as $item)
                    <tr>
                        <td>{{$item->cilindros}}</td>
                        <td>{{$item->nombre}}</td> 
                        <td>{{$item->tipo_tanque}}</td>
                        <td>{{$item->material}}</td>
                        <td>{{$item->capacidad}} {{$item->unidad_medida}}</td>
                        <td>{{number_format($item->deposito_garantia, 2, '.', ',')}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="text-right">Total: </td>
                        <td>{{number_format($tanques->sum('deposito_garantia'), 2, '.', ',')}}</td>
                    </tr>
                    <tr>
                        <td>OBSERVACIONES: </td>
                        <td colspan="5"> {{$nota->observaciones}}</td>
                    </tr>
                </tbody>
            </table>

            <p><strong>OCTAVA:</strong> “EL ARRENDATARIO” deberá consignar el importe de garantía descrito en la tabla de la clausula septima, el cual podrá satisfacerse mediante tarjeta de crédito, tarjeta de débito, transferencia bancaria o en efectivo en el domicilio del establecimiento comercial denominado OXI NIK Gases Especiales, con domicilio en la calle Ignacio Zaragoza, número 213, letra “A”, en la Colonia Fernando Gómez Sandoval, del Municipio de Santa Lucia del Camino, Oaxaca c. p. 71243, cuyo justificante se adjuntará al presente contrato.</p>

            <ul style="list-style-type: lower-latin; ">
                <li>
                    Esta cantidad consignada será devuelta por el arrendador al final del período de alquiler, todo ello en un plazo no superior a 15 días y siempre después de la verificación sobre el estado de integridad del equipo alquilado. “EL ARRENDADOR” está obligado a mantener el dispositivo en condiciones óptimas de uso, al igual que “EL ARRENDATARIO” está obligado a dar un uso correcto al equipo arrendado, tal como se establece en el instructivo de uso correspondiente y entregado simultáneamente con el producto alquilado.
                </li>
            </ul>	

            <p><strong>NOVENA:</strong> La cantidad de envases suministrados podrá aumentar o disminuir de acuerdo con las necesidades del volumen del consumo de “EL ARRENDATARIO”, esta modificación se hará agregando el anexando del Formato de Aumento de Dotación ó Disminución de Cilindros.</p>

            <p><strong>DECIMA:</strong> La fecha de recepción y entrega del suministro de los cilindros o envases de diversos gases, ó dispositivos alquilados deben ser puestos a disposición de “EL ARRENDADOR”, el cual se hará cargo de la recepción y los costos de transporte relacionados por cada día de retraso por causa de “EL ARRENDATARIO” y respecto a la fecha de puesta a disposición acordada tendrá el costo de transporte a su cargo del ARRENDATARIO. </p>

            <ul style="list-style-type: lower-latin; ">
                <li>
                    “EL ARRENDATARIO” tiene derecho a dar por rescindido el presente contrato siempre que se cumpla con un preaviso de 7 días, el preaviso se ha de comunicar por escrito por medio de carta certificada, correo electrónico, WhatsApp, vía telefónica, o cualquier otro método que deje constancia fehaciente del desistimiento.
                </li>
            </ul>	

            <p><strong>DECIMA PRIMERA:</strong> “EL ARRENDATARIO” se obliga muy especialmente a hacer respetar los derechos de propiedad que tiene “EL ARRENDADOR” sobre los referidos envases suministrados, en el caso de que esos derechos pudieran verse lesionados como consecuencia de un embargo en los bienes de “EL ARRENDATARIO”, quien dará aviso inmediatamente a “EL ARRENDADOR” para retirar del domicilio de “EL ARRENDATARIO”, los suministros arrendados, con el objeto de recuperarlos, en caso contrario, se obliga a pagar el doble del importe de su valor tomando como referencia el costo en el mercado actual en el momento en el que ocurrió el hecho, en caso contrario el monto de los gastos legales que se tengan que devengar para la  recuperación de los suministros arrendados,  correrán a cargo de “EL ARRENDATARIO”, de todo el equipo alquilado, en el caso de huelga o si recibe envases defectuosos o deteriorados, dará aviso inmediatamente para retirarlos del domicilio “EL ARRENDATARIO”.</p>

            <p><strong>DECIMA SEGUNDA:</strong> Ambas partes están de acuerdo en que “EL ARRENDADOR” asentara el tipo y cantidad de envases en las notas de venta y/o de remisión y/o facturas, y en los demás documentos y formularios que expida. Así como en los libros y registros donde lleve cuenta y razón del movimiento de entregas y salidas de dichos envases, “EL ARRENDADOR” en cualquiera de los documentos anteriormente mencionados recabará la firma de “EL ARRENDATARIO” o en su defecto de alguno de los dependientes o empleados en el cual se entenderá que obra por cuenta y en representación de “EL ARRENDATARIO”.</p>

            <p><strong>DECIMA TERCERA:</strong> “EL ARRENDATARIO” solo deberá usar los suministros de gases en envases que le facilite “EL ARRENDADOR” para los fines ya indicados en el domicilio señalado en la primera plana de este Contrato, y tendrá obligación de dar aviso inmediatamente de cualquier cambio de domicilio o razón social; si transcurrió un lapso de diez días después de haber dado aviso “EL ARRENDADOR” no manifiesta su inconformidad, se entenderá que autoriza el cambio de domicilio dentro de la misma ciudad. La negativa injustificada de “EL ARRENDATARIO” dará derecho a “EL ARRENDADOR” a exigir el cumplimiento forzoso del Contrato o bien a optar por su rescisión.</p>
            <ul style="list-style-type: lower-latin; ">
                <li>
                    El derecho de rescindir el presente contrato de arrendamiento se podrá ejercitar por incumplimiento del contrato en cualquier momento; así mismo, “EL ARRENDATARIO” se compromete a devolver el producto en las mismas condiciones en las que se encontraba en el momento de su entrega, sin derecho a la devolución de las cantidades de dinero entregadas.
                </li>
            </ul>	

            <p><strong>DECIMA CUARTA:</strong> En el caso de falta de pago o incumplimiento de cualquiera de las obligaciones que se establecen en este contrato “EL ARRENDADOR” tendrá derecho a dar por concluido el contrato de alquiler y exigir la devolución de los suministros arrendados, todo ello con el cargo a “EL ARRENDATARIO” sobre el abono de los costos/indemnización que puedan haberse generado en virtud de la falta de pago o incumplimiento del contrato.</p>
            <p><strong>DECIMA QUINTA:</strong> Todas y cada una de las modificaciones que se deseen aplicar y que no estén dispuestas en el presente contrato, deberán ser realizadas por escrito, y anexadas con el numeral que corresponda. Del mismo modo deberán ser firmadas por ambas partes e incorporadas al presente contrato de no desarrollarse tales modificaciones conforme a lo dispuesto en el presente contrato, se tendrán por no puestas y serán entendidas como nulas de pleno derecho.</p>
            <p><strong>DECIMA SEXTA:</strong> El presente Contrato será forzoso para ambas partes por un término de un año,  dentro de los 30 días naturales anteriores a la conclusión del plazo, cualquiera de las partes podrá darlo por terminado por medio de un aviso proporcionado a la otra por escrito; de no recibir dicho aviso por algunas de las partes, se entenderá prorrogado el Contrato por un término igual al iniciar y después, continuara por tiempo indeterminado, termino dentro del cual cualquiera de las partes podrá darlo por terminado con un aviso dado por escrito con 180 días naturales de anticipación, en el entendido que de no dar aviso, las partes contratantes continuaran obligándose a todos los derechos y obligaciones inherentes de este contrato.</p>
            <p><strong>DECIMA SEPTIMA:</strong> Para garantía de lo estipulado en el presente Contrato lo firma solidariamente el Sr (a):
                <strong> {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</strong>
                con domicilio en:<strong> {{$cliente->direccion}}</strong>, 
                @if ($cliente->email != '') correo electrónico <span><strong>{{$cliente->email}}</strong></span> @endif y número telefónico  <strong>{{$cliente->telefono}} </strong>,  con el carácter de fiador solidario, así mismo bajo protesta de decir verdad manifiesta tener propiedades bastantes y suficientes para cumplir con  todas y cada una obligaciones contraídas por “El ARRENDATARIO”, en el presente contrato y firma solidariamente, y reconoce que no cesara su responsabilidad solidaria sino hasta que el “EL ARRENDADOR”, se dé por conforme de las prestaciones otorgadas
                </p>

            <p><strong>DECIMA OCTAVA:</strong> Para todo lo relativo a la interpretación y cumplimiento de este Contrato de Arrendamiento, las partes contratantes declaran su conformidad en someterse a los Tribunales del Fuero Común en esta ciudad de Oaxaca de Juárez, Oaxaca. Renunciando a cualquier otro fuero que pueda corresponderle en virtud de su nuevo domicilio actual ó futuro. La firma de este contrato no compromete a “EL ARRENDATARIO” a la compra de los cilindros a envases y/o sus accesorios ni la opción de compra del mismo.</p>
            
            @php
                $fechacontrato= $nota->fecha;
                $arrayFecha=explode("-", $fechacontrato);
                $mesingles=$arrayFecha[1];
                if($mesingles == '01') $mes='Enero';
                if($mesingles == '02') $mes='Febrero';
                if($mesingles == '03') $mes='Marzo';
                if($mesingles == '04') $mes='abril';
                if($mesingles == '05') $mes='Mayo';
                if($mesingles == '06') $mes='Junio';
                if($mesingles == '07') $mes='Julio';
                if($mesingles == '08') $mes='Agosto';
                if($mesingles == '09') $mes='Septiembre';
                if($mesingles == '10') $mes='Octubre';
                if($mesingles == '11') $mes='Noviembre';
                if($mesingles == '12') $mes='Diciembre';

                
                $fechaactual= $arrayFecha[2] . " de " . $mes . " de " . $arrayFecha[0];
                $fechaactual2 = $arrayFecha[2]." ".$mes." ".$arrayFecha[0];
            @endphp
            <p><strong>DECIMA NOVENA:</strong> Dicho contrato de arrendamiento fue firmado por voluntad de las partes, sin que existiera violencia, intimidación, error ó engaño. Una vez enteradas las partes del contenido y alcance legal del presente contrato de arrendamiento, manifestaron estar conformes con todas las cláusulas del presente y bien impuestos del valor y fuerza del mismo procedieron a la firma de su puño y letra. 
                En la ciudad de Oaxaca de Juárez, Oaxaca, a  {{$fechaactual}}.
            </p>

            <br>
            <br>
            <p class="text-center">"EL ARRENDADOR”.</p>
            <p class="text-center">________________________ <br>
                LIC. JUAN MANUEL CONTRERAS GÓMEZ <br>
                OXINIK GASES ESPECIALES
            </p>

            <br>
            <br>

            <p class="text-center">"EL ARRENDATARIO".</p>
            <p class="text-center">________________________ <br>
                {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</p>

            <br>
            <br>

            <p class="text-center">FIADOR SOLIDARIO</p>
            <p class="text-center">________________________</p>

            {{-- salto de pagina --}}
            <div class="page-break"></div>

            <br>
            <br>
            <br>
            <p class="text-center">RECIBO</p>
            <br>
            <br>
            <br>
            <p> EN LA CIUDAD DE OAXACA DE JUÁREZ, OAXACA, A  <span>{{$fechaactual2}}</span> </p>
            <br>
            <br>

            @php
                $precioFormat= number_format($tanques->sum('deposito_garantia'), 2, '.', ',')
            @endphp

            <p>RECIBI DEL C.{{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}} LA CANTIDAD DE ${{$precioFormat}} ({{$precioLetras}} 00/100 MONEDA NACIONAL), 
                COMO CONCEPTO DE DEPOSITO DE 
                @foreach ($tanques as $item)
                    <span>{{$item->cilindros}}</span> CILINDROS DE <span>{{$item->material}}</span> DE <span>{{$item->nombre}}</span> <span>{{$item->tipo_tanque}}</span>, 
                @endforeach
                PARA SU USO EN {{$contrato->direccion}}. 
            </p>
            <br>
            <br>
            <br>
            <p class="text-center">________________________ <br> 
                C. JUAN MANUEL CONTRERAS GÓMEZ <br> 
                OXINIK GASES ESPECIALES
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
        

    </body>

</html>