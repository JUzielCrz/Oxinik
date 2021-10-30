@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')

    

    <div class="container" >        
        <div class="card" >
            <div class="card-header">
                <h5>NOTAS INFRA</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table id="tablecruddata" class="table table-sm table-hover" style="font-size: 13px">
                        <thead class="text-center">
                            <tr >
                            <th>ID</th>
                            <th>INCIDENCIA</th>
                            <th>CANTIDAD</th>
                            <th>FECHA</th>
                            <th></th>
                            <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/infra/index.js') }}"></script>
<!--Fin Scripts-->
