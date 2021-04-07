
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
                <th>
                    CANTIDAD
                </th>
                <th>
                    TIPO GAS
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tbody-tr-asignacion1">
            
        </tbody>
        <tbody id="tbody-tr-asignacion">

        </tbody>
    </table>

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

            $.ajax({
            method: "get",
            url: "/catalogo_gases",
        }).done(function(msg){
            var opciones;
            opciones = '<option value="" selected>SELECCIONA</option>';
            $(msg).each(function(index, value){
                opciones += '<option value="'+value.id+'">'+ value.nombre +'</option>';
            });

            $('#tbody-tr-asignacion').append(
                '<tr class="trasignacion">'+
                    '<td>'+
                        '<input name="cantidadtanques[]" id="cantidadtanques" type="number" class="form-control form-control-sm" placeholder="#">'+
                    '</td> '+
                    '<td>'+
                        '<select name="tipo_gas[]" id="tipo_gas" class="form-control form-control-sm select-search">'+
                            opciones+
                        '</select>'+
                    '</td> '+
                    '<td>'+
                        '<button type="button" class="btn btn-sm btn-amarillo" id="btn-anadir-asignacion"><span class="fas fa-plus"></span></button>'+
                        '<button type="button" class="btn btn-sm btn-amarillo ml-1  " id="btn-eliminar-filaasignacion"><span class="fas fa-minus"></span></button>'+
                    '</td>'+
                '</tr>'
            );
            
        })

        }
    });
</script>