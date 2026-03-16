<!DOCTYPE html>
<html lang="es">

<head>
  <title>Contrato General</title>
  <meta charset="UTF-8"/>
    <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  /* 1. Configuración de Página */
  @page {
    margin: 3.5cm 1.5cm 2.9cm 2.3cm;
    size: letter;
  }

  /* 2. Estilo Global (Tipo de texto e Interlineado) */
  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 11pt;
    line-height: 1.4; /* Interlineado general */
    margin: 0;
    padding: 0;
    color: #000;
  }

  /* 3. Membrete y Fondo */
  .background-image {
    position: fixed;
    top: -3.5cm; 
    left: -1cm;  
    width: 21.59cm; 
    height: 27.94cm; 
    z-index: -1000;
  }

  /* 4. Encabezados (Heredan la fuente del body, solo cambian tamaño/peso) */
  h1 {
    text-align: center;
    margin: 0 0 12pt 0;
    font-size: 14pt;
    font-weight: bold;
    line-height: 1.2; /* Un poco más cerrado para títulos largos */
  }

  h2 {
    text-align: center;
    margin: 0 0 5pt 0;
    font-size: 12pt;
    font-weight: bold;
  }

  h4, h5 {
    text-align: center;
    margin: 6pt 0;
    font-weight: bold;
  }

  /* 5. Párrafos */
  p {
    margin: 0 0 12pt 0; /* Margen inferior para separar párrafos */
    text-align: justify;
    /* El interlineado lo hereda del body */
  }

  /* 6. Tablas (Importante: forzar fuente aquí también) */
  table {
    width: 100%;
    border-collapse: collapse;
    font-family: "Times New Roman", Times, serif;
    font-size: 11pt; /* A veces las tablas requieren letra un poco más pequeña */
    margin-bottom: 15pt;
  }

  .header-info td, .header-info th {
    border: 1px solid black;
    padding: 5px;
  }

  /* 7. Utilidades */
  .page-break {
    page-break-before: always;
  }

  .center-text {
    text-align: center;
  }

  .uppercase {
    text-transform: uppercase;
  }
</style>
  
</head>

<body class="page-bg">
<img src="{{ public_path('img/oxigamex/membrete_carta.jpg') }}" class="background-image">
  <h1>CONTRATO DE COMODATO</h1>
  <main>
    <p>
      Que celebran por una parte la C. Virginia García López, a quien en lo subsecuente será denominará como “LA PROVEEDORA”, con domicilio ubicado en la calle Ignacio Zaragoza, número 213, Interior 4, Colonia Fernando Gómez Sandoval, Santa Lucia Del Camino, Oaxaca, C.P. 71243, con nombre del establecimiento OXIGAMEX OXIGENO GASES ACCESORIOS. Y por la otra parte el C. {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}} a quien en lo subsecuente se le denominara como “EL CONSUMIDOR”, con domicilio {{$cliente->direccion}} al tenor de las siguientes declaraciones y clausulas: 
    </p>
    <h2>DECLARACIONES.</h2>
    <p>
      DECLARA “LA PROVEEDORA”:
    </p>
    <p>
      a). “LA PROVEEDORA” Virginia García López, cuenta con la capacidad y personalidad para celebrar el presente contrato, persona física sin personalidad jurídica, constituida conforme a las leyes de la República Mexicana el día primero de agosto de dos mil veintitrés, registrada ante la Secretaria de Hacienda y Crédito Público (SHCP), por parte Servicio de Administración Tributaria (SAT), para ejercer como persona física empresa legal en la República Mexicana, dedicada a la venta y suministro de gases especiales, propietaria de envases ó cilindros de diversos tipos y tamaños, los cuales sirven para vender los gases especiales, como lo especifica en el clausulado de este contrato. 
    <p>

    <p>DECLARA “EL CONSUMIDOR”: </p>

    <p>
      b). Que tiene capacidad y la personalidad para celebrar el presente contrato de comodato y requiere el suministro de los gases y de envases o cilindros, para uso en las instalaciones establecidas en la dirección {{$contrato->direccion}} con nombre {{$contrato->nombre_comercial}}, y así mismo, manifiesta que ha cumplido con todos y cada uno de los requisitos establecidos en el Anexo 1.
    </p>

    <p>
      En atención de lo anterior las partes se comprometen y manifiestan que es su voluntad expresa en celebrar el CONTRATO DE COMODATO en el presente convenio al tenor de las siguientes: 
    </p>

    <h2>CLÁUSULAS.</h2>

    <p>
      PRIMERA. - “EL CONSUMIDOR” reconoce y tiene pleno conocimiento que “LA PROVEEDORA” es la única y legítima propietaria de los envases que le presta y entrega para su uso, cuya propiedad en ningún momento podrá ser transmitida a “EL CONSUMIDOR”, por ningún concepto; se señala como lugar de pago del presente contrato el domicilio ubicado en calle  Ignacio Zaragoza, número 213, interior 4, Colonia Fernando Gómez Sandoval, Santa Lucia Del Camino, Oaxaca C.P. 71243, también se recibe el pago por medio de transferencias electrónicas ó de la manera que se convenga con “EL CONSUMIDOR”. 
    </p>
    
    <p>
      Además de lo antes estipulado, tendrá la obligación “EL CONSUMIDOR” de entregar un depósito en efectivo como garantía, que no representa de ninguna manera el precio del o de los envases que requiera de “LA PROVEEDORA”, cantidad de dinero que estará sujeta de la forma siguiente: 
    </p>
    <p>
      Los depósitos que se refiere esta cláusula son los siguientes: un depósito en garantía de<strong> $ {{number_format($tanques->sum('deposito_garantia'), 2, '.', ',')}} {{$precioLetras}} </strong>, por CADA UNO de los envases proporcionados al “CONSUMIDOR” 
    </p>
    <p>
      “EL CONSUMIDOR” tendrá derecho a recuperar la cantidad que haya entregado como depósito en garantía en los términos del artículo 11 de la Ley Federal de Protección al Consumidor que a la letra dice: “El consumidor que al adquirir un bien haya entregado una cantidad como depósito por envase o empaque, tendrá derecho a recuperar en el momento de su devolución, la suma integra que haya erogado por ese concepto”. Lo anterior operara siempre y cuando “EL CONSUMIDOR” se encuentre al corriente en el cumplimiento de sus obligaciones.
    </p>
    <p>
      Los envases los recibe “EL CONSUMIDOR” a su entera satisfacción; no obstante, este último “EL CONSUMIDOR” quedara liberado de cualquier responsabilidad en el caso de que existan vicios o defectos ocultos en los envases, siempre y cuando “EL CONSUMIDOR” haya seguido todas y cada una de las recomendaciones de “LA PROVEEDORA”, de carácter técnico, mismas que proporciona por escrito, y en este acto a “EL CONSUMIDOR”. Anexo 5 
    </p>

    <table class="table table-sm mt-4 mb-4 text-center">
      <thead>
          <tr>
              <th>DESCRIPCION</th>
              <th>CLASE DE GAS</th>
              <th>CANTIDAD</th>
          </tr>
      </thead>
      <tbody style="text-transform: uppercase;">
        @foreach ($tanques as $item)
          <tr>
            <td>{{$item->material}}</td>
            <td>{{$item->nombre}} {{$item->tipo_tanque}} {{$item->capacidad}} {{$item->unidad_medida}}</td>
            <td>{{$item->cilindros}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <p>
      Los envases que amparan el presente contrato y que se mencionan en el cuadro anterior, se encuentran documentados. 
    </p>
    <p>
    SEGUNDA. -  Cuando el consumidor extravié o deterioré alguno o algunos de los envases por negligencia leve “LA PROVEEDORA” podrá exigir íntegramente su valor, tomando como referencia el costo en el mercado actual. Si el deterioro ocurre por el uso normal de los envases, y sin culpa de “EL CONSUMIDOR”, este no será responsable de dicho deterioro. 
    </p>
    <p>
    Las partes convienen y acuerdan que la cantidad de envases podrán aumentar o disminuir de acuerdo con las necesidades del volumen de consumo de “EL CONSUMIDOR” siempre dentro de los lineamientos de este Contrato, este se hará anexando EL FORMATO DE AUMENTO DE DOTACIÓN O DISMINUCIÓN DE CILINDROS a convenio DEL CONSUMIDOR. Anexo 4 
    </p>
    <p>
    TERCERA-.  Si “EL CONSUMIDOR” solicita más envases ó cilindros para la compra de gases a “LA PROVEEDORA”, esta facilitara a “EL CONSUMIDOR” los envases que necesite de suministro; si esta necesidad de más envases excediera el número de cilindros establecidos en este contrato convienen las partes que en un plazo no mayor a 30 días de conformidad entregara los envases excedidos, si transcurrido el plazo anterior “EL CONSUMIDOR” no devolviera el o los envases de más facilitados y consecuentemente optare por conservarlos en su poder “LA PROVEEDORA” tendrá derecho exigir a “EL CONSUMIDOR” la devolución de los envases de su propiedad antes de concluido el plazo indicado si “EL CONSUMIDOR” da una causa de que se le rescinda el contrato. 
    </p>
    <p>
    CUARTA. - Si ocurre cualquiera de los supuestos previstos en las dos Clausulas anteriores “LA PROVEEDORA” reintegrara a “EL CONSUMIDOR” el importe de los gases no consumidos (sellados), cuyo costo será calculado al mismo precio que el consumidor haya pagado, salvo que este adeude alguna cantidad; en tal supuesto se hará la compensación respectiva, además de cubrir ·EL CONSUMIDOR” en su caso, la diferencia a su cargo si la hubiere. 
    </p>
    <p>
      QUINTA. - “EL CONSUMIDOR” no podrá por derecho propio ceder o transferir a terceros los Derechos consignados en este Contrato, sin la autorización fehaciente y de manera ESCRITA de “LA PROVEEDORA”, quedando prohibido que el “EL CONSUMIDOR” rellene dichos envases por su cuenta o por alguna otra empresa. Reiteramos las partes están de acuerdo en que los envases no pueden, no deben ser rellenados por ninguna otra empresa, persona física, distinta a “LA PROVEEDORA” para el caso de que se viola esta disposición pagara en forma íntegra el gas rellenado a “LA PROVEEDORA”. 
    </p>
    <p>
      SEXTA. - “EL CONSUMIDOR” está obligado a conservar en buen estado de uso los envases, por lo que los gastos de mantenimiento por un importe de $200.00 por cada envase serán a su cargo, si el consumidor no realizara en un máximo de 4 meses una compra por cada envase, “LA PROVEEDORA” dará por cancelada el contrato y “EL CONSUMIDOR” deberá hacer la devolución de los cilindros que tenga a su cargo. 
    </p>
    <p>
      SÉPTIMA. - “EL CONSUMIDOR” se obliga muy especialmente a hacer respetar los derechos de propiedad que tiene “LA PROVEEDORA” sobre los referidos envases. En caso de que esos derechos pudieran verse lesionados como consecuencia de un embargo efectuado en los bienes de “EL CONSUMIDOR”, de una huelga, o si los recibe “LA PROVEEDORA” deteriorados o con demora considerable cuando ello ocurra por causa imputable a “EL CONSUMIDOR” el monto de los gastos legales que haya efectuado “LA PROVEEDORA”, con objeto de recuperarlos, serán cubiertos totalmente por “EL CONSUMIDOR”, previo a su acreditamiento. 
    </p>
    <p>
      OCTAVA.- En virtud de que se entregara a “EL CONSUMIDOR” envases ó cilindros en cantidad adecuada a sus necesidades del consumo de gases conforme a lo establecido en la Cláusula Primera, ambas partes convierten en que “LA PROVEEDORA” asentara el tipo y cantidad de los envases ó cilindros, en las notas de venta  y/o de remisión  y/o facturas con las que se amparan los gases que le suministre a “EL CONSUMIDOR” y/o en los demás documentos y formularios que se expida al mismo; así como en los libros y registros donde lleve cuenta y razón del movimiento de entregas y salidas de dichos envases. “LA PROVEEDORA” en cualquiera de los documentos anteriormente mencionados, recabará la firma de “EL CONSUMIDOR” o en su defecto de alguno de los factores o dependientes o empleados en el cual se entenderá que obra por cuenta y en representación de “EL CONSUMIDOR” en términos de los art. 309 y 310 del Código de Comercio. 
    </p>
    <p>
      Convienen las partes que “EL CONSUMIDOR” autorizara a dos de sus empleados, los cuales firmaran las notas de recepción en su nombre y representación de ” EL CONSUMIDOR” al momento de recibirlos en sus instalaciones los insumos solicitados por “EL CONSUMIDOR”; así mismo, autorizara a dos de sus empleados para firmar en nombre y representación de “EL CONSUMIDOR” cuando exista la necesidad de realizar el aumentos o la disminución de cilindros o equipos  dentro de las instalaciones del uso de los gases solicitados. Anexo 2 y 3. 
    </p>
    <p>
      Ambos contratantes convienen expresadamente en que los documentos firmados por “EL CONSUMIDOR” o sus factores o dependientes o empleados; así como, los demás comprobantes, libros o registro de “LA PROVEEDORA”, en donde se anote el movimiento de sus envases, formaran parte integrante de este contrato y consistirán una evidencia para determinar en cualquier momento, cuáles son los envases que tiene en su poder “EL CONSUMIDOR” pendientes de devolver a “LA PROVEEDORA”, de acuerdo con los términos y sujetos a las obligaciones y responsabilidades que establece este Contrato. 
    </p>
    <p>
      NOVENA. - “EL CONSUMIDOR” solo deberá usar los envases que le facilite “LA PROVEEDORA” para los fines ya indicados en el domicilio señalado en la primera plana de este Contrato y tendrá obligación de notificar fehacientemente cualquier cambio de domicilio o razón social; si transcurrió un lapso de diez días después de hecha la notificación “LA PROVEEDORA” no manifiesta su inconformidad, se entenderá que autoriza el cambio de domicilio dentro de la misma ciudad. La negativa injustificada de “LA PROVEEDORA” dará derecho a “EL CONSUMIDOR” a exigir el cumplimiento forzoso del Contrato o bien a optar por su rescisión. 
    </p>
    <p>
      DECIMA. - En el caso de terminación o violación de este Contrato no cesarán las obligaciones y responsabilidades que hayan contraído las partes por el término de su vigencia, sino hasta que “LA PROVEEDORA” se dé por recibida a su entera satisfacción de los envases ó cilindros facilitados y de todas las prestaciones estipuladas a su favor; así mismo, no cesarán las obligaciones y responsabilidades de “LA PROVEEDORA” hasta que cumpla con las mismas. 
    </p>
    <p>
      DECIMA PRIMERA. - En caso de violación de cualquiera de las cláusulas del presente Contrato por alguna de las partes dará lugar a que la parte que si cumplió exija de la otra el cumplimiento forzoso o la rescisión, debiendo pagarse en ambos casos los daños y perjuicios que se originen conforme a la pena convencional establecida en la cláusula siguiente. 
    </p>
    <p>
      DECIMA SEGUNDA.-  En el caso de que “EL CONSUMIDOR” viole su obligación contenida en las cláusulas PRIMERA y SEGUNDA del presente CONVENIO DE COMODATO, por la necesidad del uso de gas, le sea suministrado  por parte de otra persona física o jurídica, ya sea en los envases de “LA PROVEEDORA” o en  envases propiedad de esa otra persona” igualmente en caso de la no devolución de los envases ó cilindros  por parte de “EL CONSUMIDOR” a “LA PROVEEDORA” en los plazos fijados y, en caso de la transición del uso de los envases por  parte de “EL CONSUMIDOR” a terceras personas, dará lugar a que “ LA PROVEEDORA” le exija el cumplimiento forzoso o le rescinda el contrato; debiendo pagar en dichos casos los daños y perjuicios que causare a “LA PROVEEDORA”. 
    </p>
    <p>
    En caso de que el incumplimiento en el suministro del producto sea imputable a “LA PROVEEDORA” y no hubiere causa justificada para ello, pagara a “EL CONSUMIDOR”, los daños y perjuicios que causare. 
    </p>
    <p>
      DECIMA TERCERA. - El presente Contrato será forzoso para ambas partes por un término de un año. Dentro de los 30 días naturales anteriores a la conclusión del plazo, cualquiera de las partes podrá darlo por terminado por medio de un aviso proporcionado a la otra por escrito; de no recibir dicho aviso por algunas de las partes, se entenderá prorrogado el Contrato por un término igual al iniciar y después, continuara por tiempo indefinido, termino dentro del cual cualquiera de las partes podrá darlo por terminado con un aviso dado por escrito con 180 días naturales de anticipación, en el entendido que de no dar aviso, las partes contratantes continuaran obligándose a todos los derechos y obligaciones inherentes de este contrato. 
    </p>
    <p>
      DECIMA CUARTA. - “LA PROVEEDORA” durante la vigencia de este contrato podrá hacer Cesión del mismo a otro proveedor obligándose solidaria y mancomunadamente con aquel al fiel cumplimiento del presente Contrato de comodato en todos sus términos. 
    </p>
    <p>
      DECIMA QUINTA.- Para garantía de lo estipulado en el presente Contrato de comodato en términos del artículo 2794 del Código Civil, conjuntamente con “EL CONSUMIDOR” firma el presente contrato de comodato solidariamente en calidad de testigo y con él en carácter de fiador, el señor {{$contrato->nombre_solidaria}}, quien en este acto renuncia en forma expresa a todos los beneficios de orden y exclusión que consignan los artículos 2814, 2815 y 2817 y demás relativos del Código Civil vigente en la Ciudad de México, y correlativos de su domicilio. 
    </p>
    <p>
      El fiador y testigo el señor {{$contrato->nombre_solidaria}}, quien en este acto se obliga solidaria y mancomunadamente con “EL CONSUMIDOR”, garantizado de esta manera el exacto cumplimiento de todas y cada una de las obligaciones contraídas por el “EL CONSUMIDOR”, de acuerdo con los términos de este Contrato, comprendiendo el fiador en que no cesara su responsabilidad, sino hasta el momento en que “LA PROVEEDORA” se dé por recibido de todas y cada uno de los envases o cilindros que haya facilitado a “EL CONSUMIDOR” y de todo cuanto este le deba de dinero, en virtud de este Contrato, renunciando de igual manera a los beneficios y derechos consignados en los artículos 2846, 2847, 2848, 2849 y además relativo del Código Civil.  
    </p>
    <p>
      DECIMA SEXTA. - Para todo lo relativo para la interpretación y cumplimiento del presente Contrato las partes se someten a la jurisdicción de los tribunales competentes de la ciudad de Oaxaca de Juárez, Oaxaca, renunciando desde luego a cualquier otro fuero que por razón de sus domicilios presentes o futuros o cualquier otra causa pudiera corresponderles, sin perjuicio de la competencia que en derecho le corresponde a la Procuraduría Federal del Consumidor. 
    </p>
    <p>
      DECIMA SÉPTIMA. -  Las partes contratantes y el fiador aceptan en todos sus términos el presente Contrato de Comodato con las cláusulas transcritas que preceden. Enteradas las partes de alcance y fuerza legal de todas y cada una de las estipulaciones que se contienen en este Contrato, lo firman en la ciudad de Oaxaca de Juárez, Oaxaca, a los {{$date}}. 
    </p>

    <p class="center-text mt-5">
      “EL CONSUMIDOR”
    </p>
    <p class="center-text" style="margin-top: 2rem;">
      ____________________________ <br>
      C. {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}
    </p>

    <p class="center-text mt-5" style="text-transform: uppercase;">
      ____________________________ <br>
      C. {{$contrato->nombre_solidaria}} <br>
      FIADOR Y TESTIGO SOLIDARIO
    </p>
    



    <p class="center-text mt-5">
      “LA PROVEEDORA”
    </p>
    <p class="center-text" style="margin-top: 2rem;">
      ____________________________ <br>
      C. VIRGINIA GARCÍA LÓPEZ.<br/>
      PROPIETARIA DE OXIGAMEX.<br/>
      OXÍGENO, GASES, ACCESORIOS
    </p>
 

  <div class="page-break"></div>


  
  <div class="uppercase" >
    <p class="center-text" style="margin-top: 4rem;">
      RECIBO POR EL DEPOSITO DE CILINDROS O ENVASES DE GAS.
    </p>

    <p style="margin-top: 4rem;">
      RECIBÍ DEL C. {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}, LA CANTIDAD DE $ {{number_format($tanques->sum('deposito_garantia'), 2, '.', ',')}} ({{$precioLetras}} 00/100 MONEDA NACIONAL) POR CONCEPTO DEL DEPOSITO DE 
      
      @foreach ($tanques as $item)
                      <span>{{$item->cilindros}}</span> ENVASES Ó CILINDROS DE <span>{{$item->material}}</span> DE <span>{{$item->nombre}}</span> <span>{{$item->tipo_tanque}}</span>, 
                  @endforeach
      , PARA SU USO EN LAS INSTALACIONES ESTABLECIDAS DEL {{$contrato->direccion}} DE LA CIUDAD DE OAXACA DE JUÁREZ, A LOS {{$date}}.
    </p>


    <p class="center-text" style="margin-top: 10rem;">
      ____________________________ <br>
      C. VIRGINIA GARCÍA LÓPEZ.
      <br/>
      PROPIETARIA DE OXIGAMEX.
      <br/>
      OXÍGENO, GASES, ACCESORIOS
    </p>
  </div>

  </main>

  <script type="text/php">
    if (isset($pdf)) {
      $pdf->page_script('
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        $size = 11;
        $text = "Página $PAGE_NUM de $PAGE_COUNT";
        $x = $pdf->get_width() - $fontMetrics->getTextWidth($text, $font, $size) - 28;
        $y = $pdf->get_height() - 37;
        $pdf->text($x, $y, $text, $font, $size);
      ');
    }
  </script>
</body>
</html>
