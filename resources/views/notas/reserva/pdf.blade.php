<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Nota Remisión</title>
        <!--Styles -->
        <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
        {{-- <link href="{{asset('bootstrap-4.4.1-dist/css/bootstrap.min.css')}}" rel="stylesheet"> --}}
        <!-- icon -->
    </head>

    <body style="font-size: 14px">
        <main>
            <table class="table table-borderless">
                <tbody>
                    <tr id="tablaencabezado">
                        <td class="text-center">
                            <img src="img/logo.svg" style="width: 200px" alt=""></td>
                        <td >
                            <p>
                                {{$empresa->direccion}}<br>
                                {{$empresa->telefono1}} / {{$empresa->telefono2}} <br>
                                {{$empresa->email}}
                            </p>
                        </td>
                    </tr>
                </tbody>

                <tbody >
                    <tr>
                        <td  class="text-right p-0 m-0">
                            Fecha: {{$nota->created_at}}
                        </td>
                        <td  class="text-right p-0 m-0" >
                            Folio: <span style="color: red">{{$nota->id}}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table p-0 mt-0 mb-1">
                <tbody>
                    <tr>
                        <td>
                            <strong>Chofer:</strong> {{$nota->driver}} <br>
                            <strong>Vehículo: </strong> {{$nota->car}} <br>
                            <strong>Incidencia: </strong> {{$nota->incidencia}} <br>
                            
                        </td>
                        <td >
                            {{-- <p><strong>Entregar en: </strong> <br> {{$nota->direccion_envio}} <br> 
                                <strong>Referencia: </strong> <br> {{$nota->referencia_envio}}
                            </p> --}}
                        </td>
                    </tr>
                </tbody>
            </table>
            
            @inject('tipoeva','App\Http\Controllers\CatalogoGasController')
            @php
                $cont=0
            @endphp
            {{-- tanques de entrada    table-sm--}}
            <span><strong>CILINDROS</strong></span>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th># Serie</th>
                        <th>Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tanques as $item)
                        <tr>
                            <td>{{$cont+=1}}</td>
                            <td>{{$item->num_serie}}</td>
                            <td>{{$item->num_serie." - ".$item->ph." - ".$item->capacidad." - ".$item->material." - ".$item->fabricante." - ".$tipoeva->nombre_gas($item->tipo_gas)." - ".$item->tipo_tanque }}</td>
                        </tr>
                    @endforeach
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
    

