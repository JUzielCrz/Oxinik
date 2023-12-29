<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('bootstrap-4.4.1-dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/misestilos.css')}}" rel="stylesheet">
    

    {{-- archivos para datatables --}}
    <link href="{{asset('datatables/datatables.min.css')}}" rel="stylesheet"> 
    
    <!-- icon -->
    <link href="{{asset('img/icoawesome/css/all.min.css')}}" rel="stylesheet"> 
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <div id="app">

        <main > 
            @yield('content')
        </main>
    </div> 
</body>
</html>
