
<div id="show-asignaciones">
    
</div>

<form id="form-edit-asignacion">
    <center>
        <div id="msg-modal-asignacion" style="display:none" class="alert" role="alert">
        </div>
    </center>

    @csrf
    <input type="hidden" name="incidencia-asignacion" id="incidencia-asignacion">
    <table class="table table-sm" id="table-asignaciones">
        <thead>
            <tr>
                <th>CILINDROS</th>
                <th><div id="columnaopcion"></div></th>
                <th>GAS</th>
                <th>TIPO</th>
                <th>MATERIAL</th>
                <th>P.U.</th>
                <th>U.M.</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tbody-tr-asignacion">
        </tbody>
        <tbody>
            <tr>
                <td id="td-btn-anadir"></td>
            </tr>
        </tbody>
    </table>

    <hr>
    <div id="div-garantia"></div>
</form>

<script>
    $(document).ready(function () {
        $(document).on("click","#btn-anadir-asignacion", aniadir);
        $(document).on("click","#btn-eliminar-filaasignacion", removefilaasignacion);
        
        function removefilaasignacion(){
            $(this).closest('tr').remove();
        }

        $(document).on('click', '.borrar', function (event) {
            event.preventDefault();
            $(this).closest('tr').remove();
        });


        function aniadir(){
        var opcionesContrato='';
        if($('#tipo_contratoShow').val()=='Industrial'){
            opcionesContrato= '<option value="Industrial" selected>Industrial</option>';
        };
        if($('#tipo_contratoShow').val()=='Medicinal'){
            opcionesContrato= '<option value="Medicinal" selected>Medicinal</option>';
        };
        if($('#tipo_contratoShow').val()=='Eventual'){
            opcionesContrato= '<option value="" selected>Selecciona</option><option value="Industrial">Industrial</option><option value="Medicinal" >Medicinal</option>';
        };

        $.ajax({
            method: "get",
            url: "/catalogo_gases",
        }).done(function(msg){
            var opcionesGas;
            opcionesGas = '<option value="" selected>Selecciona</option>';
            $(msg).each(function(index, value){
                opcionesGas += '<option value="'+value.id+'">'+ value.nombre +'</option>';
            });

            $('#tbody-tr-asignacion').append(
                '<tr class="trasignacion"><td>'+
                '<input type="number" class="form-control form-control-sm" value="0" disabled></td><td>'+
                '<input name="asignacion_variante[]" id="asignacion_variante" type="number" class="form-control form-control-sm  numero-entero-positivo" ></td><td>'+
                '<select name="asignacion_gas[]" id="asignacion_gas" class="form-control form-control-sm select-search">'+opcionesGas+'</select></td><td>'+
                '<select name="asignacion_tipo_tanque[]" id="asignacion_tipo_tanque" class="form-control form-control-sm select-search">'+opcionesContrato+'</select></td><td>'+
                '<select name="asignacion_material[]" id="asignacion_material" class="form-control form-control-sm select-search"><option value="Acero">Acero</option><option value="Aluminio">Aluminio</option></select></td><td>'+
                '<input name="asignacion_precio_unitario[]" id="asignacion_precio_unitario" type="number" class="form-control form-control-sm numero-decimal-positivo" placeholder="$0.0"></td><td>'+
                '<select name="asignacion_unidad_medida[]" id="asignacion_unidad_medida" class="form-control form-control-sm select-search">'+
                    '<option value="" selected>Selecciona</option>'+
                    '<option value="Carga">Carga</option>'+
                    '<option value="m3">m3</option>'+
                    '<option value="kg">kg</option>'+
                '</select></td><td>'+
                '<button type="button" class="btn btn-sm btn-amarillo ml-1  " id="btn-eliminar-filaasignacion"><span class="fas fa-minus"></span></button></td>'+
                '</tr>'
            );
            
        })

        }
    });

</script>