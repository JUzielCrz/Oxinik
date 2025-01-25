<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Nota Remisión</title>
        <!--Styles -->
        <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- icon -->
    </head>

    <body style="font-size: 14px">
        <main>
            <table class="table table-borderless m-0">
                <tbody>
                    <tr id="tablaencabezado">
                        <td class="text-center p-0">
                            <img src="img/logo.png" style="width: 200px" alt=""></td>
                        <td class="p-0">
                            <p >
                                {{$empresa->direccion}}<br>
                                {{$empresa->telefono1}} / {{$empresa->telefono2}} <br>
                                {{$empresa->email}}
                            </p>
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td  class="text-right p-0">
                            Fecha: {{$nota->fecha}}
                        </td>
                        <td  class="text-right p-0" >
                            Folio: <span style="color: red">{{$nota->id}}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table mt-1 mb-3">
                <tbody>
                    <tr>
                        <td>
                            <strong>Cliente:</strong> {{$nota->nombre}} <br>
                            <strong>Telefono: </strong> {{$nota->telefono}} <br>
                            <strong>Correo: </strong> {{$nota->email}} <br>
                            <strong>Direccion: </strong> {{$nota->direccion}} 
                        </td>
                        <td >
                            <p><strong>Entregar en: </strong> <br> {{$nota->direccion_envio}} <br> 
                                <strong>Referencia: </strong> <br> {{$nota->referencia_envio}}
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>

            
            @inject('tipoeva','App\Http\Controllers\CatalogoGasController')

            <span class="mt-2"><strong>CILINDROS ENTRADA</strong></span>
            <table class="table table-bordered  table-sm">
                    <thead >
                        <tr >
                            <th scope="col">#SERIE</th>
                            <th scope="col">DESCRIPCIÓN</th>
                            <th scope="col">GAS</th>
                            <th scope="col">TAPA</th>
                        </tr>
                    </thead>

                    <tbody id="tablelistaTanques" >
                        @foreach ($tanques as $tanq)
                            @if ($tanq->insidencia=='ENTRADA')
                                <tr>
                                    <td>{{$tanq->num_serie}}</td>
                                    <td>{{$tanq->material}}, {{$tanq->tipo_tanque}},  PH: {{$tanq->ph}}, {{$tanq->fabricante}}</td>
                                    <td>{{$tipoeva->nombre_gas($tanq->tipo_gas)}}</td>
                                    <td>{{$tanq->tapa_tanque}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>

            </table>
            
            {{-- tanques de entrada --}}
            <span><strong>CILINDROS SALIDA</strong></span>
            <table class="table table-bordered  table-sm">
                    <thead >
                        <tr >
                            <th scope="col">#SERIE</th>
                            <th scope="col">GAS</th>
                            <th scope="col">TAPA</th>
                            <th scope="col">DESCRIPCIÓN</th>
                            <th scope="col">CANT.</th>
                            <th scope="col">U. M.</th>
                            <th scope="col">P.U.</th>
                            <th scope="col">IVA</th>
                            <th scope="col">IMPORTE</th>
                        </tr>
                    </thead>

                    <tbody id="tablelistaTanques" >
                        
                        @foreach ($tanques as $tanq)
                            @if ($tanq->insidencia=='SALIDA')
                                <tr>
                                    <td>{{$tanq->num_serie}}</td>
                                    
                                    <td>{{$tipoeva->nombre_gas($tanq->tipo_gas)}} </td>
                                    <td>{{$tanq->tapa_tanque}}</td>
                                    <td>PH: {{$tanq->ph}}, {{$tanq->material}}, {{$tanq->fabricante}}, {{$tanq->tipo_tanque}}</td>
                                    <td>{{$tanq->cantidad}}</td>
                                    <td>{{$tanq->unidad_medida}}</td>
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
                        @if ($nota->total != null)
                            <td>SUBTOTAL: <br>$ {{number_format($nota->subtotal, 2)}}</td>
                            <td>TASA 16% IVA: <br>$ {{number_format($nota->iva_general,2)}}</td>
                            <td>ENVÍO: <br>$ {{number_format($nota->precio_envio,2)}}</td>
                            <td>TOTAL: <br> $ {{number_format($nota->total,2)}}</td>
                        @endif
                        
                    </tr>
                </tbody>
            </table>

            @if ($nota->observaciones!=null)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><strong>Observaciones:</strong> <br>{{$nota->observaciones}}</td>
                    </tr>
                </tbody>
            </table>
            @endif
            
            <hr>
            <p style="text-align: justify">
                En cumplimiento a lo dispuesto en la norma internacional 
                <u>ISO 9001:2015 8.5.3 Propiedad perteneciente a los clientes o proveedores externo</u>  
                y la norma mexicana NMX-H-156-NORMEX-<u>VIGENTE</u>, por este medio autorizo a OXINIK GASES ESPECIALES a destruir el envase de mi propiedad (aplastamiento para cilindros y tachados de los datos de ojiva en acumuladores), en caso de que no aprobara la 
                <u>prueba de recalificación</u> (Prueba hidrostática/Revisión General ó la inspección visual 
                externa/<u>interna ó Prueba de corriente de Eddy</u>) a la que fuese sometido.
            </p>
            <p style="text-align: justify">
                <u>De igual manera estoy informado que la OXINIK GASES ESPECIALES entregará vacío sin ninguna responsabilidad, los cilindros autorizados para el llenado que no aprueben el seguimiento y medición de los productos e las diversas etapas de sus procesos (previo, durante y final del llenado y almacenamiento).</u>
                Así mismo, autorizo a OXINIK GASES ESPECIALES a desechar el cilindro dado de baja si en un plazo de 60 días no acudo a recibirlo.
            </p>
            <p>
                Nombre:  &nbsp; <strong>{{$nota->nombre}}</strong>  <br>
                Fecha: &nbsp; <strong>{{$nota->fecha}} </strong>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Firma: _____________________ <br>
                No. Del recibido de envases para mantenimiento:  <strong>{{$nota->id}}</strong>	
            </p>	     
            

            <p style="text-align: center; font-size: 12px">
                “Todo cilindro que regrese a uso es debido a que sus parámetros están dentro de los límites establecidos en las especificaciones (CFR, CGA, DOT, ISO, NMX-H-156), por lo que se autoriza que continúen en servicio por el periodo correspondiente de 5 años ó 10 años posteriores a su fecha de recalificación estampada, dependiendo de la especificación correspondiente del cilindro; esta vigencia serpa válido en el entendimiento que deberán perseverarse las condiciones previas de funcionamiento bajo las cuáles operó cada cilindro”
            </p>



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
    

