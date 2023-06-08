<form id="form-hours-available">
    @csrf
    <div class="row">
        <div class="col-12">
            <label for="">Tipo Operación</label>
            <input type="text" id="type-operation-edit" class="form-control" readonly >
        </div>
        <div class="col-12">
            <label for="">Horas Disponibles</label>
            <input type="text" id="hours-available-edit" class="form-control" disabled >
        </div>
        <div class="col-12">
            <label for="">Cantidad</label>
            <input type="number" id="quantity-hours-edit" class="form-control" >
        </div>
    </div>
    
    <hr>
    <div class="row">
        <div class="col d-flex">
            <label for="">Resultado:</label>
            <input type="text" id="result-operation-edit" name="result_operation_edit" class="form-control" readonly >
        </div>
    </div>
</form>

<script>
    $("#quantity-hours-edit").keyup(function (){
        let result = 0;
        let quantity = $("#quantity-hours-edit").val();
        let available = $('#hours-available-edit').val();

        if($('#type-operation-edit').val() == 'RESTA'){
            result =parseInt(available) - parseInt(quantity);
        }
        if($('#type-operation-edit').val() == 'SUMA'){
            result =parseInt(available) + parseInt(quantity);
        }

        $("#result-operation-edit").val(result);
    });

    $(document).on("click","#btn-change-hours", function (){
        $.ajax({
            method: "post",
            url: "/concentrators/update/hours/"+$("#concentrator_id").val(),
            data: $("#form-hours-available").serialize(),
        }).done(function (msg) {
            $("#hours-available").val(msg); 
            $("#quantity-hours-edit").val(0);
            $('#modal-hours').modal("hide");
            Swal.fire(
                'Exito',
                'Eliminado correctamente.',
                'success'
            )
        }).fail(function (){
            Swal.fire(
                'Error',
                'Verifica tus datos',
                'error'
            )
        });
    });
</script>