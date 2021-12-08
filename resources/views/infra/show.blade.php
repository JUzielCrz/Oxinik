@extends('layouts.sidebar')

@section('menu-navbar') 
    @include('infra.submenu_navbar')
@endsection

@section('content-sidebar')

<div class="container">
    <form id="formCreateInfra">
        @csrf
        <input type="hidden" name="incidencia" id="incidencia"  value="ENTRADA">
        <div class="card">
            <div class="card-header p-2 bg-gris text-white">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="ml-3"> INFORMACIÓN NOTA <strong>INFRA. </strong></h5>
                    </div>
                </div>
            </div>
            <div class="card-body"> 
                <span>
                    <strong>Nota id</strong>: {{$infranota->id}} <br>
                    <strong>Usuario Responsable</strong>: {{$usuario->name}} <br>
                    <strong>Observaciones:</strong> {{$infranota->observaciones}}
                </span>
            </div>
        </div>

            <div class="row mt-2">
                <div class="col-md-9">
                    <div class="card" >
                        <div class="card-header">
                            <h5>TANQUES </h5>
                            
                        </div>
                        @inject('tipoeva','App\Http\Controllers\CatalogoGasController')
                        <div class="card-body">
                            <h5>SALIDA</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th scope="col">SERIE</th>
                                            <th scope="col">CAPACIDAD</th>
                                            <th scope="col">MATERIAL</th>
                                            <th scope="col">PH</th>
                                            <th scope="col">GAS</th>
                                            <th scope="col">TIPO</th>
                                            <th scope="col">FABRICANTE</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody id="tbodyfilaTanques">
                                        @foreach ($tanques as $tanq)
                                        @if ($tanq->incidencia == 'SALIDA')
                                        <tr class="trFilaTanque">
                                            <td> {{$tanq->num_serie}}</td> 
                                            <td> {{$tanq->capacidad}}</td>
                                            <td> {{$tanq->material}}</td>
                                            <td> {{$tanq->ph}}</td>
                                            <td> {{$tipoeva->nombre_gas($tanq->tipo_gas)}}</td>
                                            <td> {{$tanq->tipo_tanque}}</td>
                                            <td> {{$tanq->fabricante}}</td>
                                        </tr>
                                        @endif
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                                <h5>ENTRADAS</h5>
                                <table class="table table-sm table-hover" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th scope="col">SERIE</th>
                                            <th scope="col">CAPACIDAD</th>
                                            <th scope="col">MATERIAL</th>
                                            <th scope="col">PH</th>
                                            <th scope="col">GAS</th>
                                            <th scope="col">TIPO</th>
                                            <th scope="col">FABRICANTE</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyfilaTanques">
                                        @foreach ($tanques as $tanq)
                                        @if ($tanq->incidencia == 'ENTRADA')
                                        <tr class="trFilaTanque">
                                            <td> {{$tanq->num_serie}}</td> 
                                            <td> {{$tanq->capacidad}}</td>
                                            <td> {{$tanq->material}}</td>
                                            <td> {{$tanq->ph}}</td>
                                            <td> {{$tipoeva->nombre_gas($tanq->tipo_gas)}}</td>
                                            <td> {{$tanq->tipo_tanque}}</td>
                                            <td> {{$tanq->fabricante}}</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card bg-gray mt-1" style="height: 6.5rem;">
                                <div class="card-header text-center p-1"> 
                                    SALIDA
                                </div>
                                <div class="card-body text-center p-0">
                                    <h1 id="contador" class="display-1" style="font-size: 4rem;"> {{$infranota->cantidad_salida}}</h1>
                                </div>
                            </div>

                            <div class="card bg-gray mt-1" style="height: 6.5rem;">
                                <div class="card-header text-center p-1"> 
                                    ENTRADA
                                </div>
                                <div class="card-body text-center p-0">
                                    <h1 id="contador" class="display-1" style="font-size: 4rem;"> {{$infranota->cantidad_entrada}}</h1>
                                </div>
                            </div>

                            

                            <div class="card bg-gray mt-1" style="height: 6.5rem;">
                                <div class="card-header text-center p-1"> 
                                    DIFERENCIA
                                </div>
                                <div class="card-body text-center p-0">
                                    <h1 id="contador" class="display-1" style="font-size: 4rem;"> {{$infranota->cantidad_diferencia}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>




@endsection

@include('layouts.scripts')

