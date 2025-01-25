<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Infra</title>
        <!--Styles -->
        <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">

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
                    <td> <img src="img/logo.jpg" style="width: 200px" alt=""></td></td>
                    <td class="mt-4 mr-3 text-right"> <img src="img/email.svg" style="height: 25px;" alt=""> </td>
                </tbody>
            </table> 
        </header>

        <main>
            <table class="table table-sm mb-2">
                <tbody>
                    <tr>
                        <td>
                            <p>
                                <span style="font-size:15px"><strong>INFRA</strong></span> <br>
                                #Nota: <strong>{{$nota->id}}</strong> 
                                INCIDENCIA: <strong>{{$nota->incidencia}} DE TANQUES</strong><br> 
                                FECHA Y HORA: <strong>{{$nota->created_at}}</strong><br>
                            </p>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            @inject('tipoeva','App\Http\Controllers\CatalogoGasController')
            <table class="table table-sm text-center" style="font-size: 13px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>#SERIE</th>
                        <th>GAS</th>
                        <th>CAPACIDAD</th>
                        <th>#FABRICANTE</th>
                    </tr>
                </thead>
                @php
                    $contador=0;
                @endphp
                
                <tbody>
                    @foreach ($tanques as $tanque)
                        <tr>
                            <td style="padding: 2">{{$contador+=1}}</td>
                            <td style="padding: 2">{{$tanque->num_serie}}</td>
                            <td style="padding: 2">{{$tipoeva->nombre_gas($tanque->tipo_gas)}}</td>
                            <td style="padding: 2">{{$tanque->capacidad}}</td>
                            <td style="padding: 2">{{$tanque->fabricante}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </main>

        <footer>
            <img src="img/membrete_footer.svg" style="width: 650px" alt="">
        </footer>
    </body>
</html>
