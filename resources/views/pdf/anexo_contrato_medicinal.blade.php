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
    line-height: 1.3; /* Interlineado general */
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
    margin: 0 0 10pt 0;
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
  
  <main>
    <h1>CONVENIO DE SUMINISTRO DE GAS.</h1>

    <p>Que celebran por una parte la C. VIRGINIA GARCÍA LÓPEZ, a quien en lo subsecuente será denominará como “LA PROVEEDORA”, con domicilio ubicado en la calle Ignacio Zaragoza número 213, Interior 4, Colonia Fernando Gómez Sandoval, Santa Lucia Del Camino, Oaxaca, C.P. 71243, con nombre del establecimiento OXIGAMEX oxígeno, Gases, Accesorios. Y por la otra parte el C. {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}} en lo subsecuente se le denominara como “EL CONSUMIDOR”, con domicilio en {{$contrato->direccion}}.  al tenor de las siguientes declaraciones y clausulas:</p>

    <p><strong>DECLARA “LA PROVEEDORA”:</strong></p>

    <p>a). “LA PROVEEDORA” Virginia García López, con la capacidad y personalidad para celebrar el presente convenio, persona física sin personalidad jurídica, constituida conforme a las leyes de la República Mexicana el día primero de agosto de dos mil veintitrés, registrada ante la Secretaria de Hacienda y Crédito Público (SHCP), por parte Servicio de Administración Tributaria (SAT), para ejercer como persona física empresa legal en la República Mexicana, dedicada a la venta y suministro de gases especiales, propietaria de envases ó cilindros de diversos tipos y tamaños, los cuales sirven para vender los gases especiales, como lo especifica en el clausulado de este convenio.

    <p>DECLARA “EL CONSUMIDOR”:</p>

    <p>b). Que tiene capacidad y la personalidad para celebrar el presente contrato, y requiere el suministro de los gases y de los envases o cilindros, para uso en las instalaciones establecidas en la dirección {{$contrato->direccion}} con nombre {{$contrato->nombre_comercial}} así mismo, manifiesta que ha cumplido con todos y cada uno de los requisitos establecidos en el Anexo 1,</p>

    <p>En atención de lo anterior las partes se comprometen y manifiestan que es su voluntad expresa en celebrar el presente CONVENIO DE SUMINISTRO DE GAS, al tenor de las siguientes:</p>

    <p>CLÁUSULAS.
    <p>1.- “LA PROVEEDORA” se obliga a suministrar a “EL CONSUMIDOR” los gases que comercializa y que este último requiera durante la vigencia de este convenio siempre y cuando “EL CONSUMIDOR” se encuentre al corriente con todas las obligaciones adquiridas con “LA PROVEEDORA” a través de este convenio en el domicilio ubicado en la calle Ignacio Zaragoza número 213, Interior 4, Colonia Fernando Gómez Sandoval, Santa Lucia Del Camino, Oaxaca, C.P. 71243.</p>

    <p>“EL CONSUMIDOR” se obliga durante la vigencia de este Convenio a consumir únicamente de “LA PROVEEDORA” todos los gases que necesite y que “LA PROVEEDORA” comercializa.</p>

    <p>El “CONSUMIDOR” solicitara y pedirá a “LA PROVEEDORA” los gases que necesite, esto lo puede realizar por escrito, mediante un mensaje de texto, vía WhatsApp ó llamada telefónica, y “LA PROVEEDORA” lo suministrara dentro de un término de tres días como máximo, siempre y cuando “EL CONSUMIDOR” se encuentre al corriente en todas las obligaciones contraídas con “LA PROVEEDORA”. “EL CONSUMIDOR” tendrá derecho a adquirirlos de cualquier otro proveedor para el caso de que “LA PROVEEDORA” NO SUMINISTRÉ EL GAS DENTRO DEL TÉRMINO DE TRES DÍAS. Esta cláusula se refiere a circunstancias normales, es decir, cuando no exista caso fortuito o fuerza mayor. Las partes están de acuerdo que el supuesto previsto en esta cláusula no podrá exceder de diez días hábiles. Si transcurre dicho plazo y “LA PROVEEDORA” no ha podido suministrar los gases solicitados, “EL CONSUMIDOR” tendrá derecho a dar por terminado el presente contrato sin responsabilidad para él.</p>

    <p>2.- Ambas  partes convienen  en que no tendrán responsabilidad, si no por motivo de caso fortuito o de fuerza mayor, tales como terremotos, inundaciones, huelgas, paros, falta de suministro de energía eléctrica, motines, paros justificados de las plantas productoras que suministren los gases a “LA PROVEEDORA”, etc.;., ajenos a su voluntad, no se encontraran en posibilidad de suministrar o de adquirir los Gases a que alude el presente contrato, encontrándose de acuerdo en que si por alguna de las causas mencionadas en el párrafo anterior, no le fuera posible a “LA PROVEEDORA” ó a  “EL CONSUMIDOR” cumplir con el convenio se suspenderán los efectos del mismo por el plazo que dure aquello. En el entendido de que, si el caso fortuito o de fuerza mayor excediera de 120 días, cualquiera de las partes podrá dar por terminado este contrato sin responsabilidad para ninguna de ellas.</p>

    <p>Convienen las partes que “EL CONSUMIDOR” autorizara firmando el anexo 2, y entregara copia de la credencial de elector de dos de sus empleados, los cuales recibirán y firmaran las notas de compra al momento de recibir los envases o cilindros para que en su nombre y representación de “EL CONSUMIDOR”, en sus instalaciones de los insumos solicitados por “EL CONSUMIDOR”; así mismo, autorizara firmando el anexo y entregara copia de la credencial de elector de dos de sus empleados, los cuales recibirán y firmaran las notas de compra en nombre y representación de “EL CONSUMIDOR” cuando exista la necesidad de realizar el aumentos o la disminución de cilindros o equipos dentro de las instalaciones del uso de los gases solicitados, como les fue explicado, y justificado con la entrega de los Anexo 2 y 3.</p>

    <p>3.- Ambas partes convienen que los precios y los plazos para el pago de los gases suministrados por “LA PROVEEDORA” son los que aparecen en las facturas y/o notas de venta que se expidan y que comprueban el suministro objeto de este convenio, las que forman parte integrante del mismo como se insertan en el anexo 6, del presente convenio de suministro de gas.</p>

    <p>Ambas partes, establecen que el consumidor deberá liquidar sus notas de compras a “LA PROVEEDORA”, en un máximo de tiempo de siete días naturales, de la fecha de suministro, en caso de que no se liquide el pago y el importe de las notas de compra que adeude el consumidor en siete días,  sea igual al importe del depósito en garantía que el consumidor entrego por los cilindros en comodato, se suspenderá el suministro por parte de “LA PROVEEDORA” dando un tiempo de gracia para liquidar el adeudo de 15 días naturales o de lo contrario se dará por terminado el presente contrato sin responsabilidad para “LA PROVEEDORA” con la consecuencia inmediata de que se pasara adentro del domicilio del consumidor en sus instalaciones a recoger los cilindros y los equipos que se arrendaron motivo del contrato de comodato sin que sea causa equiparable a un delito.</p>

    <p>4.- Todos los precios de los gases suministrados  bajo este Convenio, son libre a bordo por parte de “LA PROVEEDORA”, cuando los costos de adquisición y/o distribución y/o de administración se incrementen, incluyéndose de manera enunciativa la energía eléctrica, energéticos, mano de obra, materia prima, aumento en las tasas sobre financiamiento, aumento de precios en activos fijos y en general cualquier causa que justifique dicho aumento, “LA PROVEEDORA” deberá avisar por medio de una circular que será entregada al área administrativa de “EL CONSUMIDOR” sobre el nuevo costo de los productos que comercialice la empresa con 15 días de anticipación antes de realizar dicho aumento.
    En el caso de que “EL CONSUMIDOR” optara dar por terminado el presente Contrato por el incremento en los precios, “LA PROVEEDORA” dejara de hacer el suministro y retirara su equipo y los cilindros dentro del plazo de cinco días contados a partir de la fecha en que haya recibido la comunicación POR ESCRITO de “EL CONSUMIDOR”, a “LA PROVEEDORA”, de la recisión del presente convenio por el incremento de precios.</p>

    <p>5.- “EL CONSUMIDOR” se obliga a pagar a “LA PROVEEDORA” los gastos originados por la investigación y administración del crédito, por una sola vez y a la firma del presente Convenio; ahora bien, si “EL CONSUMIDOR” necesitara de una línea de crédito con “LA PROVEEDORA” deberá solicitarlo al inicio del contrato mediante una solicitud por escrito dirigido a “LA PROVEEDORA” solicitud que se revisara y analizara la viabilidad de su aprobación.</p>

    <p>6.- “El CONSUMIDOR” podrá solicitar a “LA PROVEEDORA” sus productos en los siguientes horarios de atención de lunes a viernes 08:00 a 18:00 horas y los días sábados de 08:00 a 15:00 horas, a los siguientes números telefónicos 951 195 02 00 y 951 240 06 67.  En el caso de que “LA PROVEEDORA” no prestará sus servicios un día, ya sea por disposición oficial, día festivo o por cuestiones administrativas dará aviso “AL CONSUMIDOR” por medio de una circular con 15 días de anticipación.</p>

    <p>7.- Las partes convienen en que, sin previo aviso de “LA PROVEEDORA” con “EL CONSUMIDOR”, se presentara “LA PROVEEDORA” en las instalaciones (domicilio), de “EL CONSUMIDOR”, para realizar una visita de verificación física de los cilindros y equipo, esto para verificar que estén cumpliendo con las reglas para el manejo de cilindros de gas a presión, y que estén en buenas condiciones y con el uso adecuado de los cilindros, como les fue explicado y justificado con la entrega de los Anexo 4 y 5.</p>

    <p>8. - “EL CONSUMIDOR” se obliga muy especialmente a hacer respetar los derechos de propiedad que tiene “LA PROVEEDORA” sobre los referidos envases. En caso de que esos derechos pudieran verse lesionados como consecuencia de un embargo efectuado en los bienes de “EL CONSUMIDOR”, de una huelga, o si los recibe “LA PROVEEDORA” deteriorados o con demora considerable cuando ello ocurra por causa imputable a “EL CONSUMIDOR” el monto de los gastos legales que haya efectuado “LA PROVEEDORA”, con objeto de recuperarlos, serán cubiertos totalmente por “EL CONSUMIDOR”, previo a su acreditamiento.</p>

    <p>9.- En virtud de que se entregara a “EL CONSUMIDOR” envases ó cilindros en cantidad adecuada a sus necesidades del consumo de gases conforme a lo establecido en la Cláusula Primera, ambas partes convierten en que “LA PROVEEDORA” asentara el tipo y cantidad de los envases ó cilindros, en las notas de venta  y/o de remisión  y/o facturas con las que se amparan los gases que le suministre a “EL CONSUMIDOR” y/o en los demás documentos y formularios que se expida al mismo; así como en los libros y registros donde lleve cuenta y razón del movimiento de entregas y salidas de dichos envases. “LA PROVEEDORA” en cualquiera de los documentos anteriormente mencionados, recabará la firma de “EL CONSUMIDOR” o en su defecto de alguno de los factores o dependientes o empleados en el cual se entenderá que obra por cuenta y en representación de “EL CONSUMIDOR” en términos de los art. 309 y 310 del Código de Comercio.</p>

    <p>Convienen las partes que “EL CONSUMIDOR” autorizara a dos de sus empleados, los cuales firmaran las notas de recepción en su nombre y representación de ” EL CONSUMIDOR” al momento de recibirlos en sus instalaciones los insumos solicitados por “EL CONSUMIDOR”; así mismo, autorizara a dos de sus empleados para firmar en nombre y representación de “EL CONSUMIDOR” cuando exista la necesidad de realizar el aumentos o la disminución de cilindros o equipos  dentro de las instalaciones del uso de los gases solicitados. Anexo 2 y 3.</p>

    <p>Ambos partes convienen expresadamente en que los documentos firmados por “EL CONSUMIDOR” o sus factores o dependientes o empleados; así como, los demás comprobantes, libros o registro de “LA PROVEEDORA”, en donde se anote el movimiento de sus envases, formaran parte integrante de este convenio y consistirán una evidencia para determinar en cualquier momento, cuáles son los envases que tiene en su poder “EL CONSUMIDOR” pendientes de devolver a “LA PROVEEDORA”, de acuerdo con los términos y sujetos a las obligaciones y responsabilidades que establece este Convenio.</p>

    <p>9. - “EL CONSUMIDOR” solo deberá usar los envases que le facilite “LA PROVEEDORA” para los fines ya indicados en el domicilio señalado en la primera plana de este Convenio y tendrá obligación de notificar fehacientemente cualquier cambio de domicilio o razón social; si transcurrió un lapso de diez días después de hecha la notificación “LA PROVEEDORA” no manifiesta su inconformidad, se entenderá que autoriza el cambio de domicilio dentro de la misma ciudad. La negativa injustificada de “LA PROVEEDORA” dará derecho a “EL CONSUMIDOR” a exigir el cumplimiento forzoso del Convenio ó bien a optar por su rescisión.</p>

    <p>10. - En el caso de terminación o violación de este Convenio no cesarán las obligaciones y responsabilidades que hayan contraído las partes por el término de su vigencia, sino hasta que “LA PROVEEDORA” se dé por recibida a su entera satisfacción de los envases ó cilindros facilitados y de todas las prestaciones estipuladas a su favor; así mismo, no cesarán las obligaciones y responsabilidades de “LA PROVEEDORA” hasta que cumpla con las mismas.</p>

    <p>11. - En caso de violación de cualquiera de las cláusulas del presente Convenio por alguna de las partes dará lugar a que la parte que si cumplió exija de la otra el cumplimiento forzoso o la rescisión, debiendo pagarse en ambos casos los daños y perjuicios que se originen conforme a la pena convencional establecida en la cláusula siguiente.</p>

    <p>12.-  En el caso de que “EL CONSUMIDOR” viole su obligación contenida en las cláusulas PRIMERA y SEGUNDA del presente CONVENIO DE SUMINISTRO DE GAS, por la necesidad del uso de gas, le sea suministrado  por parte de otra persona física o jurídica, ya sea en los envases de “LA PROVEEDORA” o en  envases propiedad de esa otra persona” igualmente en caso de la no devolución de los envases ó cilindros por parte de “EL CONSUMIDOR” a “LA PROVEEDORA” en los plazos fijados y, en caso de la transición del uso de los envases por  parte de “EL CONSUMIDOR” a terceras personas, dará lugar a que “ LA PROVEEDORA” le exija el cumplimiento forzoso o le rescinda el convenio; debiendo pagar en dichos casos los daños y perjuicios que causare a “LA PROVEEDORA”.</p>
              
    <p>En caso de que el incumplimiento en el suministro del producto sea imputable a “LA PROVEEDORA” y no hubiere causa justificada para ello, pagara a “EL CONSUMIDOR”, los daños y perjuicios que causare.</p>

    <p>13. - El presente Convenio será forzoso para ambas partes por un término de un año. Dentro de los 30 días naturales anteriores a la conclusión del plazo, cualquiera de las partes podrá darlo por terminado por medio de un aviso proporcionado a la otra por escrito; de no recibir dicho aviso por algunas de las partes, se entenderá prorrogado el Convenio por un término igual al iniciar y después, continuara por tiempo indefinido, termino dentro del cual cualquiera de las partes podrá darlo por terminado con un aviso dado por escrito con 180 días naturales de anticipación, en el entendido que de no dar aviso, las partes contratantes continuaran obligándose a todos los derechos y obligaciones inherentes de este convenio.</p>

    <p>14. - “LA PROVEEDORA” durante la vigencia de este convenio podrá hacer Cesión del mismo a otro proveedor obligándose solidaria y mancomunadamente con aquel al fiel cumplimiento del presente Convenio de Suministro de Gas en todos sus términos.</p>

    <p>15.- Para garantía de lo estipulado en el presente Convenio de Suministro de Gas,  en términos del artículo 2794 del Código Civil, conjuntamente con “EL CONSUMIDOR” firma el presente convenio de Suministro de Gas, solidariamente en calidad de testigo y con él en carácter de fiador, el señor {{$contrato->nombre_solidaria}}, quien en este acto renuncia en forma expresa a todos los beneficios de orden y exclusión que consignan los artículos 2814, 2815 y 2817 y demás relativos del Código Civil vigente en la Ciudad de México, y correlativos de su domicilio.</p>

    <p>El fiador y testigo el señor {{$contrato->nombre_solidaria}}, quien en este acto se obliga solidaria y mancomunadamente con “EL CONSUMIDOR”, garantizado de esta manera el exacto cumplimiento de todas y cada una de las obligaciones contraídas por el “EL CONSUMIDOR”, de acuerdo con los términos de este Convenio, comprendiendo el fiador en que no cesara su responsabilidad, sino hasta el momento en que “LA PROVEEDORA” se dé por recibido de todas y cada uno de los envases o cilindros que haya facilitado a “EL CONSUMIDOR” y de todo cuanto este le deba de dinero, en virtud de este Convenio, renunciando de igual manera a los beneficios y derechos consignados en los artículos 2846, 2847, 2848, 2849 y además relativo del Código Civil. </p>

    <p>16. - Para todo lo relativo para la interpretación y cumplimiento del presente Convenio las partes se someten a la jurisdicción de los tribunales competentes de la ciudad de Oaxaca de Juárez, Oaxaca, renunciando desde luego a cualquier otro fuero que por razón de sus domicilios presentes o futuros o cualquier otra causa pudiera corresponderles, sin perjuicio de la competencia que en derecho le corresponde a la Procuraduría Federal del Consumidor.</p>

    <p>DECIMA SÉPTIMA. -  Las partes contratantes y el fiador aceptan en todos sus términos el presente Convenio de Suministro de Gas, con las cláusulas transcritas que preceden. Enteradas las partes de alcance y fuerza legal de todas y cada una de las estipulaciones que se contienen en este Convenio, lo firman en la ciudad de Oaxaca de Juárez, Oaxaca, a los {{$date}}.</p>


    <p class="text-center" style="margin-top: 3 rem;">“EL CONSUMIDOR”</p>
    <p class="text-center uppercase" style="margin-top: 3 rem;">
      ____________________________ <br>
      EL {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}} <br>
      REPRESENTANTE LEGAL <br>
      {{$contrato->nombre_comercial}} <br>
    </p>
      

    <p class="text-center uppercase" style="margin-top: 3 rem;">
      ____________________________ <br>
      EL SEÑOR {{$contrato->nombre_solidaria}} <br>
      FIADOR Y TESTIGO SOLIDARIO
    </p>

    <p class="text-center" style="margin-top: 3 rem;">“LA PROVEEDORA”</p>

    <p class="text-center" style="margin-top: 3 rem;">
      ____________________________ <br>
      C. VIRGINIA GARCÍA LÓPEZ. <br>
      PROPIETARIA DE OXIGAMEX. <br>
      OXÍGENO, GASES, ACCESORIOS.
    </p>

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
