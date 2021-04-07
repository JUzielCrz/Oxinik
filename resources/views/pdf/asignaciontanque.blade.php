<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Anexo Contrato</title>
        <!--Styles -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- icon -->
    </head>
    <style>
        body {
            margin: 0; 
            background-image: url('.../img/logo.svg');
            /* background-image: url("../img/tanque2.png"); */
            }
    </style>

    <body style="font-size: 14px">
        <main>

            <p class="text-center" style="margin-top: 2rem">ACUERDO QUE CONTIENE EL AUMENTO EN LA DOTACIÓN DE ENVASES, <br>
                PROPIEDAD DE <strong>OXINIK</strong> <br>
                PARA EL SUMINISTRO DE GAS INDUSTRIAL Y/O MEDICINAL
                </p>
            
            <p style="margin-top: 4rem">RECIBI(MOS) DE OXINIK EN CONCEPTO DE <strong>{{$nota->incidencia}}</strong> EN LA DOTACIÓN DE ENVASES PARA.</p>

            <p style="text-align: justify;">EL CONSUMO DE GAS INDUSTRIAL Y/O MEDICINAL, A QUE SE REFIERE AL CONTRATO CON NUMERO:  <strong>{{$nota->num_contrato}}</strong>, 
                DE FECHA <strong>{{$nota->fecha}}</strong>, LOS ENVASES SIGUIENTES:</p>
                
                <div style="margin-left: 10rem">
                    <table class="table table-sm mt-4 text-center" style="width: 23rem; margin-top: 3rem">
                        <thead>
                            <tr>
                                <th>TIPO ENVASE</th>
                                <th>CANTIDAD</th>
                                <th>ABREVIATURA</th>
                            </tr>
                        </thead>
                        <tbody>
    
                            @foreach ($detalleNota as $tanques)
                                <tr>
                                    <td>{{$tanques->nombre}}</td>
                                    <td>{{$tanques->cantidad}}</td>
                                    <td>{{$tanques->abreviatura}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                

            <p class="mt-4" style="text-align: justify; margin-top: rem">
                LOS ENVASES RECIBIDOS MEDIANTE LA FIRMA DE ESTE DOCUMENTO ARRIBA RELACIONADOS SON PROPIEDAD DE OXINIK.
            </p>
            <p style="text-align: justify;">EL PRESENTE DOCUMENTO HACE CONSTAR EL ACUERDO DE LAS PARQUES QUE CELEBRARON EN EL CONTRATO ARRIBA MENCIONADO, PARA <strong>{{$nota->incidencia}}</strong> DE LA DOTACIÓN DE ENVASES A QUE SE REFIERE LA CLAUSULA CUARTA DE DICHO CONTRATO, RECONOCIENDO LOS FIRMANTES DEL PRESENTE INSTRUMENTO QUE ESTE FORMA PARTE DE INTEGRANTE DEL MISMO.</p>
        
            <P class="text-center mt-4" style="margin-top: 5rem">
                RECIBI(MOS) {{$nota->fecha}}<br> <br> <br>

                _____________________ <br>
                NOMBRE Y FIRMA DEL REPRESÉNTATE LEGAL <br> <br> <br>

                SELLO DE LA EMPRESA <br>
            </P>
        </main>
    </body>

</html>
