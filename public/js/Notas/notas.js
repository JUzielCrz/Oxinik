$(document).ready(function () {
    
    // Data Tables
        var numContrato=$('#num_contrato').val();

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
            ajax: '/dt_nota/'+numContrato,
            columns:[
                {data: 'folio_nota'},
                {data: 'fecha'},
                {data: 'pago_realizado'},
                {data: 'metodo_pago'},
                {data: 'num_contrato'},
                {data: 'btnShow'},
                {data: 'btnEdit'},
                {data: 'btnDelete'},
            ]
        });
    
    // CRUD

    metodo_limpiar_span("Error");

    $("input").focusout(function () {
        var value = $(this).val();
        if (value.length == 0) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    $(document).on("click",".btn-show-modal",metodo_detalle);
    $(document).on("click",".btn-edit-modal",metodo_detalle_edit);
    $(document).on("click",".btn-delete-modal", metodo_detalle_delete);
    $(document).on("click","#btneliminar", metodo_eliminar);
    $(document).on("click","#btnactualizar", metodo_actualizar);
    
    function metodo_limpiar_span(nombreerror) {
        $("#folio_nota"+ nombreerror).empty();
        $("#fecha"+ nombreerror).empty();
        $("#pago_realizado"+ nombreerror).empty();
        $("#metodo_pago"+ nombreerror).empty();
        $("#num_contrato"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos() {
        $("#folio_nota").val("");
        $("#fecha").val("");
        $("#pago_realizado").val("");
        $("#metodo_pago").val("");
        $("#num_contrato").val("");
    }
    
    function mostrar_mensaje(divmsg,mensaje,clasecss,modal) {
        if(modal !== null){
            $(modal).modal("hide");
        }
        $(divmsg).empty();
        $(divmsg).addClass(clasecss);
        $(divmsg).append("<p>" + mensaje + "</p>");
        $(divmsg).show(500);
        $.when($(divmsg).hide(5000)).done(function () {
            $(divmsg).removeClass(clasecss);
        });
    }
    
    
    function metodo_detalle() {
        $.get('/shownota/' + $(this).data('id') + '', function(data) {
            $.each(data.tanques, function (key, value) {
                var variable = "#" + key + "info";
                $(variable).val(value);
            });
        }).done(function (msg) {
            if(msg.accesso){
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-warning",null);
            }else{
                $("#modalmostrar").modal("show");
            }
        });;
        
    }
    
    function metodo_detalle_edit() {

        window.location = '/editnota/'+ $(this).data('id') 

        // metodo_limpiar_span("editError");
        // $.get('/shownota/' + $(this).data('id') + '', function(data) {
        //     $.each(data.tanques, function (key, value) {
        //         var variable = "#" + key + "edit";
        //         $(variable).val(value);
        //     });
        // }).done(function (msg) {
        //     if(msg.accesso){
        //         mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-warning",null);
        //     }else{
        //         $("#modalactualizar").modal("show");
        //     }
        // });
    }
    
    function metodo_actualizar(){
        
        // metodo_limpiar_span("editError");

        // $.ajax({
        //     method: "POST",
        //     url: "updatenota/"+$('#idedit').val()+'',
        //     data: {
        //         '_token': $('input[name=_token]').val(),
        //         'id': $('#idedit').val(),
        //         'folio_nota': $('#folio_notaedit').val(),
        //         'fecha': $('#fechaedit').val(),
        //         'pago_realizado': $('#pago_realizadoedit').val(),
        //         'metodo_pago': $('#metodo_pagoedit').val(),
        //         'num_contrato': $('#num_contratoedit').val(),
        //         },
        // })
        //     .done(function (msg) {
        //         listtabla.ajax.reload(null,false); 
        //         mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalactualizar");        

        //     }).fail(function (jqXHR, textStatus) {
        //         mostrar_mensaje("#divmsgedit",'Error al actualizar, verifique sus datos.', "alert-danger",null);
        //         var status = jqXHR.status;
        //         if (status === 422) {
        //             $.each(jqXHR.responseJSON.errors, function (key, value) {
        //                 var idError = "#" + key + "editError";
        //                 $(idError).text(value);
        //             });
        //         }
        //     });
        return false;
    }

    function metodo_detalle_delete() {
                $("#modaleliminar").modal("show");
                $('#ideliminar').html($(this).data('id'));
    }
    
    function metodo_eliminar() {
        $.ajax({
            method: "post",
            url: "deletenota/"+$('#ideliminar').text()+'',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#ideliminar').text()
                }
            
        }).done(function (msg) {
            listtabla.ajax.reload(null,false); 
            mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modaleliminar");
        }).fail(function (jqXHR, textStatus){
            mostrar_mensaje("#divmsgindex",'Error al eliminar.', "alert-danger",null);
        });       
    }


        

});
