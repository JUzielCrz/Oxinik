@extends('layouts.sidebar')

@section('content-sidebar')

    <div class="container" >

        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert">
            </div>
        </center>

        <input type="hidden" id="serietanque" name="" value={{$tanque->num_serie}}>

        <div class="card">
            <div class="card-header">
                <div class="row ">
                    <div class="col-md-1 m-auto">
                        <button class="btn btn-amarillo btn-block" onclick="return window.history.back();"><span class="fas fa-arrow-circle-left"></span></button>
                    </div>
                    <div class="col">
                        <h5>Historial Tanque</h5>
                        <h5 style="font-size: 15px">Serie: {{$tanque->num_serie}}</h5>
                    </div>
                    <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-amarillo" data-toggle="modal" data-target="#modalinsertar">
                            <span class="fas fa-plus"></span>
                            Agregar
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table id="tablecruddata" class="table table-sm" style="font-size: 13px">
                        <thead>
                            <tr>
                            <th scope="col">#Serie</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Nota</th>
                            <th scope="col"></th>
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
<script src="{{ asset('js/tanque/history.js') }}"></script>
<!--Fin Scripts-->
