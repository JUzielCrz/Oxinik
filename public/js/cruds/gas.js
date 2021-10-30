$(document).ready(function () {
    
    // Data Tables
        var listtabla = $('#tablecruddata').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            processing: true,
            serverSider: true,
            ajax: '/gas/data',
            columns:[
                {data: 'id'},
                {data: 'nombre'},
                {data: 'abreviatura'},
                {data: 'btnEdit'},
                {data: 'btnDestroy'},
            ]
        });


    $(document).on("click",".btn-edit-modal", show_gas);
    $(document).on("click","#btnaccept",function(){save_tanque("","create")});
    $(document).on("click","#btnactualizar", function(){save_tanque("edit","update")});
    $(document).on("click",".btn-delete-modal", delete_gas);


    function show_gas() {
        limpiar_span('edit');
        $.get('/gas/show/' + $(this).data('id') + '', function(data) {
            $.each(data, function (key, value) {
                var variable = "#" + key + "edit";
                $(variable).val(value);
            });
            $("#modal-tanqueedit").modal("show");
        })
    }


    function save_tanque(clave, accion, e) {
        var campo= [
            'nombre',
            'abreviatura'];
        var campovacio = [];

        $.each(campo, function(index){
            
            $('#'+campo[index]+clave+'Error').empty();
            $('#'+campo[index]+clave).removeClass('is-invalid');
        });

        $.each(campo, function(index){
            if($("#"+campo[index]+clave).val()=='' || $("#"+campo[index]+clave).val()<=0    ){
                campovacio.push(campo[index]);
            }
        });

        if(campovacio.length != 0){
            $.each(campovacio, function(index){
                $("#"+campovacio[index]+clave).addClass('is-invalid');
                $("#"+campovacio[index]+clave+'Error').text('Necesario');
            });
            return false;
        }

        var url_link="";
        if(accion=="update"){
            url_link="/gas/update/"+$('#idedit').val();
        }else{
            url_link="/gas/create";
        }
        $.ajax({
            method: "POST",
            url: url_link,
            data: {
                '_token': $('input[name=_token]').val(),
                'nombre': $('#nombre'+clave).val(),
                'abreviatura': $('#abreviatura'+clave).val(),
                },
        })
            .done(function (msg) {
                if(msg.mensaje == 'Sin permisos'){
                    mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, "#modal-tanque"+clave);
                    return false;
                }
                limpiar_campos();
                listtabla.ajax.reload(null,false);      
                mensaje("success","Exito", "Los datos se guardaron correctamente", 1800, "#modal-tanque"+clave);
            })
                
            .fail(function (jqXHR) {
                var status = jqXHR.status;
                if (status === 422) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        var idError = "#" + key +clave;
                        //$(idError).removeClass("d-none");
                        $(idError+ "Error").text(value);
                        $(idError).addClass('is-invalid')
                    });
                }
                mensaje("error","Error", "Verifica tus datos" ,false, "null");

            });
        return false;
    }

    function limpiar_campos() {
        $("#nombre").val("");
        $("#abreviatura").val("");
    }

    function limpiar_span(nombreerror) {
        $("#nombre"+ nombreerror +"Error").empty();
        $("#abreviatura"+ nombreerror+"Error").empty();
        $("#nombre"+ nombreerror).removeClass('is-invalid');
        $("#abreviatura"+ nombreerror).removeClass('is-invalid');
    }

    function mensaje(icono,titulo, mensaje, tiempo, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: tiempo,
            width: 300,
        })
    }

    function delete_gas() {

        Swal.fire({
            icon: "warning",
            title: 'Eliminar',
            text: '¿Estas seguro de eliminar?',
            showCancelButton: true,
            confirmButtonColor: '#f9c846',
            confirmButtonText: 'Aceptar',
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    method: "GET",
                    url: '/gas/delete/'+ $(this).data('id'),
                }).done(function (msg) {
                    if(msg.mensaje == 'Sin permisos'){
                        mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
                        return false;
                    }
                    listtabla.ajax.reload(null,false); 
                    Swal.fire('Exito!', '', 'success')
                }).fail(function (){
                    mensaje("error","Error", "Verifica tus datos" ,false, "null");
                });   
            } 
        })

    }

});