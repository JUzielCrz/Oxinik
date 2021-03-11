@extends('layouts.navbar')
@section('contentnavbar')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body justify-content-center">
                    <h1 class="display-1" style="font-size: 50px">¡Bienvenido!</h1>
                </div>
            </div>  
        </div>
    </div>
</div>



@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/notas/notatanque.js') }}"></script>
<!--Fin Scripts-->
