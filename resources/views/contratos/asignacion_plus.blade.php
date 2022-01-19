<style>
    .tdWidth{
        width: 60px;
        overflow: auto;
    }
</style>
<div id="show-asignaciones">
</div>

<form id="form-asignacion-plus">
    @csrf
    <span>TANQUES ASIGNADOS</span>
    <div class="table-responsive">
        <table class="table table-sm" id="table-asignaciones" style="font-size: 13px; background: #E4E4E4">
            <thead class="bg-gris">
                <tr>
                    <th>CILINDROS</th>
                    <th>GAS</th>
                    <th>TIPO</th>
                    <th>MATERIAL</th>
                    <th>CAPACIDAD</th>
                    <th>U.M.</th>
                    <th>PRECIO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody-asignaciones-anteriores">
            </tbody>
        </table>
    </div>

    <hr>
    <span>AUMENTOS</span>
    
    <div class="table-responsive" >
        <table class="table table-sm" style="font-size: 13px;">
            <thead>
                <tr>
                    <th>CILINDROS</div></th>
                    <th>GAS</th>
                    <th>TIPO</th>
                    <th>MATERIAL</th>
                    <th>CAPACIDAD</th>
                    <th>U.M.</th>
                    <th>PRECIO</th>
                    <th>DEP.GRNT.</th>
                    <th></th>
                </tr>
            </thead>
            <span id="alerta-tanques"></span>
            <center>
                <div id="msg-modal-asignacion" style="display:none" class="alert" role="alert">
                </div>
            </center>        
            <tbody id="tbody-asignacion-plus" style="background: #E4E4E4">
            </tbody>

            <tbody>
                <tr>
                    <td colspan="9" class="text-right"> <button type="button" class="btn btn-amarillo btn-sm" id="btn-anadir-asignacion"><span class="fas fa-plus"></span>Añadir</button></td>
                </tr>
            </tbody>
        </table>
    </div>
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

            $('#tbody-asignacion-plus').append(
                '<tr class="tr-asignacion-plus"><td class="tdWidth">'+
                '<input name="asignacion_variante[]" id="asignacion_variante" type="number" class="form-control form-control-sm  numero-entero-positivo" placeholder="0"></td><td style="width: 120px;">'+
                '<select name="asignacion_gas[]" id="asignacion_gas" class="form-control form-control-sm select-search">'+opcionesGas+'</select></td><td>'+
                '<select name="asignacion_tipo_tanque[]" id="asignacion_tipo_tanque" class="form-control form-control-sm select-search">'+opcionesContrato+'</select></td><td>'+
                '<select name="asignacion_material[]" id="asignacion_material" class="form-control form-control-sm select-search"><option value="Acero">Acero</option><option value="Aluminio">Aluminio</option></select></td><td class="tdWidth">'+
                '<input name="asignacion_capacidad[]" id="asignacion_capacidad" type="number" class="form-control form-control-sm numero-entero-positivo" placeholder="0"></td><td>'+
                '<select name="asignacion_unidad_medida[]" id="asignacion_unidad_medida" class="form-control form-control-sm select-search">'+
                    '<option value="" selected>Selecciona</option>'+
                    '<option value="Carga">Carga</option>'+
                    '<option value="m3">m3</option>'+
                    '<option value="kg">kg</option>'+
                '</select></td><td >'+
                '<input name="asignacion_precio_unitario[]" id="asignacion_precio_unitario" type="number" class="form-control form-control-sm numero-decimal-positivo" placeholder="$0.0"></td><td >'+
                '<input name="asignacion_deposito_garantia[]" id="asignacion_deposito_garantia" type="number" class="form-control form-control-sm numero-decimal-positivo" value="0"></td><td >'+
                '<button type="button" class="btn btn-sm btn-amarillo ml-1  " id="btn-eliminar-filaasignacion"><span class="fas fa-minus"></span></button></td>'+
                '</tr>'
            );
            
        })

        }
    });

</script>