    <center>
        <div id="divmsg" style="display:none" class="alert" role="alert">
        </div>
    </center>

  <form id="idFormContrato" style="font-size: 13px">
    @csrf
        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col">
                {!! Form::label('#Contrato*') !!}
                {!! Form::number('num_contrato', null, ['id'=>'num_contrato', 'class' => 'form-control form-control-sm numero-entero-positivo', 'placeholder'=>'Número de Contrato', 'required' ]) !!}
            <span  id="num_contratoError" class="text-danger"></span>
            </div>
            <div class="form-group col">
                {!! Form::label('Tipo de Contrato*') !!}
                {{ Form::select('tipo_contrato',['Industrial' => 'Industrial', 
                                                'Medicinal' => 'Medicinal',  
                                                'Eventual' => 'Eventual' 
                                                ],null,['id' => 'tipo_contrato','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}}
                <span  id="tipo_contratoError" class="text-danger"></span>
            </div>
            <div class="form-group col">
                {!! Form::label('#Reguladores') !!}
                <select name="reguladores" id="reguladores" class="form-control form-control-sm">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                <span  id="reguladoresError" class="text-danger"></span>
            </div>
        </div>


        <hr>
        <div class="form-row">
                <p>Datos Envío</p>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <label for="">Dirección envío</label>
                <textarea name="direccion" id="direccion" class="form-control form-control-sm" cols="30" rows="2"></textarea>
            </div>
            <div class="col-md-6">
                <label for="">Referencia</label>
                <textarea name="referencia" id="referencia" class="form-control form-control-sm" cols="30" rows="2"></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Precio Transporte') !!}
                {!! Form::number('precio_transporte', null, ['id'=>'precio_transporte', 'class' => 'form-control form-control-sm numero-decimal-positivo', 'placeholder'=>'$0.0']) !!}
                <span  id="precio_transporteError" class="text-danger"></span>
            </div>
            <div class="col-md-6">
                <label for="">URL Ubicación</label>
                <textarea name="link_ubicacion" id="link_ubicacion" class="form-control form-control-sm" cols="30" rows="1"></textarea>
            </div>
        </div>
        
        <hr>
        
        <div class="form-row">
                <p>Asignación tanques</p>
        </div>

        

        <div class="form-row">

                
            
            <table class="table table-sm" id="table-asignaciones" style="font-size: 12px">
                <thead>
                    <tr>
                        <th>CILINDROS</th>
                        <th>GAS</th>
                        <th>TIPO</th>
                        <th>MATERIAL</th>
                        <th>P.U.</th>
                        <th>U.M.</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <div id="msg-alert-asignacion"></div>
                <tbody>
                    <tr class="trasignacion">
                        <td style="width: 5rem">
                            <input name="cilindroscreate[]" id="cilindroscreate" type="number" class="form-control form-control-sm numero-entero-positivo"  placeholder="#" >
                        </td>
                        <td>
                            <select name="tipo_gascreate[]" id="tipo_gascreate" class="form-control form-control-sm">
                                <option value="" selected>Selecciona</option>
                                @foreach ($catalogogas as $gas)
                                    <option value={{$gas->id}}>{{$gas->nombre}}</option>
                                @endforeach 
                            </select>
                        </td>
                        <td>
                            <select name="tipo_tanquecreate[]" id="tipo_tanquecreate" class="form-control form-control-sm tipo_tanque" disabled>
                                <option value="" selected>Selecciona</option>
                            </select>
                        </td>
                        <td>
                            <select name="materialcreate[]" id="materialcreate" class="form-control form-control-sm">
                                <option value="" selected>Selecciona</option>
                                <option value="Acero">Acero</option>
                                <option value="Aluminio">Aluminio</option>
                            </select>
                        </td>
                        <td style="width: 7rem">
                            <input type="number" name="precio_unitariocreate[]" id="precio_unitariocreate" class="form-control form-control-sm numero-decimal-positivo" placeholder="$0">
                        </td>
                        <td>
                            <select name="unidad_medidacreate[]" id="unidad_medidacreate" class="form-control form-control-sm">
                                <option value="" selected>Selecciona</option>
                                <option value="CARGA">Carga</option>
                                <option value="m3">m3</option>
                                <option value="kg">kg</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-amarillo btn-sm" id="btn-anadir-asignacioncreate"><span class="fas fa-plus"></span></button>
                        </td>
                    </tr>
                </tbody>
                <tbody id="tbody-tr-asignacioncreate">
                </tbody>
            </table>
        </div>

        <hr>
        <div class="form-row">
            <div class="col-md-6">
                <label for="">Deposito Garantia</label>
                <input type="number" name="deposito_garantia" id="deposito_garantia" class="form-control form-control-sm numero-decimal-positivo" placeholder="$ 0.0">
                <span  id="deposito_garantiaError" class="text-danger"></span>
            </div>
            {{-- <div class="col-md-6">
                <label for="">Deposito Escrito</label>
                <input type="text" name="deposito_escrito" id="deposito_escrito" class="form-control form-control-sm">
                <span  id="deposito_escritoError" class="text-danger"></span>
            </div> --}}
        </div>
        <div class="form-row">
            <div class="col">
                <label for="">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control form-control-sm" cols="30" rows="2"></textarea>
            </div>
        </div>

        <center>
            <div id="divmsg" style="display:none" class="alert" role="alert">
            </div>
        </center>
        
</form>


<script>
    $(document).ready(function () {
        $(document).on("click","#btn-anadir-asignacioncreate", aniadir);
        $(document).on("click","#btn-eliminar-filaasignacion", removefilaasignacion);
        
        function removefilaasignacion(){
            $(this).closest('tr').remove();
        }

        $(document).on('click', '.borrar', function (event) {
            event.preventDefault();
            $(this).closest('tr').remove();
        });


        function aniadir(){

            var opcionesTanque='';
            var isdisabled='';

            if( $("#tipo_contrato").val()=='Industrial'){
                opcionesTanque='<option value="Industrial" >Industrial</option>';
            }
            
            if( $("#tipo_contrato").val()=='Medicinal'){
                opcionesTanque='<option value="Medicinal" >Medicinal</option>';
            }
            if( $("#tipo_contrato").val()=='Eventual'){
                opcionesTanque='<option value="" >Selecciona</option>'+'<option value="Industrial">Industrial</option>'+'<option value="Medicinal">Medicinal</option>';
            }
            if( $("#tipo_contrato").val()==''){
                opcionesTanque='<option value="" >Selecciona</option>';
                isdisabled='disabled';
            }

            

            $.ajax({
            method: "get",
            url: "/catalogo_gases",
            })
            .done(function(msg){
                var opciones;
                opciones = '<option value="" selected>Selecciona</option>';
                $(msg).each(function(index, value){
                    opciones += '<option value="'+value.id+'">'+ value.nombre +'</option>';
                });


                $('#tbody-tr-asignacioncreate').append(
                    '<tr class="trasignacion">'+
                        '<td style="width: 5rem">'+
                            '<input name="cilindroscreate[]" id="cilindroscreate" type="number" class="form-control form-control-sm numero-entero-positivo" placeholder="#">'+
                        '</td> '+
                        '<td>'+
                            '<select name="tipo_gascreate[]" id="tipo_gascreate" class="form-control form-control-sm select-search">'+
                                opciones+
                            '</select>'+
                        '</td>'+
                        '<td>'+
                            '<select name="tipo_tanquecreate[]" id="tipo_tanquecreate" class="form-control form-control-sm tipo_tanque" '+isdisabled+' >'+
                                opcionesTanque+
                            '</select>'+
                        '</td>'+
                        '<td>'+
                            '<select name="materialcreate[]" id="materialcreate" class="form-control form-control-sm">'+
                                '<option value="" selected>Selecciona</option>'+
                                '<option value="Acero">Acero</option>'+
                                '<option value="Aluminio">Aluminio</option>'+
                            '</select>'+
                        '</td>'+
                        '<td style="width: 7rem">'+
                            '<input type="number" name="precio_unitariocreate[]" id="precio_unitariocreate" class="form-control form-control-sm numero-decimal-positivo" placeholder="$0">'+
                        '</td>'+
                        '<td>'+
                            '<select name="unidad_medidacreate[]" id="unidad_medidacreate" class="form-control form-control-sm">'+
                                '<option value="" selected>Selecciona</option>'+
                                '<option value="CARGA">Carga</option>'+
                                '<option value="m3">m3</option>'+
                                '<option value="kg">kg</option>'+
                            '</select>'+
                        '</td>'+
                        '<td>'+
                            '<button type="button" class="btn btn-sm btn-amarillo" id="btn-anadir-asignacioncreate"><span class="fas fa-plus"></span></button>'+
                        '</td>'+
                        '<td>'+
                            '<button type="button" class="btn btn-sm btn-amarillo ml-1  " id="btn-eliminar-filaasignacion"><span class="fas fa-minus"></span></button>'+
                        '</td>'+
                    '</tr>'
                );

            })


            


        }
    });
</script>
