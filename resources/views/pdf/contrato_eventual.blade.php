<!DOCTYPE html>
<html lang="es">

<head>
  <title>Contrato General</title>
  <meta charset="UTF-8"/>
    <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  /* 1. Configuración de Página */
  @page {
    margin: 3.5cm 1cm 2.7cm 1cm;
    size: letter;
  }

  /* 2. Estilo Global (Tipo de texto e Interlineado) */
  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 10.0pt;
    line-height: 1.1; /* Interlineado general */
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
    margin: 6pt 0;
    font-weight: bold;
		font-size: 16px; 
		text-align: center
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

	.title-ul {
		font-weight: bold;
		margin-top: 20px;
		margin-bottom: 0px;
	}
</style>
  
</head>

<body class="page-bg">
  <img src="{{ public_path('img/oxigamex/membrete_carta.jpg') }}" class="background-image">
  <main>
      <p class="text-right">N° CONTRATO: <strong>{{$contrato->id}}</strong></p>
      <h5>CONTRATO DE ARRENDAMIENTO DE EQUIPO INSTRUMENTAL MEDICO Y EQUIPO DE OXIGENO MEDICINAL Y ACCESORIOS</h5>

		<p>Que celebran por una parte la C.Virginia García López,  propietaria del establecimiento OXIGAMEX OXIGENO GASES ACCESORIOS, a quién en lo sucesivo se le denominara “El Contratante” y por la otra parte el sr (a). {{$cliente->nombre}} {{$cliente->apPaterno}} {{$cliente->apMaterno}}, a quién se le denominara “El Contratista”, los cuales se sujetarán a las siguientes CLÁUSULAS:</p>

		<p>PRIMERA: “El Contratante”, entrega a “El Contratista” en calidad de alquiler: 
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
			, que inicia el día {{date('Y-m-d', strtotime($contrato->created_at))}}, el cual será utilizado en el domicilio ubicado en {{$contrato->direccion}}, quien cuenta con número telefónico {{$cliente->telefono}} y {{$cliente->telefonorespaldo}}.</p>

		<p>SEGUNDA: El equipo dado en renta a “El Contratista” por parte de “El Contratante”, no podrá bajo ninguna circunstancia ser prestado, sub arrendado ó cedido en forma alguna a terceras personas, constituyéndose “El Contratista” como el responsable directo del buen uso y de la conservación del equipo alquilado y se obliga a pagar el importe de todo el equipo alquilado en el caso de robo, destrucción ó daños que sufra el equipo alquilado y tendrá que pagar las reparaciones que sufra el equipo mencionado.</p>

		<p>TERCERA: “El Contratista” deberá informar a “El Contratante”, con veinticuatro horas de anticipación al de concluir el presente contrato de alquiler, por vía telefónica si dará por concluido el contrato de alquiler y de no hacerlo se tendrá el contrato de alquiler por renovado automáticamente por el mismo tiempo y precio que se contrató inicialmente, “El Contratista” tendrá como plazo de dos días naturales para pagar en las oficinas que ocupan el establecimiento OXIGAMEX OXIGENO GASES ACCESORIOS, la cantidad correspondiente del equipo alquilado por la renovación del contrato, ya que de lo contrario se le realizara un cobro extra por el cobro a domicilio, y en caso de demora de pago, esto causara una sanción de un 20 % sobre el monto del presente contrato, y la cantidad que sirvió como depósito no se le devolverá bajo ninguna circunstancia.</p>

		<p>CUARTA: “El Contratista” tiene la obligación de hacer su consumo exclusivamente con el establecimiento OXIGAMEX OXIGENO GASES ACCESORIOS, y no puede bajo ninguna circunstancia trasladar los tanques, para su llenado en ninguna otra empresa o cambio/ canjeo por su número de serie de dichos cilindros.</p>

		<p>QUINTA: “El Contratista” debe entregar un depósito en garantía de ${{number_format($tanques->sum('deposito_garantia'), 2, '.', ',')}} ({{$precioLetras}} 00/100 m.n.), por CADA UNO de los envases solicitados en alquiler y proporcionados por “El Contratante”, el cual podrá satisfacerse mediante tarjeta de crédito, transferencia bancaria o en efectivo en el domicilio del establecimiento OXIGAMEX OXIGENO GASES ACCESORIOS, ubicado en la calle Ignacio Zaragoza, número 213 4, en la colonia Fernando Gómez Sandoval, del Municipio de Santa Lucia del Camino, Oaxaca, c. p. 71243, cuyo justificante se adjuntará al presente contrato.</p>

		@php
      $multa=0;
      $multa=$tanques->sum('cilindros') * 15000;
		@endphp
    @inject('num_letras','App\Http\Controllers\ConvertNumberController')

		<p>En la ciudad de Oaxaca de Juárez, Oaxaca, debo y pagaré incondicionalmente y a la orden de la C. Virginia García López, la cantidad de ${{number_format($multa, 2, '.', ',')}} ({{$num_letras->toMoney($multa, 2, 'PESOS','CENTAVOS')}} 00/100), valor recibido a mi entera satisfacción, con fecha de vencimiento 	, sujeto a la condición de que de no hacer pago de acuerdo al artículo 79 y 152 de la Ley General de Títulos y Operaciones de Crédito, causara en interés moratorio de
    %, por cada mes o fracción.</p>


		<p class="center-text mt-5">______________________</p>
		<p class="center-text">Nombre y firma</p>

		<div class="page-break"></div>
    
		<p>NOTA: EL PAGARE FIRMADO EN ESTE CONTRATO SURTIRÁ EFECTO ÚNICAMENTE SI “EL CONTRATANTE” EXTRAVIÉ, DETERIORÉ, DAÑE O SE NIEGUE A REALIZAR LA DEVOLUCIÓN DE ALGUNO O ALGUNOS DE LOS ENVASES, PUESTO QUE EL DEPÓSITO COMO GARANTÍA REQUERIDO NO REPRESENTA DE NINGUNA MANERA EL PRECIO DEL O DE LOS ENVASES QUE REQUIERE.</p>

		<h5>POR SEGURIDAD ES NECESARIO QUE LEA Y APLIQUE SIEMPRE LAS SIGUIENTES REGLAS EN EL MANEJO DE CILINDROS Y GASES ENVASADOS.</h5>

		<p class="title-ul"><strong>Almacenamiento y manejo </strong></p>
		<ul>
			<li> Mantenga el cilindro y la válvula LIBRE DE GRASA O ACEITE ya que esto puede ocasionar una EXPLOSIÓN. </li>
			<li> Tener cuidado en el manejo de los cilindros y válvulas, evite golpearlos, pintarlos, rayarlos y hacer arco eléctrico en los cilindros, recuerde que los cilindros están llenos a alta presión por lo cual no deben ser manejados bruscamente. </li>
			<li> Conservar el envase en un lugar bien ventilado, mantener lejos de fuentes de combustión, incendio o flama abierta. </li>
			<li>  Vigile que la temperatura en el cilindro no exceda de los 52 °C. (Evite exposición al sol por tiempos prolongados) </li>
			<li> Mantener la válvula cerrada cuando no esté en uso o este vacío el envase. </li>
			<li> No fume o encienda una flama cuando esté en uso. </li>
			<li> No deje al alcance de los niños evite un accidente. </li>
			<li> Es necesario sujetar los cilindros a la pared o algo sólido, esto para evitar daños en caso de sismos o choque accidental, para evitar caídas de estos. </li>
		</ul>

		<p class="title-ul">Uso</p>
		<ul>
			<li> No ponga los cilindros o acumuladores de manera horizontal mientras este en uso. </li>
			<li> Al abrir las válvulas de los cilindros siempre hágalo lentamente y manténgase a un costado del cilindro. </li>
			<li> Si surge flama o no puede cerrar la válvula, rocié agua abundante en el cuerpo del acumulador, cuidando que la flama no se apague así evitara una explosión. </li>
			<li> Si detecta una fuga de gas en el cilindro, cierre la válvula y notifique inmediatamente a su proveedor (no intente reparar el cilindro). </li>
			<li> Reporte en cuanto ya no tenga en uso el equipo, para realizar la cancelación y recolección del equipo en renta y evitar que la renta siga transcurriendo.</li>
		</ul>

		<p class="title-ul">Garantía</p> 
		<ul>
			<li> En caso que su cilindro presente fuga en el volante o la válvula del cilindro, cuenta con 3 días a partir de su compra para reportarlo. Si lo reporta después de los 3 días establecidos no será válida la garantía. 
			<li> En casos donde cuente con mas de 1 cilindro y uno de estos ya no fue utilizado, se REINTEGRARÁ EL IMPORTE PAGADO DE ESTE, SOLO SI CUENTA CON EL SELLO SIN ROMPER. </li>
			<li> LOS GASES BIEN UTILIZADOS SON MUY SEGUROS, SI USTED SIGUE LAS INSTRUCCIONES DIFICILMENTE TENDRA PROBLEMAS. 
			<li> OXIGAMEX no se hace responsable de cualquier daño que el cliente ocasione si no se cumple con los puntos de seguridad anteriormente mencionados. </li>
			<li> Consulte hojas de seguridad https://grupoinfra.com/pagina/libreria/descarga/76
		</ul>

		<p class="title-ul">Servicio de entrega a domicilio </p>
		<ul>
			<li> Lunes a viernes 09:00 am a 5:00 pm </li>
			<li> Sábado 09:00 am a 2:00 pm  </li>
			<li> En caso de acabarse la carga del cilindro fuera de este horario o fin de semana, deberá solicitar un cilindro en préstamo, el cilindro vacío pendiente de entrega será recolectado al día siguiente en horario de servicio de entrega. </li>
			<li> Los operadores no podrán trasladar cilindros de mas de 25 kg de peso, a un segundo o mas niveles por escales o rampas que no cuenten con las medidas de seguridad necesarias evitando un accidente o daño. </li>
		</ul>


		<p class="text-center">____________________________________</p>
		<p class="text-center">NOMBRE Y FIRMA DE CONFORMIDAD</p>

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