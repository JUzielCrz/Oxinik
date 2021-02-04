@extends('layouts.navbar')
@section('contentnavbar')
    

    <div class="container" >

        <center>
            <div id="divmsgindex" style="display:none" class="alert" role="alert">
            </div>
        </center>

        <div class="row ">
            <div class="col-md-5 text-center">
                <h3>Historial Tanque</h3>
                <h5>Serie:{{$tanque->num_serie}}</h5>
            </div>
            <div class="col-md-5 text-right">
                <button type="button" class="btn btn-gray" data-toggle="modal" data-target="#modalinsertar">
                    <span class="fas fa-plus"></span>
                    Agregar
                </button>
            </div>
        </div>

        <input type="hidden" id="serietanque" name="" value={{$tanque->num_serie}}>
        
        <div class="row table-responsive mt-2"> 
            <table id="tablecruddata" class="table table-sm">
                <thead>
                    <tr>
                    <th scope="col">#Serie</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Folio nota</th>
                    <th scope="col">Fecha</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>




@endsection

@include('layouts.scripts')
<!--Scripts-->
<script src="{{ asset('js/cruds/tanquehistory.js') }}"></script>
<!--Fin Scripts-->
