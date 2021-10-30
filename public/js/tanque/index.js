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
    $(document).on("click","#add-cilindro", nuevo_cilindro);

    $(document).on("click","#btnaccept",function(){save_tanque("","create")});
    $(document).on("click",".btn-show-modal",metodo_detalle);
    $(document).on("click",".btn-edit-modal",metodo_detalle_edit);
    $(document).on("click",".btn-delete-modal", metodo_detalle_delete);
    $(document).on("click","#btneliminar", baja_tanque);
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

    function nuevo_cilindro() {
        var numserie= $('#serie_tanque').val().replace(/ /g,'');

        $("#serie_tanque").removeClass('is-invalid');
        $("#serie_tanqueError").empty();
        if($("#serie_tanque").val()==""){
            $("#serie_tanque").addClass('is-invalid');
            $("#serie_tanqueError").text('Campo número de serie necesario');
            return false;
        }
        $.get('/tanque/show_numserie/' + numserie, function(data) {
            if(data==''){
                $("#num_serie").val(numserie);
                $("#modal-tanque").modal("show");
                return false;
            }else{
                mensaje('error', 'Alerta', 'Este tanque ya esta registrado', null, null)
                return false;
            }
        });
    }
    function save_tanque(clave, accion, e) {

        metodo_limpiar_span("Error");

        var campo= [
            'num_serie',
            'unidadmedida',
            'capacidadnum',
            'material',
            'tipo_tanque',
            'estatus',
            'ph_anio',
            'ph_mes',
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

        $("#ph"+clave+"Error").empty();
        $("#ph_anio"+clave).removeClass('is-invalid');
        if($('#ph_anio'+clave).val()<1950){
            $("#ph"+clave+"Error").text('Campo Incorrecto');
            $("#ph_anio"+clave).addClass('is-invalid');
            return false;
        }

        var numserie= $('#num_serie'+clave).val().replace(/ /g,'');

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
                'ph': $('#ph_anio'+clave).val()+'-'+$('#ph_mes'+clave).val() ,
                'capacidad': cap,
                'material': $('#material'+clave).val(),
                'fabricante': fabri,
                'tipo_gas': $('#tipo_gas'+clave).val(),
                'estatus': $('#estatus'+clave).val(),
                'tipo_tanque': $('#tipo_tanque'+clave).val(),
                },
        })
            .done(function (msg) {
                if(msg.mensaje == 'Sin permisos'){
                    mensaje("error","Sin permisos", "No tienes los permisos suficientes para realizar esta acción.", null, null);
                    return false;
                }
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
        $("#ph_mes").val("");
        $("#ph_anio").val("");
        $("#unidadmedida").val("");
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
            var separarph = data.ph.split("-");
            $('#ph_anioedit').val(separarph[0]);
            $('#ph_mesedit').val(separarph[1]);

            if(data.fabricante == 'Infra' || data.fabricante == 'Praxair'){
                $('#fabricanteoficialedit').val(data.fabricante);
                $("#otrofabricanteedit").val('');
                $("#otrofabricanteedit").prop("disabled", true);
            }else{
                $('#fabricanteoficialedit').val('Otros');
                $("#otrofabricanteedit").val(data.fabricante);
                $("#otrofabricanteedit").prop("disabled", false);
            }

            var cadenaarray = data.capacidad.split(" ");
            $('#unidadmedidaedit').val(cadenaarray[1]);
            $('#capacidadnumedit').val(cadenaarray[0]);
            if(cadenaarray[1] == "Carga"){
                $("#capacidadnumedit").prop("disabled", true);
            }

            $.each(data, function (key, value) {
                var variable = "#" + key + "edit";
                $(variable).val(value);

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
    
    function  baja_tanque() {
        $.ajax({
            method: "get",
            url: "/tanque/baja/"+$('#ideliminar').text()+'',
        }).done(function (msg) {
            if(msg.mensaje == 'Sin permisos'){
                mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
                return false;
            }
            listtabla.ajax.reload(null,false); 
            mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modaleliminar");
        }).fail(function (jqXHR, textStatus){
            mostrar_mensaje("#divmsgindex",'Error al eliminar.', "alert-danger",null);
        });       
    }


    //Para Validar Campos

        $('.anio_format').keypress(function (event) {
            if (this.value.length === 4||
                event.charCode == 43 || //+
                event.charCode == 45 || //-
                event.charCode == 69 || //E
                event.charCode == 101|| //e
                event.charCode == 46    //.
                ) {
                return false;
            }
        });

});
