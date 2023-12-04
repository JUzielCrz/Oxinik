@extends('layouts.sidebar')

@section('content-sidebar')

    <div class="container">
        <form id="idFormReserva">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-1">
                            <a href="{{route("nota.reserva.index")}}" class="btn btn-amarillo btn-primary"> <span class="fas fa-arrow-circle-left"></span></a>
                        </div>
                        <div class="col">
                            <h3>Nueva Reserva </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Incidencia:</span>
                                    </div>
                                    <select name="incidencia" id="incidencia" class="form-control form-control-sm">
                                        <option value="">SELECCIONA</option>
                                        <option value="ENTRADA">ENTRADA</option>
                                        <option value="SALIDA">SALIDA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">         
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Chofer:</span>
                                    </div>
                                    <select name="driver" id="driver" class="form-control form-control-sm">
                                        <option value="">SELECCIONA</option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{$driver->name. " ".$driver->last_name}}">{{$driver->name." ".$driver->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                
                            </div>
                            <div class="col">         
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Vehículo:</span>
                                    </div>
                                    <select name="car" id="car" class="form-control form-control-sm">
                                        <option value="">SELECCIONA</option>
                                        @foreach ($cars as $car)
                                            <option value="{{$car->nombre. " - ".$car->modelo}}">{{$car->nombre." - ".$car->modelo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                
                            </div>
                        </div>
                        <span  id="serie_tanque_entradaError" class="text-danger"></span>
                    
                </div>
            </div>
        
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <input id="serie_tanque" type="text" class="form-control form-control-sm" placeholder="# SERIE" disabled>
                                <div class="input-group-prepend">
                                    <button id="btn-insertar-cilindro" class="btn btn-amarillo" type="button">Agregar</button>
                                </div>
                                
                            </div>
                            <span id="serie_tanqueError" class="alert-danger"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-hover table-bordered">
                            <thead>
                                <tr style="font-size: 13px">
                                    <th scope="col">#SERIE</th>
                                    <th scope="col">DESCRIPCIÓN</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-reserva-tanques" style="font-size: 13px">
                            </tbody>
                        </table>
                    </div>

                    
                </div>
                <div class="card-footer">
                    <button type="button" id="btn-save-nota" class="btn btn-verde">Aceptar</button>
                </div>
            </div>
        </form>
    </div>

@endsection
@include('layouts.scripts')
<!--Scripts-->
<script>
    $(document).ready(function () {
        $("#incidencia").change( function() {
            if ($(this).val() == "") {
                $("#serie_tanque").prop("disabled", true);
                $("#tbody-reserva-tanques").empty();
            } else {
                $("#serie_tanque").prop("disabled", false);
                $("#tbody-reserva-tanques").empty();
            }
        });

        $(document).on("click","#btn-insertar-cilindro", function () {
            $("#serie_tanqueError").empty();
            var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();

            var boolRepetido=false;
            var deleteespacio=$.trim(numserie);
            $(".classfilatanque").each(function(index, value){
                var valores = $(this).find("td")[0].innerHTML;

                if(valores == deleteespacio){
                    boolRepetido=true;
                }
            })

            if(boolRepetido){
                $("#serie_tanqueError").text('Número de serie ya agregado a esta nota');
                $("#serie_tanque").val("");
                return false;
            }

            var estatus="";
            if($("#incidencia").val()=="ENTRADA"){
                estatus="TANQUE-RESERVA"
            }
            if($("#incidencia").val()=="SALIDA"){
                estatus="LLENO-ALMACEN"
            }

            $.get('/tanque/show_numserie/' + numserie, function(msg) { 
                if(msg != ''){
                    $.get('/tanque/validar_talon/' + numserie, function(rsta) {
                        if(rsta){
                            $("#serie_tanqueError").text('Cilindro se encuentra en nota talon');
                            return false;
                        }
                        $.get('/tanque/validar_ph/' + msg.ph, function(respuesta) {
                            if(respuesta.alert=='vencido'){
                                //detener 
                                mensaje("error","PH: "+msg.ph, respuesta.mensaje, null, null);
                                return false;
                            }
                            if(respuesta.alert){
                                mensaje("warning","PH: "+msg.ph, respuesta.mensaje, null, null);
                            }
                            if(msg.estatus == estatus){                                
                                $('#tbody-reserva-tanques').append(
                                "<tr class='classfilatanque'>"+
                                "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                                "<td>"+msg.tipo_gas+", "+msg.capacidad+", "+msg.material+", "+msg.fabricante+", "+msg.gas_nombre+", "+msg.tipo_tanque+", PH: "+msg.ph +"</td>"+
                                "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                                "</tr>");
                                $("#serie_tanque").val("");
                                return false;
                            }else{
                                $("#serie_tanqueError").text('Error Tanque - estatus: '+ msg.estatus);
                                $("#serie_tanque").val("");
                                return false;
                            }
                        });
                    });
                }else{
                    $("#serie_tanqueError").text('Número de serie no existe');
                    $("#serie_tanque").val("");
                    return false;
                }
                
            });
            return false;
        });

        $(document).on("click","#btn-save-nota", function(){
            $("#incidencia").removeClass('is-invalid');
            if($("#incidencia").val()==""){
                $("#incidencia").addClass('is-invalid');
                mensaje('error','Error', 'Faltan campos por rellenar', null, null);
                return false;
            }
            $("#driver").removeClass('is-invalid');
            if($("#driver").val()==""){
                $("#driver").addClass('is-invalid');
                mensaje('error','Error', 'Faltan campos por rellenar', null, null);
                return false;
            }
            //SI no hay tanques agregados en entrada manda error
            if($('#idInputNumSerie').length === 0) {
                mensaje('error','Error', 'No hay registro de tanques', null, null);
                return false;
            }
            // envio al controlador
            $.ajax({
                method: "post",
                url: "/nota/reserva/save",
                data: $("#idFormReserva").serialize(), 
            }).done(function(msg){
                if(msg.alert =='success'){  
                    window.open("/nota/reserva/pdf/"+ msg.notaId, '_blank');
                    window.location = '/nota/reserva/index';
                }
            })
            .fail(function (jqXHR, textStatus) {
                //Si existe algun error entra aqui
                var status = jqXHR.status;
                if (status === 422) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        var idError = "#" + key + "Error";
                        //$(idError).removeClass("d-none");
                        $(idError).text(value);
                    });
                }
            });
        });
    });
    
</script>
{{-- <script src="{{ asset('js/notas/reserva/index.js') }}"></script> --}}