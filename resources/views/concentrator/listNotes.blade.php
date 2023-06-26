@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('concentrator.submenu_navbar')
@endsection

@section('content-sidebar')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row ">
                <div class="col">
                    <h5>Notas Concentradores</h5>
                </div>
                <div class="col text-right">
                    <a type="button" class="btn btn-sm btn-amarillo"  href="{{ url('/concentrator/note/create') }}">
                        <span class="fas fa-plus"></span>
                        Agregar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="font-size:13px">
                <table id="table-data" class="table table-sm " style="font-size:13px">
                    <thead><tr>
                        <th>ID NOTA</th>
                        <th>CLIENTE</th>
                        <th>FECHA</th>
                        <th>TOTAL</th>
                        <th>STATUS</th>
                        <th>USUARIO</th>
                        <th></th>
                    </tr></thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@include('layouts.scripts')

<!--Scripts-->
<script src="{{ asset('js/concentrator/listNote.js') }}"></script>
<script src="{{ asset('js/clientes_sc/edit_save.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#navbar_concentrators_notes").addClass('active');
    });
</script>
<!--Fin Scripts-->