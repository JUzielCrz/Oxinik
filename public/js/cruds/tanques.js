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
            ajax: '/dt_tanque',
            columns:[
                {data: 'num_serie'},
                {data: 'ph'},
                {data: 'fabricante'},
                {data: 'estatus'}, //aqui va estatus
                {data: 'btnShow'},
                {data: 'btnEdit'},
                {data: 'btnHistory'},
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

    $(document).on("click","#btnaccept",metodo_insertar);
    $(document).on("click",".btn-show-modal",metodo_detalle);
    $(document).on("click",".btn-edit-modal",metodo_detalle_edit);
    $(document).on("click",".btn-delete-modal", metodo_detalle_delete);
    $(document).on("click","#btneliminar",metodo_eliminar);
    $(document).on("click","#btnactualizar",metodo_actualizar);

    $("#fabricanteoficial").change( function() {
        if ($(this).val() == "Otros") {
            $("#otrofabricante").prop("disabled", false);
        } else {
            $("#otrofabricante").prop("disabled", true);
            $("#otrofabricante").val('');
        }
    });
    $("#fabricanteoficialedit").change( function() {
        if ($(this).val() == "Otros") {
            $("#otrofabricanteedit").prop("disabled", false);
        } else {
            $("#otrofabricanteedit").prop("disabled", true);
            $("#otrofabricanteedit").val('');
        }
    });

    function metodo_insertar() {
        metodo_limpiar_span("Error");

        var fabri;
        if($("#fabricanteoficial").val() == "Otros"){
            fabri = $("#otrofabricante").val();
        }else{
            fabri = $("#fabricanteoficial").val();
        }

        var cap=$('#capacidadnum').val()+' '+ $('#unidadmedida').val();
        if($('#capacidadnum').val()==''){
            $("#capacidadError").text('El campo Capacidad es Obligatorio');
            return false;
        }

        $.ajax({
            method: "POST",
            url: "/newtanque",
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#id').val(),
                'num_serie': $('#num_serie').val(),
                'ph': $('#ph').val(),
                'capacidad': cap,
                'material': $('#material').val(),
                'fabricante': fabri,
                'tipo_gas': $('#tipo_gas').val(),
                'estatus': $('#estatus').val(),
                },
        })
            .done(function (msg) {
                metodo_limpiar_campos();
                listtabla.ajax.reload(null,false);      
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalinsertar");
            })
                
            .fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsg",'Error, verifique sus datos.', "alert-danger",null);
                var status = jqXHR.status;
                if (status === 422) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        var idError = "#" + key + "Error";
                        //$(idError).removeClass("d-none");
                        $(idError).text(value);
                    });
                }
            });
        return false;
    }
    
    function metodo_limpiar_span(nombreerror) {
        $("#num_serie"+ nombreerror).empty();
        $("#ph"+ nombreerror).empty();
        $("#capacidad"+ nombreerror).empty();
        $("#material"+ nombreerror).empty();
        $("#fabricante"+ nombreerror).empty();
        $("#tipo_gas"+ nombreerror).empty();
        $("#estatus"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos() {
        $("#num_serie").val("");
        $("#ph").val("");
        $("#capacidadnum").val("");
        $("#material").val("");
        $("#fabricanteoficial").val("");
        $("#otrofabricante").val("");
        $("#tipo_gas").val("");
        $("#estatus").val("");
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
        $.get('/showtanque/' + $(this).data('id') + '', function(data) {
            $.each(data.tanques, function (key, value) {
                var variable = "#" + key + "info";
                $(variable).val(value);
            });
            $("#modalmostrar").modal("show");
        })
    }
    
    function metodo_detalle_edit() {
        metodo_limpiar_span("editError");
        $.get('/showtanque/' + $(this).data('id') + '', function(data) {
            $.each(data.tanques, function (key, value) {
                var variable = "#" + key + "edit";
                $(variable).val(value);
                if(key == 'fabricante'){
                    if(value == 'Infra' || value == 'Plaxair'){
                        $('#fabricanteoficialedit').val(value);
                        $("#otrofabricanteedit").val('');
                        $("#otrofabricanteedit").prop("disabled", true);
                    }else{
                        $('#fabricanteoficialedit').val('Otros');
                        $("#otrofabricanteedit").val(value);
                        $("#otrofabricanteedit").prop("disabled", false);
                    }
                }
                if(key == 'capacidad'){
                    if(value.includes('m3')){
                        $('#unidadmedidaedit').val('m3');
                        $('#capacidadnumedit').val(value.replace(' m3',''));
                    }else{
                        $('#unidadmedidaedit').val('kilos');
                        $('#capacidadnumedit').val(value.replace(' kilos',''));

                    }
                }
            });
        }).done(function (msg) {
            if(msg.accesso){
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-warning",null);
            }else{
                $("#modalactualizar").modal("show");
            }
        });
    }
    
    function metodo_actualizar(){
        metodo_limpiar_span("editError");

        var fabri;
        if($("#fabricanteoficialedit").val() == "Otros"){
            fabri = $("#otrofabricanteedit").val();
        }else{
            fabri = $("#fabricanteoficialedit").val();
        }

        var cap=$('#capacidadnumedit').val()+' '+ $('#unidadmedidaedit').val();
        
        if($('#capacidadnumedit').val()==''){
            $("#capacidadeditError").text('El campo Capacidad es Obligatorio');
            return false;
        }

        $.ajax({
            method: "POST",
            url: "updatetanque/"+$('#idedit').val()+'',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#idedit').val(),
                'num_serie': $('#num_serieedit').val(),
                'ph': $('#phedit').val(),
                'capacidad': cap,
                'material': $('#materialedit').val(),
                'fabricante': fabri,
                'tipo_gas': $('#tipo_gasedit').val(),
                'estatus': $('#estatusedit').val(),
                },
        })
            .done(function (msg) {
                listtabla.ajax.reload(null,false); 
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalactualizar");        

            }).fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsgedit",'Error al actualizar, verifique sus datos.', "alert-danger",null);
                var status = jqXHR.status;
                if (status === 422) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        var idError = "#" + key + "editError";
                        $(idError).text(value);
                    });
                }
            });
        return false;
    }

    function metodo_detalle_delete() {
                $("#modaleliminar").modal("show");
                $('#ideliminar').html($(this).data('id'));
    }
    
    function metodo_eliminar() {
        $.ajax({
            method: "POST",
            url: "deletetanque/"+$('#ideliminar').text()+'',
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


    //Para Validar Campos

        $('.telefono').keypress(function (event) {
            if (this.value.length === 10) {
                return false;
            }
        });

        $('.solo-text').keypress(function (event) {
            // console.log(event.charCode);
            if (event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122 || 
                event.charCode ==  32 ||
                event.charCode == 193 || 
                event.charCode == 201 ||
                event.charCode == 205 || 
                event.charCode == 211 || 
                event.charCode == 218 || 
                event.charCode == 225 || 
                event.charCode == 233 ||
                event.charCode == 237 || 
                event.charCode == 243 ||
                event.charCode == 250 ||
                event.charCode == 241 ||
                event.charCode == 209  ){
                return true;
            } 
            return false;
        });


        

});
