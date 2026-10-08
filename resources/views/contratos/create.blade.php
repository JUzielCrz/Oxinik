    <center>
        <div id="divmsg" style="display:none" class="alert" role="alert">
        </div>
    </center>

    <style>
        .contrato-form {
            color: #2F4858;
        }

        .contrato-form .form-section {
            margin: 1.25rem 0 1rem;
            padding-bottom: .35rem;
            border-bottom: 2px solid #e9ecef;
        }

        .contrato-form .form-section-title {
            margin: 0;
            color: #2F4858;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .02em;
        }

        .contrato-form .form-section-help,
        .contrato-form .field-help {
            color: #6c757d;
            font-size: .78rem;
        }

        .contrato-form label {
            font-weight: 600;
            margin-bottom: .3rem;
        }

        .contrato-form .required-mark {
            color: #c0392b;
        }

        .contrato-form .assignment-table {
            min-width: 1050px;
        }

        .contrato-form .assignment-table th {
            white-space: nowrap;
            vertical-align: middle;
        }

        .contrato-form .assignment-table td {
            vertical-align: middle;
        }

        .contrato-form .assignment-table .form-control {
            min-width: 90px;
        }

        .contrato-form .assignment-table .num_cilin {
            min-width: 75px;
        }

        .contrato-form .assignment-table .dep_garanty {
            background: #f8f9fa;
            font-weight: 600;
        }

        .contrato-form .deposit-summary {
            background: #eef8f1;
            border: 1px solid #b7dfc2;
            color: #246b3b;
            font-size: .95rem;
        }
    </style>

  <form id="idFormContrato" class="contrato-form" style="font-size: 13px">
    @csrf
        <div class="alert alert-light border mb-3" role="note">
            <strong>Nuevo contrato</strong>
            <div class="field-help mt-1">Completa la información general, el domicilio de entrega y después agrega una fila por cada tipo de cilindro.</div>
            <span class="field-help"><span class="required-mark">*</span> Campos obligatorios</span>
        </div>

        <div class="form-section">
            <h4 class="form-section-title">1. Datos del contrato</h4>
            <div class="form-section-help">Define el tipo de servicio y la configuración comercial del contrato.</div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="tipo_contrato">Tipo de contrato <span class="required-mark">*</span></label>
                {{ Form::select('tipo_contrato',['Industrial' => 'Industrial', 
                                                'Medicinal' => 'Medicinal',  
                                                'Eventual' => 'Eventual' 
                                                ],null,['id' => 'tipo_contrato','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}}
                <span  id="tipo_contratoError" class="text-danger"></span>
            </div>
            <div class="form-group col">
                <label for="nombre_comercial">Nombre comercial</label>
                <input name="nombre_comercial" id="nombre_comercial" type="text" class="form-control form-control-sm" >
                <span  id="nombre_comercialError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-2">
                <label for="reguladores">Número de reguladores</label>
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
            <div class="form-group col">
                <label for="modelo_regulador">Modelo del regulador</label>
                <input name="modelo_regulador" id="modelo_regulador" type="text" class="form-control form-control-sm" >
                <span  id="modelo_reguladorError" class="text-danger"></span>
            </div>
        </div>
        <div id="change_renta"></div>
        <div class="form-section">
            <h4 class="form-section-title">2. Ubicación de los cilindros</h4>
            <div class="form-section-help">Indica dónde se utilizarán y cómo localizar el domicilio de entrega.</div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <label for="direccion">Dirección <span class="required-mark">*</span></label>
                <textarea name="direccion" id="direccion" class="form-control form-control-sm" cols="30" rows="2"></textarea>
                <span  id="direccionError" class="text-danger"></span>
            </div>
            <div class="col-md-6">
                <label for="referencia">Referencia <span class="required-mark">*</span></label>
                <textarea name="referencia" id="referencia" class="form-control form-control-sm" cols="30" rows="2"></textarea>
                <span  id="referenciaError" class="text-danger"></span>
            </div>
        </div>
        <div class="form-row"><div class="field-help mb-2">Entre las calles</div></div>
        <div class="form-row">
            <div class="col">
                <textarea name="calle1" id="calle1" class="form-control form-control-sm" cols="30" rows="1"  placeholder="CALLE 1"></textarea>
                <span  id="calle1Error" class="text-danger"></span>
            </div>
            <div class="col">
                <textarea name="calle2" id="calle2" class="form-control form-control-sm" cols="30" rows="1" placeholder="CALLE 2"></textarea>
                <span  id="calle2Error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Precio Transporte') !!}
                {!! Form::number('precio_transporte', null, ['id'=>'precio_transporte', 'class' => 'form-control form-control-sm numero-decimal-positivo', 'placeholder'=>'$0.0']) !!}
                <span  id="precio_transporteError" class="text-danger"></span>
            </div>
            <div class="col-md-6">
                <label for="link_ubicacion">URL de ubicación</label>
                <textarea name="link_ubicacion" id="link_ubicacion" class="form-control form-control-sm" cols="30" rows="1" placeholder="https://maps.google.com/..."></textarea>
            </div>
        </div>
        
        <div class="form-section">
            <h4 class="form-section-title">3. Persona solidaria</h4>
            <div class="form-section-help">Persona que firma como respaldo del contrato, si aplica.</div>
        </div>
        <div class="form-row">
            <div class="col">
                <label for="nombre_solidaria">Nombre</label>
                <input type="text" name="nombre_solidaria" id="nombre_solidaria" class="form-control form-control-sm">
            </div>
            <div class="col">
                <label for="telefono_solidaria">Teléfono</label>
                <input type="number" name="telefono_solidaria" id="telefono_solidaria" class="form-control form-control-sm numero-entero-positivo lenght-telefono">
            </div>
            <div class="col">
                <label for="email_solidaria">Correo electrónico</label>
                <input type="email" name="email_solidaria" id="email_solidaria" class="form-control form-control-sm">
            </div>
            
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <label for="">Dirección</label>
                <textarea name="direccion_solidaria" id="direccion_solidaria" class="form-control form-control-sm" cols="30" rows="2"></textarea>
                <span  id="direccion_solidariaError" class="text-danger"></span>
            </div>
        </div>

        
        <div class="form-section">
            <h4 class="form-section-title">4. Asignación de tanques</h4>
            <div class="form-section-help">Agrega una fila por cada combinación de gas, tipo, material y capacidad.</div>
        </div>

        

        <div class="form-row">

                
            
            <div class="field-help mb-2">El depósito total de cada fila se calcula automáticamente: cilindros × depósito unitario.</div>
            <div id="msg-alert-asignacion" class="mb-2"></div>
            <div class="table-responsive">
            <table class="table table-sm assignment-table" id="table-asignaciones" style="font-size: 12px">
                <thead>
                    <tr>
                        <th>Cilindros</th>
                        <th>Gas</th>
                        <th>Tipo de tanque</th>
                        <th>Material</th>
                        <th>Capacidad</th>
                        <th>Unidad</th>
                        <th>Precio unitario</th>
                        <th>Depósito unitario</th>
                        <th>Depósito total</th>
                        <th><span class="sr-only">Agregar</span></th>
                        <th><span class="sr-only">Eliminar</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="trasignacion">
                        <td class="tdWidth">
                            <input name="cilindroscreate[]" id="cilindroscreate" type="number" class="num_cilin form-control form-control-sm numero-entero-positivo"  placeholder="#" >
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
                        <td class="tdWidth">
                            <input type="number" name="capacidadcreate[]" id="capacidadcreate" class="form-control form-control-sm numero-entero-positivo" placeholder="0">
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
                            <input type="number" name="precio_unitariocreate[]" id="precio_unitariocreate" class="form-control form-control-sm numero-decimal-positivo" placeholder="$0">
                        </td>
                        <td>
                            <input type="number" min="0" step="0.01" class="dep_unit form-control form-control-sm numero-decimal-positivo" placeholder="$0" aria-label="Depósito unitario">
                        </td>
                        <td>
                            <input type="number" name="deposito_garantiacreate[]" id="deposito_garantiacreate" class="dep_garanty form-control form-control-sm numero-decimal-positivo" placeholder="$0" readonly aria-label="Depósito total de la fila">
                        </td>
                        <td>
                            <button type="button" class="btn btn-amarillo btn-sm btn-anadir-asignacioncreate" title="Agregar otra asignación" aria-label="Agregar otra asignación"><span class="fas fa-plus"></span></button>
                        </td>
                    </tr>
                </tbody>
                <tbody id="tbody-tr-asignacioncreate">
                </tbody>
                <tfoot>
                    <tr style="font-size: .95rem;">
                        <td colspan="8" class="text-right font-weight-bold mt-3">Depósito total del contrato:</td>
                        <td colspan="3" class="font-weight-bold mt-3" id="total-deposito-garantia">$0.00</td>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>

        <div class="form-section">
            <h4 class="form-section-title">5. Observaciones</h4>
            <div class="form-section-help">Información adicional para el equipo que dará seguimiento al contrato.</div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <label for="observaciones">Observaciones</label>
                <div class="field-help mb-1">Agrega cualquier instrucción o nota importante para el contrato.</div>
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
        $(document).on("click", ".btn-anadir-asignacioncreate", aniadir);
        $(document).on("click","#btn-eliminar-filaasignacion", removefilaasignacion);
        $(document).on("input", ".dep_unit, .num_cilin", actualizarDepositoFila);
        
        $("#tipo_contrato").change( function() {
            if ($(this).val() == "Eventual") {
                $("#change_renta").empty();
                $("#change_renta").append(
                    '<div class="form-row">'+
                        '<div class="form-group col-md-3">'+
                            '<label for="">Renta:</label>'+
                            '<input type="number" name="precio_renta" class="form-control form-control-sm" placeholder="$0">'+
                        '</div>'+
                        '<div class="form-group col-md-3">'+
                            '<label for="">Frecuencia:</label>'+
                           '<select name="frecuency" class="form-control form-control-sm">'+
                                '<option value="">Selecciona</option>'+
                                '<option value="diarios">diarios</option>'+
                                '<option value="mensual">mensual</option>'+
                                '<option value="anual">anual</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'
                );
            } else {
                $("#change_renta").empty();
            }
        });

        function removefilaasignacion(){
            $(this).closest('tr').remove();
            actualizarTotalDeposito();
        }

        $(document).on('click', '.borrar', function (event) {
            event.preventDefault();
            $(this).closest('tr').remove();
        });

        function actualizarDepositoFila(){
            var fila = $(this).closest('tr');
            var cilindros = parseFloat(fila.find('.num_cilin').val()) || 0;
            var depositoUnitario = parseFloat(fila.find('.dep_unit').val()) || 0;
            fila.find('.dep_garanty').val((cilindros * depositoUnitario).toFixed(2));
            actualizarTotalDeposito();
        }

        function actualizarTotalDeposito(){
            var total = 0;
            $('.dep_garanty').each(function(){
                total += parseFloat($(this).val()) || 0;
            });
            $('#total-deposito-garantia').text('$' + total.toLocaleString('es-MX', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        }

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
                        '<td class="tdWidth">'+
                            '<input name="cilindroscreate[]" id="cilindroscreate" type="number" class="num_cilin form-control form-control-sm numero-entero-positivo" placeholder="#">'+
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
                        '<td class="tdWidth">'+
                            '<input type="number" name="capacidadcreate[]" id="capacidadcreate"  class="form-control form-control-sm numero-entero-positivo" placeholder="0">'+
                        '</td>'+
                        '<td>'+
                            '<select name="unidad_medidacreate[]" id="unidad_medidacreate" class="form-control form-control-sm">'+
                                '<option value="" selected>Selecciona</option>'+
                                '<option value="CARGA">Carga</option>'+
                                '<option value="m3">m3</option>'+
                                '<option value="kg">kg</option>'+
                            '</select>'+
                        '</td>'+
                        '<td >'+
                            '<input type="number" name="precio_unitariocreate[]" id="precio_unitariocreate" class="form-control form-control-sm numero-decimal-positivo" placeholder="$0">'+
                        '</td>'+
                        '<td >'+
                            '<input type="number" min="0" step="0.01" class="dep_unit form-control form-control-sm numero-decimal-positivo" placeholder="$0" aria-label="Depósito unitario">'+
                        '</td>'+
                        '<td >'+
                            '<input type="number" name="deposito_garantiacreate[]" id="deposito_garantiacreate" class="dep_garanty form-control form-control-sm numero-decimal-positivo" placeholder="$0" readonly aria-label="Depósito total de la fila">'+
                        '</td>'+
                        '<td>'+
                            '<button type="button" class="btn btn-sm btn-amarillo btn-anadir-asignacioncreate" title="Agregar otra asignación" aria-label="Agregar otra asignación"><span class="fas fa-plus"></span></button>'+
                        '</td>'+
                        '<td>'+
                            '<button type="button" class="btn btn-sm btn-amarillo ml-1" id="btn-eliminar-filaasignacion" title="Eliminar esta asignación" aria-label="Eliminar esta asignación"><span class="fas fa-minus"></span></button>'+
                        '</td>'+
                    '</tr>'
                );

                actualizarTotalDeposito();
            });

        actualizarTotalDeposito();
        }
    });
</script>
