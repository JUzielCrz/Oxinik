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
            ajax: '/tanque/data',
            columns:[
                {data: 'num_serie', className: "text-center"},
                {data: 'ph', className: "text-center"},
                {data: 'fabricante', className: "text-center"},
                {data: 'material', className: "text-center"},
                {data: 'estatus', className: "text-center"}, //aqui va estatus
                {data: 'btnShow'},
                {data: 'btnEdit'},
                {data: 'btnHistory'},
                {data: 'btnBaja'},
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

    $(document).on("click","#btnaccept",function(){save_tanque("","create")});
    $(document).on("click",".btn-show-modal",metodo_detalle);
    $(document).on("click",".btn-edit-modal",metodo_detalle_edit);
    $(document).on("click",".btn-delete-modal", metodo_detalle_delete);
    $(document).on("click","#btneliminar",metodo_eliminar);
    $(document).on("click","#btnactualizar", function(){save_tanque("edit","update")});

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

    $("#unidadmedida").change( function() {
        if ($(this).val() == "Carga") {
            $("#capacidadnum").val(1);
            $("#capacidadnum").prop("disabled", true);
        } else {
            
            $("#capacidadnum").prop("disabled", false);
        }
    });

    $("#unidadmedidaedit").change( function() {
        if ($(this).val() == "Carga") {
            $("#capacidadnumedit").val(1);
            $("#capacidadnumedit").prop("disabled", true);
        } else {
            
            $("#capacidadnumedit").prop("disabled", false);
        }
    });

    function save_tanque(clave, accion, e) {

        metodo_limpiar_span("Error");

        var campo= [
            'num_serie',
            'unidadmedida',
            'capacidadnum',
            'material',
            'tipo_tanque',
            'estatus',
            'ph',
            'tipo_gas'];
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


        var fabri;
        if($("#fabricanteoficial"+clave).val() == "Otros"){
            fabri = $("#otrofabricante"+clave).val();
        }else{
            fabri = $("#fabricanteoficial"+clave).val();
        }

        if(fabri==""){
            $("#fabricante"+clave+"Error").text('Necesario');
            $("#otrofabricante"+clave).addClass('is-invalid');
            $("#fabricanteoficial"+clave).addClass('is-invalid');
            return false;
        }else{
            $("#fabricante"+clave+"Error").empty();
            $("#otrofabricante"+clave).removeClass('is-invalid');
            $("#fabricanteoficial"+clave).removeClass('is-invalid');
        }

        var cap=$('#capacidadnum'+clave).val()+' '+ $('#unidadmedida'+clave).val();
        if($('#capacidadnum'+clave).val()==''){
            $("#capacidad"+clave+"Error").text('El campo Capacidad es Obligatorio');
            return false;
        }

        var numserie= $('#num_serie'+clave).val().replace(/ /g,'');

        // method: "POST",
        //url: "updatetanque/"+$('#idedit').val()+'',
        var url_link="";
        if(accion=="update"){
            url_link="/tanque/update/"+$('#idedit').val();
        }else{
            url_link="/tanque/create";
        }
        $.ajax({
            method: "POST",
            url: url_link,
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#id'+clave).val(),
                'num_serie': numserie,
                'ph': $('#ph'+clave).val(),
                'capacidad': cap,
                'material': $('#material'+clave).val(),
                'fabricante': fabri,
                'tipo_gas': $('#tipo_gas'+clave).val(),
                'estatus': $('#estatus'+clave).val(),
                'tipo_tanque': $('#tipo_tanque'+clave).val(),
                },
        })
            .done(function (msg) {
                metodo_limpiar_campos();
                listtabla.ajax.reload(null,false);      
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modal-tanque"+clave);
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
        $("#tipo_tanque"+ nombreerror).empty();
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
        $("#tipo_tanque").val("");
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
        $.get('/tanque/show/' + $(this).data('id') + '', function(data) {
            $.each(data, function (key, value) {
                var variable = "#" + key + "info";
                $(variable).val(value);
            });
            $("#modalmostrar").modal("show");
        })
    }
    
    function metodo_detalle_edit() {
        metodo_limpiar_span("editError");
        $.get('/tanque/show/' + $(this).data('id') + '', function(data) {
            $.each(data, function (key, value) {
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

                    var cadenaarray = value.split(" ");
                    $('#unidadmedidaedit').val(cadenaarray[1]);
                    $('#capacidadnumedit').val(cadenaarray[0]);
                    if(cadenaarray[1] == "Carga"){
                        $("#capacidadnumedit").prop("disabled", true);
                    }
                    

                }
            });
        }).done(function (msg) {
            if(msg.accesso){
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-warning",null);
            }else{
                $("#modal-tanqueedit").modal("show");
            }
        });
    }
    

    function metodo_detalle_delete() {
                $("#modaleliminar").modal("show");
                $('#ideliminar').html($(this).data('id'));
    }
    
    function metodo_eliminar() {
        $.ajax({
            method: "POST",
            url: "/tanque/baja/"+$('#ideliminar').text()+'',
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
