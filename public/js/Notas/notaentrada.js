$(document).ready(function () {
//BUSCAR CONTRATO

    $('#search-cliente-id').keyup(function(){ 
        var query = $(this).val();
        
        if(query != '')
        {
            $.ajax({
                method: "POST",
                url:"notasalida/searchcliente",
                data:{'query':query,'_token': $('input[name=_token]').val(),},
                success:function(data){

                    $('#listar-clientes').fadeIn();  
                    $('#listar-clientes').html(data);

                }
            });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#listar-clientes').fadeOut();  
        const clienteId = $(this).text().split(', ');

        $.ajax({
            method: "post",
            url: "/datacontrato/"+clienteId[0],
            data: {'_token': $('input[name=_token]').val(),},
        })
        .done(function(msg) {
            console.log(msg);
            // $('#contrato_id').val(msg.contrato.contrato_id)
            // $('#num_contrato').val(msg.contrato.num_contrato)
            // $('#nombre_cliente').val(msg.contrato.nombre+' '+msg.contrato.apPaterno+' '+msg.contrato.apMaterno)
            // $('#tipo_contrato').val(msg.contrato.tipo_contrato)
            // $('#asignacion_tanques').val(msg.num_asignacion.num_asignacion)

            // show_table_asignaciones(msg.contrato.contrato_id, 'tableasignaciones', 'content-asignaciones');
        })

        // $("#InputsFilaSalida").prop("disabled", false);

        // $('#numcontrato').val('');
        
        // if($("#input-group-envio").length){
        //     removeenvio(); 
        // }
        
    }); 
//FIN BUSCAR CONTRATO

});




