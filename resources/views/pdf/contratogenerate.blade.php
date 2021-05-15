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
                /* background-color: #46C66B; */
                /* color: white; */
                text-align: center;
                line-height: 35px;
                
                
            }
            
            body {
                margin: 3cm 2cm 2cm;
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

        <header>
            <table class="table table-borderless ">
                <tbody>
                    <td> <img src="img/logo.svg" style="width: 200px" alt=""></td></td>
                    <td class="mt-4 mr-3 text-right"> <img src="img/email.svg" style="height: 25px;" alt=""> </td>
                </tbody>
            </table> 
        </header>

        

        <main>
            <p class="text-right">Convenio: <strong>{{$contrato->num_contrato}}</strong></p>
            <h5 style="font-size: 20px; text-align: center">CONVENIO DE SUMINISTRO DE GAS Y COMODATO</h5>

            <p class="mt-4">Que celebran por una parte “EL PROVEEDOR” C. <strong>JUAN MANUEL CONTRERAS GOMEZ</strong> con domicilio, CALLE IGNACIO ZARAGOZA # 213 A, COLONIA FERNANDO GOMEZ SANDOVAL, SANTA LUCIA DEL CAMINO, OAXACA C.P. 71243, con nombre del establecimiento OXI.NIK GASES ESPECIALES y por la otra declara “EL CONSUMIDOR”, <span><strong>{{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</strong></span> con domicilio <span><strong>{{$cliente->direccion}}</strong></span> al tenor de las siguientes declaraciones y clausulas:</p>
 
            <p>DECLARA EL PROVEEDOR:</p>
            <p >
                <ul style="list-style-type: lower-latin; ">
                    <li style="">                
                        Que es una persona física, constituida conforme a las leyes de la República Mexicana el día 01 de junio de 2020, registrada ante la Secretaria de Hacienda y Crédito Público (SHCP), por parte Servicio de Administración Tributaria (SAT). Para ejercer como una empresa legal en el Estado Mexicano.
                    </li>
                    <li>Que su representante y propietario, responde a nombre de Juan Manuel Contreras Gómez, quien tiene capacidad suficiente para celebrar el presente contrato.</li>
                    <li>Que se dedica entre otras actividades a la venta y suministro de gases especiales (en lo sucesivo “EL PRODUCTO”) y que por lo tanto está en posibilidad de suministrarlos a “EL CONSUMIDOR”, de acuerdo con sus requerimientos.</li>
                    <li>Que es propietario de envases de diversos tipos y tamaños, de los cuales se sirve para vender los gases, estando en posibilidad de facilitarlos a sus clientes en forma temporal y en los términos que se especifican en el clausulado de este contrato.</li>
                </ul>
            </p>
            <p>DECLARA “EL CONSUMIDOR”:</p>
            <p>
                <ul style="list-style-type: lower-latin; ">
                    <li>Que tiene capacidad suficiente para celebrar el presente contrato.</li>
                    <li>Que requiere el suministro de los gases y de los envases, para uso en sus instalaciones ubicadas en la dirección registrada en este contrato que a continuación se detalla:
                        <strong>{{$contrato->direccion}}</strong>
                    </li>
                </ul>	
            </p>

            <p>DOMICILIO DEL CLIENTE </p>
            <p>En virtud de lo anterior las partes se otorgan en las siguientes:</p>
            <p>CLAUSULAS</p>
            <p>
                “EL PROVEEDOR” se obliga a suministrar a “EL CONSUMIDOR” los gases que comercializa y que este último requiera, durante la vigencia de este contrato siempre y cuando “EL CONSUMIDOR” se encuentre al corriente con todas las obligaciones adquiridas con “EL PROVEEDOR” a través de este contrato en CALLE IGNACIO ZARAGOZA # 213 A, COLONIA FERNANDO GOMEZ SANDOVAL, SANTA LUCIA DEL CAMINO, OAXACA C.P. 71243.
            </p>
            <p>
                “EL CONSUMIDOR” se obliga durante la vigencia de este Contrato a consumir de “EL PROVEEDOR” todos los gases que necesite y que “EL PROVEEDOR” comercializa.
            </p>

            <p>
                <ul style="list-style-type: upper-roman; ">
                    <li>El “CONSUMIDOR” solicitara, pedirá a “EL PROVEEDOR” los gases que necesite, por escrito mediante un mensaje de texto vía WhatsApp, mensaje de texto o llamada telefónica y “EL PROVEEDOR”, lo suministra dentro de un término de tres días como máximo, siempre y cuando “EL CONSUMIDOR” se encuentre al corriente en todas las obligaciones contraídas con  “EL PROVEEDOR”.“EL CONSUMIDOR” tendrá derecho a adquirirlos de cualquier otro proveedor para el caso  de que  el “EL PROVEEDOR”  NO SUMNISTRE  EL GAS  DENTRO DEL TÉRMINO DE TRES DÍAS.</li>
                    <li>Esta cláusula se refiere a circunstancias normales, es decir, cuando no exista caso fortuito o fuerza mayor. <br> Queda bien claro que el supuesto previsto en esta cláusula no podrá exceder de diez días hábiles. Si transcurre dicho plazo y “EL PROVEEDOR” no ha podido suministrar, “EL CONSUMIDOR” tendrá derecho a dar por terminado el presente contrato sin responsabilidad para él.</li>
                    <li>Ambas  partes convienen  en que no tendrán responsabilidad, si no por motivo de caso fortuito o de fuerza mayor, tales como terremotos, inundaciones, huelgas, paros, falta de suministro de energía eléctrica, motines, paros justificados de las plantas  productoras que suministren los gases a “EL PROVEEDOR”, etc.; ajenos a su voluntad no se encontraran en posibilidad de suministrar o de adquirir los Gases a que alude el presente contrato, encontrándose de acuerdo en que si por alguna de las causas mencionadas en el párrafo anterior  no les fuera posible a “EL PROVEEDOR” o a  “EL CONSUMIDOR” cumplir con el contrato, se suspenderán los efectos del mismo por el plazo que dure aquello. En el entendido de que, si el caso fortuito o de fuerza mayor excediera de 120 días, cualquiera de las partes podrá dar por terminado este contrato sin responsabilidad para ninguna de ellas.</li>
                    <li>Ambas partes convienen que los precios y los plazos para el pago de los gases suministrados por “EL PROVEEDOR” son los que aparecen en las facturas y/o notas de venta que se expidan y que comprueban el suministro objeto de este contrato, las que forman parte integrante del mismo como si se insertasen a la letra; todos los precios de los gases suministrados  bajo este Contrato, son libre abordo en las instalaciones de “EL PROVEEDOR”, cuando así lo solicite “EL PROVEEDOR” ejemplificativamente cuando los costos de adquisición, y/o distribución ,y/o de administración  se incrementen, incluyéndose de manera enunciativa la energía eléctrica, energéticos, mano de obra, materia prima, aumento en las tasas sobre financiamiento, aumento de precios en activos fijos y en general cualquier causa que justifique dicho aumento. <br>
                        El proveedor deberá avisar por medio de una circular que será entregada al área administrativa sobre el nuevo costo de los productos que comercialice la empresa con 15 días de anticipación antes de realizar dicho aumento. <br>
                        En el caso de que “EL CONSUMIDOR” optara por dar terminado el presente Contrato por incremento en los precios, “EL PROVEEDOR” dejara de hacer el suministro y retirara su equipo dentro del plazo de cinco días contados a partir de la fecha en que haya recibido la comunicación POR ESCRITO, de “EL CONSUMIDOR”, PARA CON EL PROVEEDOR. <br>
                        “EL CONSUMIDOR” se obliga a pagar a “EL PROVEEDOR” los gastos originados por la investigación y administración del crédito, por una sola vez y a la firma del presente Contrato.</li>
                    <li>El CONSUMIDOR podrá solicitar a el PROVEEDOR sus productos en los siguientes horarios de atención de lunes a viernes 08:00 a 18:00 hrs y los días sábados de 08:00 a 15:00 hrs a los siguientes números telefónicos 951 195 02 00 y 951 240 06 67. En caso que el PROVEEDOR no laborará en un día sea por disposición oficial, festivo o por cuestiones meramente administrativos dará aviso al CONSUMIDOR por medio de una circular con 15 días de anticipación. </li>
                </ul>
            </p>


            <p>COMODATO</p>
            <p>1.- Las partes manifiestan que es su deseo celebrar en forma, solidaria, conjunta el CONTRATO DE COMADATO   en el presente convenio AL TENOR DE LAS SIGUIENTES:</p>

            <p>CLAUSULAS.</p>
            <p style="text-indent: 30px;"> 
                PRIMERA. - “EL CONSUMIDOR” reconoce, tiene pleno conocimiento, que “EL PROVEEDOR” es el único y legítimo propietario de los envases que le presta, entrega cuya propiedad no podrá ser transmitida a “EL CONSUMIDOR”, por ningún concepto. ADEMAS SE SEÑALA COMO LUGAR   DE PAGO del presente contrato el ubicado en CALLE IGNACIO ZARAGOZA # 213 A, COLONIA FERNANDO GOMEZ SANDOVAL, SANTA LUCIA DEL CAMINO, OAXACA C.P. 71243, así mismo por medio de transferencia electrónica o de la manera convenida con el CONSUMIDOR. 
            </p>
            <p>
                Además, tendrá la obligación “EL CONSUMIDOR” de constituir un depósito en efectivo como garantía, que no representa de ninguna manera el precio de el o los envases que requiera del PROVEEDOR cantidades que estarán sujetas a la siguiente tabla. 
            </p>
            <p class="ml-4">
                Los depósitos a los que se refiere esta cláusula son los siguientes: un depósito en garantía de <strong>$5,000.00 (CINCO MIL pesos 00/100 m.n.)</strong>, por CADA UNO de los envases proporcionados al “CONSUMIDOR” 
            </p>
            <p class="ml-4">
                “EL CONSUMIDOR” tendrá derecho a recuperar la cantidad que haya entregado como depósito en los términos del art. 11 de la Ley Federal de Protección al Consumidor que a la letra dice: “El consumidor que al adquirir un bien haya entregado una cantidad como depósito por envase o empaque, tendrá derecho a recuperar en el momento de su devolución, la suma integra que haya erogado por ese concepto”.  Lo anterior operara siempre y cuando “EL CONSUMIDOR” se encuentre al corriente en el cumplimiento de sus obligaciones.
            </p>
            <p class="ml-4">
                Los envases los recibe “EL CONSUMIDOR” a su entera satisfacción; no obstante, este último “EL CONSUMIDOR” quedara liberado de cualquier responsabilidad en el caso de que existan vicios o defectos ocultos en los envases siguiendo todas las recomendaciones del “PROVEEDOR”, de carácter técnico, mismas que proporciona por escrito, y en este acto a “EL CONSUMIDOR”.
            </p>

            <table class="table table-sm mt-4 mb-4 text-center">
                <thead>
                    <tr>
                        <th>CILINDROS</th>
                        {{-- <th>U.M.</th> --}}
                        <th>GAS</th>
                        <th>TIPO</th>
                        <th>MATERIAL</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($tanques as $item)
                    <tr>
                        <td>{{$item->cilindros}}</td>
                        {{-- <td>{{$item->unidad_medida}}</td> --}}
                        <td>{{$item->nombre}}</td> {{--tipo gas --}}
                        <td>{{$item->tipo_tanque}}</td>
                        <td>{{$item->material}}</td>
                    </tr>
                    @endforeach

                    <tr><p>Observaciones: {{$nota->observaciones}}</p></tr>
                </tbody>
            </table>

            <p>Los envases que ampara el presente contrato, que se mencionan en el cuadro anterior, se encuentran documentados. </p>
            <p style="text-indent: 30px;">
                SEGUNDA. -  Cuando el consumidor extravié o deterioré alguno o algunos de los envases por negligencia leve, “EL PROVEEDOR” podrá exigir íntegramente su valor tomando como referencia el costo en el mercado actual. Si el deterioro ocurre por el uso normal de los envases, y sin culpa de “EL CONSUMIDOR”, este no será responsable de dicho deterioro.
            </p>
            <p>
                Queda bien claro que la cantidad de envases podrá aumentar o disminuir de acuerdo con las necesidades del volumen de consumo de “EL CONSUMIDOR” siempre dentro de los lineamientos de este Contrato, este se hará anexando EL FORMATO DE AUMENTO DE DOTACIÓN O DISMINUCIÓN DE CILINDROS a su CONVENIDIO DEL CONSUMIDOR.
            </p>
            <p style="text-indent: 30px;">
                TERCERA-.  Por cada compra de gases “EL PROVEEDOR” facilitara a “EL CONSUMIDOR” los envases necesarios, si este excediera el número de cilindros establecidos en este contrato en un plazo no mayor a 30      días de conformidad, si transcurrido el plazo anterior, “EL CONSUMIDOR” no devolviera el o los envases facilitados y consecuentemente optare por conservarlos en su poder.
            </p>
            <p>
                “EL PROVEEDOR” tendrá derecho exigir a “EL CONSUMIDOR” la devolución de los envases de su propiedad antes de concluido el plazo indicado si “EL CONSUMIDOR” da a que se le rescinda el contrato.
            </p>
            <p style="text-indent: 30px;">
                CUARTA. Si ocurre cualquiera de los supuestos previstos en las dos Clausulas anteriores, “EL PROVEEDOR” reintegrara a “EL CONSUMIDOR” el importe de los gases no consumidos (sellados), cuyo costo será calculado al mismo precio que el consumidor haya pagado, salvo que este adeude alguna cantidad; en tal supuesto se hará la compensación respectiva, además de cubrir ·EL CONSUMIDOR” en su caso, la diferencia a su cargo si la hubiere.
            </p>
            <p style="text-indent: 30px;">
                QUINTA. - “EL CONSUMIDOR” no podrá por derecho propio ceder o transferir a terceros los Derechos consignados en este Contrato, sin la autorización fehaciente y de manera ESCRITA de “EL PROVEEDOR”, quedando prohibido que el “EL CONSUMIDOR” rellene dichos envases por su cuenta o por alguna otra empresa. Reiteramos las partes están de acuerdo en que los envases no pueden, no deben ser   rellenados por ninguna empresa, persona física, distinta a “EL PROVEEDOR”, para el caso   de que se viola esta disposición pagara en forma íntegra   el   gas rellenado a el proveedor.
            </p>
            <p style="text-indent: 30px;">
                SEXTA. - “EL CONSUMIDOR” está obligado a conservar en buen estado de uso los envases, por lo que los gastos de mantenimiento por un importe de $200.00 por cada envase serán a su cargo, si el consumidor no realizara en un máximo de 6 meses una compra por cada envase, “EL PROVEEDOR” dará por cancelada el contrato, y “EL CONSUMIDOR” deberá hacer la devolución de los cilindros que tenga a su cargo.
            </p>

            <p style="text-indent: 30px;">
                SEPTIMA. - “EL CONSUMIDOR” se obliga muy especialmente a hacer respetar los derechos de propiedad que tiene “EL PROVEEDOR” sobre los referidos envases. En caso de que esos derechos pudieran verse lesionados como consecuencia de un embargo efectuado en los bienes de “EL CONSUMIDOR”, de una huelga, o si los recibe “EL PROVEEDOR” deteriorados o con demora considerable cuando ello ocurra por causa imputable a “EL CONSUMIDOR”, el monto de los gastos legales que haya efectuado “EL PROVEEDOR”, con objeto de recuperarlos, serán cubiertos totalmente por “EL CONSUMIDOR”, previo a su acreditamiento.
            </p>
            <p style="text-indent: 30px;">
                OCTAVA. En virtud de que se entregara  a “EL CONSUMIDOR”, envase en cantidad adecuada a sus necesidades de consumo de gases, conforme a lo establecido en la Cláusula Primera, ambas partes convierten en que “EL PROVEEDOR” asentara el tipo y cantidad de los envases en las notas de venta  y/o de remisión  y/o facturas que se amparan los gases que le suministre a “EL CONSUMIDOR”, y/o en los demás documentos y formularios que se expida el mismo, así como en los libros y registros donde lleve cuenta y razón del movimiento de entregas y salidas de dichos envases. “EL PROVEEDOR” en cualquiera de los documentos anteriormente mencionados, recabará la firma de “EL CONSUMIDOR” o en su defecto de alguno de los factores o dependientes o empleados en el cual se entenderá que obra por cuenta y en representación de “EL CONSUMIDOR” en términos de los art. 309 y 310 del código de comercio.
            </p>
            <p>
                Ambos contratantes convienen expresadamente en que los documentos firmados por “EL CONSUMIDOR” o sus factores o dependientes o empleados, así como los demás comprobantes, libros o registro de “EL PROVEEDOR”, en donde se anote el movimiento de sus envases, formaran parte integrante de este contrato y consistirán una evidencia para determinar en cualquier momento, cuáles son los envases que tiene en su poder “EL CONSUMIDOR” pendientes de devolver a “EL PROVEEDOR”, de acuerdo con los términos y sujetos a las obligaciones y responsabilidades que establece este Contrato.
            </p>
            <p style="text-indent: 30px;">
                NOVENA.  “EL CONSUMIDOR” solo deberá usar los envases que le facilite “EL PROVEEDOR” para los fines ya indicados en el domicilio señalado en la primera plana de este Contrato y tendrá obligación de notificar fehacientemente cualquier cambio de domicilio o razón social; si transcurrió un lapso de diez días después de hecha la notificación “EL PROVEEDOR” no manifiesta su inconformidad, se entenderá que autoriza el cambio de domicilio dentro de la misma ciudad. La negativa injustificada de “EL PROVEEDOR” dará derecho a “EL CONSUMIDOR” a exigir el cumplimiento forzoso del Contrato o bien a optar por su rescisión.
            </p>

            <p>DISPOSICIONES COMUNES AL SUMINISTRO Y COMODATO</p>
            <p style="text-indent: 30px;">
                DECIMA. En el caso de terminación o violación de este Contrato no cesarán las obligaciones y responsabilidades que hayan contraído las partes por el término de su vigencia, sino hasta que “EL PROVEEDOR” se dé por recibido a su entera satisfacción de los envases facilitados y de todas las prestaciones estipuladas a su favor, asimismo no cesarán las obligaciones y responsabilidades de “EL PROVEEDOR” hasta que cumpla con las mismas.
            </p>
            <p class="ml-3" style="text-indent: 30px;">
                DECIMA PRIMERA. En caso de violación de cualquiera de las cláusulas del presente Contrato, por alguna de las partes, dará lugar a que la parte que si cumplió exija de la otra el cumplimiento forzoso o la rescisión, debiendo pagarse en ambos casos los daños y perjuicios que se originen conforme a la pena convencional establecida en la cláusula siguiente.
            </p>
            <p class="ml-3" style="text-indent: 30px;">
                DECIMA SEGUNDA.  En el caso de que “EL CONSUMIDOR” viole su obligación contenida en las cláusulas I Y II del CONVENIO DE SUMINISTRO DE GAS Y COMODATO que necesite, por parte de otra persona física o jurídica, ya sea en los envases de “EL PROVEEDOR” o en  envases propiedad de esa otra persona”; igualmente en caso de la no devolución  de los envases por parte de “EL CONSUMIDOR” a “EL PROVEEDOR”  en los plazos fijados y, en caso de la transición del uso de los envases por  parte de “EL CONSUMIDOR” a terceras personas, dará lugar a que “ EL PROVEEDOR” le exija el cumplimiento forzoso o le rescinda el contrato; debiendo pagar en dichos casos los daños y perjuicios que causare al “EL PROVEEDOR”.
            </p>
            <p>
                En caso de que el incumplimiento en el suministro del producto sea imputable a “EL PROVEEDOR” y no hubiere causa justificada para ello, pagara a “EL CONSUMIDOR”, los daños y perjuicios que causare.
            </p>
            <p class="ml-3" style="text-indent: 30px;">
                DECIMA TERCERA. El presente Contrato será forzoso para ambas partes por un término de un año. Dentro de los 30 días naturales anteriores a la conclusión del plazo, cualquiera de las partes podrá darlo por terminado por medio de un aviso proporcionado a la otra por escrito; de no recibir dicho aviso por algunas de las partes, se entenderá prorrogado el Contrato por un término igual al iniciar y después, continuara por tiempo indefinido, termino dentro del cual cualquiera de las partes podrá darlo por terminado con un aviso dado por escrito con 180 días naturales de anticipación, en el entendido que de no dar aviso, las partes contratantes continuaran obligándose a todos los derechos y obligaciones inherentes de este contrato.
            </p>
            <p class="ml-3" style="text-indent: 30px;">
                DECIMA CUARTA “EL PROVEEDOR” durante la vigencia de este contrato podrá hacer Cesión del mismo a otro proveedor obligándose solidaria y mancomunadamente con aquel al fiel cumplimiento del presente Contrato en todos sus términos.
            </p>
            <p class="ml-3" style="text-indent: 30px;">
                DECIMA QUINTA. Para garantía de lo estipulado en el presente Contrato en términos del artículo 2794 del código civil, lo firma solidariamente con “EL CONSUMIDOR” y el en carácter de fiador, quien en este acto renuncia en forma expresa a todos los beneficios de orden y exclusión que consignan los artículos 2814, 2815 y 2817 y demás relativos del Código Civil vigente en la Ciudad de México y correlativos de su domicilio.
            </p>
            <p>
                Asimismo, declarara ser propietario de bienes suficientes para garantizar el cumplimiento de sus obligaciones, entre los que se encuentra el identificado con el número
            </p>
            <p>
                El fiador se obliga solidaria y mancomunadamente con “EL CONSUMIDOR”, garantizado de esta manera el exacto cumplimiento de todas y cada una de las obligaciones contraídas por el mismo, de acuerdo con los términos de este Contrato.  Convierte el fiador igualmente en que no cesara su responsabilidad sino hasta el momento en que “EL PROVEEDOR” se dé por recibido de todas y cada uno de los envases que haya facilitado a “EL CONSUMIDOR” y de todo cuanto este le deba en virtud de este Contrato, renunciando de igual manera a los beneficios y derechos consignados en los artículos 2846, 2847, 2848, 2849 y además relativo del Código Civil. 
            </p>
            <p class="ml-3" style="text-indent: 30px;">
                DECIMA SEXTA. Para todo lo relativo para la interpretación y cumplimiento del presente Contrato, las partes se someten a la jurisdicción de los tribunales competentes de la ciudad de OAXACA DE JUAREZ, OAX.
            </p>
            <p>
                Renunciando desde luego a cualquier otro fuero que por razón de sus domicilios presentes o futuros o cualquier otra causa pudiera corresponderles, sin perjuicio de la competencia que en derecho le corresponde a la Procuraduría Federal del consumidor.
            </p>
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

                
                $fechaactual= "a los ".$arrayFecha[2] . " dias de " . $mes . " de " . $arrayFecha[0];
                $fechaactual2 = $arrayFecha[2]." ".$mes." ".$arrayFecha[0];
            @endphp
            <p class="ml-3" style="text-indent: 30px;">
                DECIMA SEPTIMA. -  Las partes contratantes, aceptadas en todos sus términos el Contrato con las cláusulas transcritas que preceden. Enteradas las partes de alcance y fuerza legal de todas y cada una de las estipulaciones que se contienen en este Contrato, lo firma en la ciudad de OAXACA DE JUAREZ, OAX.  <strong>{{$fechaactual}}</strong>.
            </p>


            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="text-center"><p><strong>EL CONSUMIDOR</strong> <br> {{$contrato->empresa}}</p></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-center"><p> __________________________ <br> {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}</p></td>
                        <td class="text-center"><p> __________________________ <br> Testigo Solidario</p></td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="2">CORREO ELECTRONICO: <u>{{$cliente->email}}</u></td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="2"> NÚM. TEL. DEL CONSUMIDOR: &nbsp; &nbsp; &nbsp; 1ro: <u>{{$cliente->telefono}} </u>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2do: <u>{{$cliente->telefonorespaldo}}</u></td>
                    </tr>
                    <tr>
                        <td class="text-center"><p><strong>EL PROVEEDOR <br> OXI.NIK GASES ESPECILAES </strong></p>
                        </td>
                        <td></td>
                    </tr>
                    <tr class="text-center">
                        <td> __________________________ <br> Lic. Juan Manuel Contreras Gómez</td>
                        <td> __________________________ <br> Testigo solidario</td>
                    </tr>
                </tbody>
            </table>
        
            <div class="page-break"></div>

            <p class="text-right"> OAXACA DE JUÁREZ, OAX. A <span>{{$fechaactual2}}</span> </p>
            <p class="text-right"> DEPOSITO DE CILINDROS </p>

            @php
                $precioFormat= number_format($contrato->deposito_garantia, 2, '.', ',')
            @endphp
            <p style="margin-top: 6rem; margin-bottom: 6rem">RECIBÍ DE <span>{{$contrato->empresa}}</span>
                LA CANTIDAD DE {{$precioFormat}} ( <span>{{$precioLetras}}</span> PESOS 00/100 MN) 
                POR CONCEPTO DE DEPOSITO DE 
                @foreach ($tanques as $item)
                    <span>{{$item->cilindros}}</span> CILINDROS DE <span>{{$item->material}}</span> DE <span>{{$item->nombre}}</span> <span>{{$item->tipo_tanque}}</span>, 
                @endforeach
                PARA SU USO EN {{$contrato->direccion}}. 
            </p>

            <table class="table mt-4 text-center table-borderless" >
                <tbody>
                    <tr>
                        <td>_____________________</td>
                        <td>_____________________</td>
                    </tr>
                    <tr>
                        <td>RECIBE</td>
                        <td>ENTREGA</td>
                    </tr>
                </tbody>
            </table>



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
            <img src="img/membrete_footer.svg" style="width: 650px" alt="">
        </footer>
        

    </body>

</html>