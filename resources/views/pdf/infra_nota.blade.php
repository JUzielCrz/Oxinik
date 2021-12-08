<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Infra</title>
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
            <table class="table table-sm mb-2">
                <tbody>
                    <tr>
                        <td>
                            <h5 >INFRA</h5>
                            <p>#Nota: <strong>{{$nota->id}}</strong> </p>
                        </td>
                        <td>
                            <p>
                                INCIDENCIA: <strong>{{$nota->incidencia}} DE TANQUES</strong><br> 
                                FECHA Y HORA: <strong>{{$nota->created_at}}</strong><br>
                                TOTAL CILINDROS: <strong>{{$nota->cantidad_salida}}</strong>
                            </p>
                        </td>
                    </tr>
                    
                </tbody>
            </table>

            <table class="table table-sm text-center" style="font-size: 13px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>#serie</th>
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
