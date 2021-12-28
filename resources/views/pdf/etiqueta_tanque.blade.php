<!DOCTYPE html>
<html >
    <head lang="es">
        <meta charset="utf-8">
        <title>Etiqueta</title>
        <!--Styles -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <style>
            @page {
                margin: 0cm 0cm;
            }

        </style>
    </head>
    <body style="font-size: 14px">

        <main>
            <svg id="barcode"></svg>
            {{$num_serie}}
        </main>
        
        <!--Scripts-->
        <script src="{{ asset('barcode.JsBarcode.all.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                JsBarcode("#barcode", "Hi world!");
            });
            
        </script>
    </body>

    
</html>
