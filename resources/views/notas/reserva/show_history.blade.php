@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('notas.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>Nota Reserva</h5>
            <p style="font-size: 13px">
                Id: <strong>{{$nota->id}}</strong> <br>
                Registro Usuario: <strong>{{$usuario->name}}</strong> <br>
                Incidencia: <strong>{{$nota->incidencia}}</strong> <br>
                Fecha: <strong>{{$nota->created_at}}</strong>
            </p>
        </div>
        <div class="card-body">
            CILINDROS
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr style="font-size: 13px">
                            <th scope="col">#SERIE</th>
                            <th scope="col">DESCRIPCIÓN</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px">
                        @foreach ($tanques as $tanque)
                            <tr>
                                <td>{{$tanque->num_serie}}</td>
                                <td>{{$tanque->tipo_gas}}, {{$tanque->capacidad}}, {{$tanque->tipo_tanque}}, PH: {{$tanque->ph}}, {{$tanque->material}}, {{$tanque->fabricante}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@include('layouts.scripts')

<script>
    $(document).ready(function () {
        $("#id-menu-reserva").addClass('active');
    });
</script>