<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Nota Bitacora</title>
        <!--Styles -->
        <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- icon -->
    </head>

    <style>
        @page { 
            margin-top:5px; 
            margin-bottom:5px; 
        }
        #datosGenerales tbody tr td{
            margin-bottom: 10px;
            padding: 0;
        }
    </style>


    <body style="font-size: 14px">
        <main>
            
            <table class="table table-borderless" >
                <tbody>
                    <tr id="tablaencabezado">
                        <td class="text-center">
                            <img src="img/logo.png" style="width: 200px" alt=""></td>
                        <td >
                            <p >
                                {{$empresa->direccion}}<br>
                                {{$empresa->telefono1}} / {{$empresa->telefono2}} <br>
                                {{$empresa->email}}
                            </p>
                        </td>
                    </tr>
                </thead>
            </table>

            <table  class="table table-borderless" id="datosGenerales">
                <tbody>
                    <tr>
                        <td><strong>Fecha:</strong> {{$transporte->fecha}}</td>
                        <td><strong>Envases:</strong> {{$transporte->envases}}</td>
                        <td><strong>Acomuladores:</strong> {{$transporte->acomuladores}}</td>
                        <td><strong>km inicial:</strong> {{$transporte->kilometraje_inicial}}</td>
                        <td><strong>km Final:</strong> {{$transporte->kilometraje_final}}</td>
                    </tr>
                    <tr>
                        <td><strong>Vehículo:</strong> {{$vehiculo->nombre}}</td>
                        <td><strong>Modelo:</strong> {{$vehiculo->modelo}}</td>
                        <td><strong>Marca:</strong> {{$vehiculo->marca}}</td>
                        <td><strong>Placa:</strong> {{$vehiculo->placa}}</td>
                    </tr>
                    <tr>
                        <td><strong>Chofer:</strong> {{$chofer->nombre.' '.$chofer->apellidos}}</td>
                        <td><strong>Liciencia Tipo:</strong> {{$chofer->licencia_tipo}}</td>
                        <td><strong>Liciencia Núm:</strong> {{$chofer->licencia_numero}}</td>
                    </tr>
                </tbody>

            </table>

            <h5>Bitácora</h5>
            <hr>
            <table  class="table table-borderless">
                <thead>
                    <tr>
                        <th>Lugar Salida</th>
                        <th>Lugar Llegada</th>
                        <th>Hora Salida</th>
                        <th>Hora Entrada</th>
                        <th>Descarga</th>
                        <th>Carga</th>
                        <th>Total</th>
                        <th>Observacion</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($bitacoras as $bitacora)
                        <tr>
                            <td>{{$bitacora->lugar_salida}}</td>
                            <td>{{$bitacora->lugar_llegada}}</td>
                            <td>{{$bitacora->hora_salida}}</td>
                            <td>{{$bitacora->hora_entrada}}</td>
                            <td>{{$bitacora->descarga}}</td>
                            <td>{{$bitacora->carga}}</td>
                            <td>{{$bitacora->total}}</td>
                            <td>{{$bitacora->observaciones}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table  class="table table-borderless">
                <tbody>
                    <tr>
                        <td>observaciones Generales: {{$transporte->onservaciones}}</td>
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
    

