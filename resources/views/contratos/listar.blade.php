@extends('layouts.sidebar')
@section('content-sidebar')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h5>CONTRATOS</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table id="tablecruddata" class="table table-sm" style="font-size: 13px">
                        <thead>
                            <tr>
                            <th class="text-center"># CONTRATO</th>
                            <th class="text-center">CLIENTE</th>
                            <th class="text-center">TIPO</th>
                            <th class="text-center">EMPRESA</th>
                            <th class="text-center">OBSERVACIONES</th>
                            <th class="text-center"></th>
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
<script src="{{ asset('js/contratos/listar.js') }}"></script>

<!--Fin Scripts-->
