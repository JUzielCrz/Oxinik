
$(document).ready(function () {
    $(document).on("click","#btn-aceptar", acceptar);

    function acceptar() {
        var campo= [
            'monto_pago',
            'metodo_pago'
        ];
        var campovacio = [];

        $.each(campo, function(index){
            $('#'+campo[index]+'Error').empty();
            $('#'+campo[index]).removeClass('is-invalid');
        });

        $.each(campo, function(index){
            if($("#"+campo[index]).val()=='' || $("#"+campo[index]).val()<=0    ){
                campovacio.push(campo[index]);
            }
        });

        if(campovacio.length != 0){
            $.each(campovacio, function(index){
                $("#"+campovacio[index]).addClass('is-invalid');
                $("#"+campovacio[index]+'Error').text('Necesario');
                mensaje('error', 'Error', 'Faltan campor por rellenar', null );
            });
            return false;
        }

        if(parseInt($("#monto_pago").val()) > parseInt($("#adeudo").val())){
            mensaje('error', 'Error', 'Monto de pago no debe ser mayor a adeudo', null );
            return false;
        }

        $.ajax({
            method: "post",
            url: "/nota/pagos/create",
            data: {
                '_token': $('input[name=_token]').val(),
                'monto_pago': $('#monto_pago').val(),
                'tipo_gas': $('#metodo_pago').val(),
                'nota_id': $('#nota_id').val(),
                },
        }).done(function(msg){
            // limpiar_campos();
            mensaje('success','Exito','Registro creado correctamente', 1500);
        })
    }

    function mensaje(icono,titulo, mensaje, timer){
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: timer,
            width: 300,
        })
    }

});
