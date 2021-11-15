<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head lang="es">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!--Styles -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('css/misestilos.css')}}" rel="stylesheet">

        <!----Para SIDBAR----->
        <link href="{{asset('css/misestilos.css')}}" rel="stylesheet">
        <link href="{{asset('css/sidebar-menu.css')}}" rel="stylesheet"> 

        {{-- archivos para datatables --}}
        <link href="{{asset('datatables/datatables.min.css')}}" rel="stylesheet"> 
        
                
        <!-- icon -->
        <link href="{{asset('img/icoawesome/css/all.min.css')}}" rel="stylesheet"> 
        
        <!--Para Ajax-->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        
        
    </head>

    <body>

        @yield('contenido')
        
    </body>

    </html>