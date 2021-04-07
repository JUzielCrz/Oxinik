<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>

  <form id="idFormContrato">
    @csrf
    <label class="text-danger">* OBLIGATORIO </label>
    <hr>

        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('Número de Contrato*') !!}
                {!! Form::number('num_contrato', null, ['id'=>'num_contrato', 'class' => 'form-control', 'placeholder'=>'Número de Contrato', 'required' ]) !!}
            <span  id="num_contratoError" class="text-danger"></span>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('Tipo de Contrato*') !!}
                {{ Form::select('tipo_contrato',['PERMANENTE INDUSTRIAL' => 'PERMANENTE INDUSTRIAL', 
                                                'PERMANENTE MEDICINAL' => 'PERMANENTE MEDICINAL',  
                                                'EVENTUAL' => 'EVENTUAL' 
                                                ],null,['id' => 'tipo_contrato','class'=>'form-control', 'placeholder'=>'Selecciona'])}}
                <span  id="tipo_contratoError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('Precio Transporte*') !!}
                {!! Form::number('precio_transporte', null, ['id'=>'precio_transporte', 'class' => 'form-control', 'placeholder'=>'$0.0']) !!}
                <span  id="precio_transporteError" class="text-danger"></span>
            </div>
        </div>
        
        

        <div class="form-row">
            <div class="col-md-12">
                <label for="">Dirección</label>
                <textarea name="direccion" id="direccion" class="form-control" cols="30" rows="2"></textarea>
            </div>
            <div class="col-md-12">
                <label for="">Referencia</label>
                <textarea name="referencia" id="referencia" class="form-control" cols="30" rows="2"></textarea>
            </div>
        </div>
        
        <hr>
        
        <div class="form-row">
                <p>Asignación tanques</p>
        </div>

        <div class="form-row">
            <table class="table table-sm" id="table-asignaciones" style="font-size: 13px">
                <thead>
                    <tr>
                        <th>
                            CANTIDAD
                        </th>
                        <th>
                            TIPO GAS
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="trasignacion">
                        <td>
                            <input name="cantidadtanquescreate[]" id="cantidadtanquescreate" type="number" class="form-control form-control-sm"  placeholder="#">
                        </td>
                        <td>
                            <select name="tipo_gascreate[]" id="tipo_gascreate" class="form-control form-control-sm">
                                <option value="" selected>SELECCIONA</option>
                                @foreach ($catalogogas as $gas)
                                    <option value={{$gas->id}}>{{$gas->nombre}}</option>
                                @endforeach </select>
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

            $.ajax({
            method: "get",
            url: "/catalogo_gases",
            })
            .done(function(msg){
                var opciones;
                opciones = '<option value="" selected>SELECCIONA</option>';
                $(msg).each(function(index, value){
                    opciones += '<option value="'+value.id+'">'+ value.nombre +'</option>';
                });

                $('#tbody-tr-asignacioncreate').append(
                        '<tr class="trasignacion">'+
                            '<td>'+
                                '<input name="cantidadtanquescreate[]" id="cantidadtanquescreate" type="number" class="form-control form-control-sm" placeholder="#">'+
                            '</td> '+
                            '<td>'+
                                '<select name="tipo_gascreate[]" id="tipo_gascreate" class="form-control form-control-sm select-search">'+
                                    opciones+
                                '</select>'+
                            '</td> '+
                            '<td>'+
                                '<button type="button" class="btn btn-sm btn-amarillo" id="btn-anadir-asignacioncreate"><span class="fas fa-plus"></span></button>'+
                                '<button type="button" class="btn btn-sm btn-amarillo ml-1  " id="btn-eliminar-filaasignacion"><span class="fas fa-minus"></span></button>'+
                            '</td>'+
                        '</tr>'
                );
            })
        }
    });
</script>
