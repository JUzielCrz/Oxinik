$(document).ready(function () {

    // CRUD
    metodo_limpiar_span("Error");

    // $("input").focusout(function () {
    //     var value = $(this).val();
    //     if (value.length == 0) {
    //         $(this).addClass("is-invalid");
    //     } else {
    //         $(this).removeClass("is-invalid");
    //     }
    // });

    $(document).on("click","#btnaccept",metodo_insertar);
    $(document).on("click","#btn-edit-modal",metodo_detalle_edit);
    $(document).on("click",".btn-delete-modal", metodo_detalle_delete);
    $(document).on("click","#btneliminar",metodo_eliminar);
    $(document).on("click","#btnactualizar",metodo_actualizar);

    // $(document).on("click","#btncontrato", insertartabla);
    $(document).on("click",".btnnota-edit", nota_edit);
    $(document).on("click",".btnnota-delete-modal", nota_detalle_delete);
    $(document).on("click","#btnnotaeliminar", nota_eliminar);
    $(document).on("click",".btnnota-devolucion", nota_devolucion);
    



    $('#table-contratos').on('click','tr', function(evt){

        var contrato_id=$(this).data('id');
        

        $.get('/contrato/show/' + contrato_id + '', function(data) {
            $.each(data.contratos, function (key, value) {
                var variable = "#" + key + "Show";
                $(variable).val(value);
            });
            $("#btn-edit-modal").val(contrato_id);
            show_table_asignaciones(contrato_id, 'tableasignaciones', 'content-asignaciones');
        })

        

        $('#filatabla').remove();
        $('#cardtablas').append(
        "<div id='filatabla'>"+
                "<div class='table-responsive' style='font-size:12px'>"+ 
                    "<table id='tablecruddata' class='table table-sm  table-hover' style='font-size:12px'>"+
                        "<thead>"+
                            "<tr style='background: #fff; color: black'>"+
                                "<th scope='col'>Fecha</th>"+
                                "<th scope='col'>Envio</th>"+
                                "<th scope='col'>Total</th>"+
                                "<th scope='col'>Metodo Pago</th>"+
                                "<th scope='col'>Pagado</th>"+
                                "<th scope='col'>"+"</th>"+
                                // "<th scope='col'>"+"</th>"+ 
                                // "<th scope='col'>"+"</th>"+ 
                            "</tr>"+
                        "</thead>"+
                    "</table>"+
                "</div>"+
            "</div>"
        ); 

        $('#tablecruddata').DataTable({
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
            ajax: '/nota/data/'+contrato_id,
            columns:[
                {data: 'fecha'},
                {data: 'envio'},
                {data: 'total'},
                {data: 'metodo_pago'},
                {data: 'pago_cubierto'},
                {data: 'btnPDF'},
                // {data: 'btnEdit'},
                // {data: 'btnDelete'},
            ]
        });
    });


    function metodo_insertar() {
        metodo_limpiar_span("Error");

        var campo=['num_contrato','deposito_garantia', 'precio_transporte'];
        var camponombre=['# contrato','Deposito de garantia', 'Precio de transporte'];
        var bandera=false;

        $.each(campo, function(index){
            if($('#'+campo[index]).val() < 0 || $('#'+campo[index]).val() == ""){
                $('#'+campo[index]+'Error').text(camponombre[index]+" invalido");
                $('#'+campo[index]).addClass("is-invalid");
                bandera=true;
            }else{
                $('#'+campo[index]+'Error').empty();
                $('#'+campo[index]).removeClass("is-invalid");
            }
        });
        if(bandera){
            return false;
        }


        var banderamensaje=false;
        var banderamensaje2=false;
        $("input[name='cilindroscreate[]']").each(function(indice, elemento) {
            if($(elemento).val()=="" || $(elemento).val() < 1){
                $(elemento).addClass("is-invalid");
                banderamensaje=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });

        $("input[name='precio_unitariocreate[]']").each(function(indice, elemento) {
            if($(elemento).val()=="" || $(elemento).val() < 1){
                $(elemento).addClass("is-invalid");
                banderamensaje=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });

        $("select[name='tipo_gascreate[]']").each(function(indice, elemento) {
            if($(elemento).val()==""){
                $(elemento).addClass("is-invalid");
                banderamensaje2=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        $("select[name='materialcreate[]']").each(function(indice, elemento) {
            if($(elemento).val()==""){
                $(elemento).addClass("is-invalid");
                banderamensaje2=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        $("input[name='capacidadcreate[]']").each(function(indice, elemento) {
            if($(elemento).val()=="" || $(elemento).val() < 1){
                $(elemento).addClass("is-invalid");
                banderamensaje=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        $("select[name='unidad_medidacreate[]']").each(function(indice, elemento) {
            if($(elemento).val()==""){
                $(elemento).addClass("is-invalid");
                banderamensaje2=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        $("#msg-alert-asignacion").empty();
        if(banderamensaje){
            $("#msg-alert-asignacion").append(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                    ' Cilindros o precio unitario invalidos.'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                    '<span aria-hidden="true">&times;</span>'+
                '</button>'+
                '</div>'
            );
        }

        if(banderamensaje2){
            $("#msg-alert-asignacion").append(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                    'Faltan campos por rellenar.'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                    '<span aria-hidden="true">&times;</span>'+
                '</button>'+
                '</div>'
            );
        }
        if(banderamensaje || banderamensaje2){
            return false;
        }

        var dataForm= $("#idFormContrato").serialize()+'&cliente_id=' +  $('#cliente_id').val();
        $.ajax({
            method: "POST",
            url: "/contrato/create",
            data: dataForm,
        })
            .done(function (msg) {
                if(msg.mensaje == 'Sin permisos'){
                    mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null,null);
                    return false;
                }
                if(msg.alert == 'alert-danger'){
                    mostrar_mensaje("#divmsg",msg.mensaje, "alert-danger",null);
                }else{
                    metodo_limpiar_campos();
                    $('#tableinsertfila').append(
                        "<tr class='fila"+ msg.contratos.id+"' data-id='"+msg.contratos.id+"'>"+
                            "<td class='text-center'>"+msg.contratos.num_contrato +"</td>"+
                            "<td class='text-center'>"+msg.contratos.tipo_contrato +"</td>"+
                            "<td><a class='btn btn-amarillo btn-sm' target='_blank' href='/pdf/generar_contrato/"+msg.contratos.id+"'   title='Contrato'><i class='fas fa-file-pdf'></i></span></a></td>"+
                            "<td><button class='btn btn-amarillo btn-delete-modal btn-sm' data-id='"+msg.contratos.id+"'><span class='fas fa-trash'></span></button></td>"+
                        "</tr>"); 
                    mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalinsertar");
                    window.open("/pdf/generar_contrato/"+ msg.contratos.id, '_blank');
                }
                
                
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
        $("#num_contrato"+ nombreerror).empty();
        $("#tipo_contrato"+ nombreerror).empty();
        $("#asignacion_tanques"+ nombreerror).empty();
        $("#precio_transporte"+ nombreerror).empty();
        $("#deposito_garantia"+ nombreerror).empty();
        $("#direccion"+ nombreerror).empty();
        $("#referencia"+ nombreerror).empty();
        $("#link_ubicacion"+ nombreerror).empty();
        $("#reguladores"+ nombreerror).empty();
        $("#deposito_garantia"+ nombreerror).empty();
        $("#observaciones"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos() {
        $("#num_contrato").val("");
        $("#nombre").val("");
        $("#tipo_contrato").val("");
        $("#asignacion_tanques").val("");
        $("#precio_transporte").val("");
        $("#direccion").val("");
        $("#referencia").val("");
        $("#link_ubicacion").val("");
        $("#reguladores").val("");
        $("#deposito_garantia").val("");
        $("#observaciones").val("");

        $("#tbody-tr-asignacioncreate").empty();

        $("input[name='cilindroscreate[]']").val("");
        $("select[name='tipo_gascreate[]']").val("");
        $("select[name='tipo_tanquecreate[]']").val("");
        $("select[name='tipo_tanquecreate[]']").empty();
        $("select[name='materialcreate[]']").val("");
        $("input[name='precio_unitariocreate[]']").val("");
        $("select[name='capacidadcreate[]']").val("");
        $("select[name='unidad_medidacreate[]']").val("");
    }
    
    function mostrar_mensaje(divmsg,mensaje,clasecss,modal) {
        if(modal !== null){
            $(modal).modal("hide");
        }
        $(divmsg).empty();
        $(divmsg).addClass(clasecss);
        $(divmsg).append("<p>" + mensaje + "</p>");
        $(divmsg).show(500);
        $.when($(divmsg).hide(8000)).done(function () {
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

    function metodo_detalle_edit() {
        metodo_limpiar_span("editError");
        var numcontrato= $("#btn-edit-modal").val();
        $.get('/contrato/show/' + numcontrato, function(data) {
            $.each(data.contratos, function (key, value) {
                var variable = "#" + key + "edit";
                $(variable).val(value);
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
        $.ajax({
            method: "POST",
            url: "/contrato/update/"+$('#idedit').val()+'',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#idedit').val(),
                'num_contrato': $('#num_contratoedit').val(),
                'cliente_id': $('#cliente_id').val(),
                'nombre': $('#nombreedit').val(),
                'tipo_contrato': $('#tipo_contratoedit').val(),
                'precio_transporte': $('#precio_transporteedit').val(),
                'direccion': $('#direccionedit').val(),
                'referencia': $('#referenciaedit').val(),
                'link_ubicacion': $('#link_ubicacionedit').val(),
                },
        })
            .done(function (msg) {
                if(msg.mensaje == 'Sin permisos'){
                    mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
                    return false;
                }
                $('.fila'+ msg.contratos.id).replaceWith(" "+
                    "<tr class='fila"+ msg.contratos.id+"'>"+
                    "<td class='text-center'>"+msg.contratos.num_contrato +"</td>"+
                    "<td class='text-center'>"+msg.contratos.tipo_contrato +"</td>"+
                    "<td><a class='btn btn-amarillo btn-delete-modal btn-sm ' data-id='"+msg.contratos.id+"'>"+
                    "<i class='fas fa-trash'></i>"+
                    "</a></td>"+
                    "</tr>");

                    $('#num_contratoShow').val(msg.contratos.num_contrato),
                    $('#tipo_contratoShow').val(msg.contratos.tipo_contrato),
                    $('#precio_transporteShow').val(msg.contratos.precio_transporte),
                    $('#direccionShow').val(msg.contratos.direccion),
                    $('#referenciaShow').val(msg.contratos.referencia),
                    $('#link_ubicacionShow').val(msg.contratos.link_ubicacion),
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
            method: "get",
            // route: 'contrato.destroy',
            url: "/contrato/destroy/"+$('#ideliminar').text()+'',
            
        }).done(function (msg) {
            if(msg.mensaje == 'Sin permisos'){
                mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
                return false;
            }
            $('.fila' + $('#ideliminar').text()).remove();
            mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modaleliminar");
        }).fail(function (jqXHR, textStatus){
            mostrar_mensaje("#divmsgindex",'Error al eliminar.', "alert-danger",null);
        });       
    }


    //METODOS DE NOTAS 

    function nota_edit() {
        window.location = '/editnota/'+ $(this).data('id') 
    }

    function nota_devolucion() {
        window.location = '/devolucionnota/'+ $(this).data('id') 
    }



    //Para Validar Campos

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

    function nota_detalle_delete() {
        $("#modaleliminarnota").modal("show");
        $('#ideliminar').html($(this).data('id'));
    }

    function nota_eliminar() {
    $.ajax({
        method: "post",
        url: "deletenota/"+$('#ideliminar').text()+'',
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#ideliminar').text()
            }
        
    }).done(function (msg) {
        listtabla.ajax.reload(null,false); 
        mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modaleliminarnota");
    }).fail(function (jqXHR, textStatus){
        mostrar_mensaje("#divmsgindex",'Error al eliminar.', "alert-danger",null);
    });       
    }


    // FUNCION DE ASIGNACION DE TANQUES

    $(document).on("click","#btn-save-asignacion", save_asignacion);
    $(document).on("click","#btn-modal-asignacion-minus", modal_edit_asignacion_minus);
    $(document).on("click","#btn-modal-asignacion-plus", modal_edit_asignacion_plus);
    

    function modal_edit_asignacion_plus(){
        if($('#asignacion_tanques').val() == '' || $('#num_contratoShow').val()==''){
            return false;
        }
        // limpiarasignacion();
        $(".trasignacion").remove();
        getAsignaciones();
        $("#div-garantia").replaceWith(
            '<div id="div-garantia" class="row">'+
                '<div class="col-md-6">'+
                    '<label for="">Depósito de garantia:</label>'+
                    '<input type="number" name="deposito_garantia" id="deposito_garantia" class="form-control form-control-sm">'+
                '</div>'+
            '</div>'
        );
        $('#columnaopcion').replaceWith('<div id="columnaopcion">AUMENTOS</div>');
        $('#td-btn-anadir').replaceWith('<td id="td-btn-anadir" colspan="7" class="text-right"> <button type="button" class="btn btn-amarillo btn-sm" id="btn-anadir-asignacion"><span class="fas fa-plus"></span>Añadir</button></td>');
        $("#h5-title-modal").replaceWith('<h5 class="modal-title" id="h5-title-modal">Aumento</h5>');
        $('#modal-edit-asignacion').modal("show");

        $('#incidencia-asignacion').val("aumento");
    }

    function modal_edit_asignacion_minus(){
        if($('#asignacion_tanques').val() == '' || $('#num_contratoShow').val()==''){
            return false;
        }
        $(".trasignacion").remove();
        getAsignaciones();

        $("#div-garantia").empty();
        $('#columnaopcion').replaceWith('<div id="columnaopcion">DISMINUCIÓN</div>');
        $('#td-btn-anadir').replaceWith('<td id="td-btn-anadir"></td>');
        $("#h5-title-modal").replaceWith('<h5 class="modal-title" id="h5-title-modal">Disminución</h5>');

        $('#modal-edit-asignacion').modal("show");
        $('#incidencia-asignacion').val("disminucion");
    }

    function getAsignaciones(){
        var contrato_id= $("#idShow").val();
        $.get('/asignaciones/show/' + contrato_id, function(data) {
            var columnas='';
            $.each(data.asigTanques, function (key, value) {
                columnas+='<tr class="trasignacion"><td class="tdWidth">'+
                '<input name="asignacion_cilindros[]" id="asignacion_cilindros" type="number" class="form-control form-control-sm" value="'+value.cilindros+'" readonly></td><td class="tdWidth">'+
                '<input name="asignacion_variante[]" id="asignacion_variante" type="number" class="form-control form-control-sm" value=0></td><td style="width: 120px;">'+
                '<select name="asignacion_gas[]" id="asignacion_gas" class="form-control form-control-sm select-search"><option value="'+value.idGas+'">'+ value.nombreGas +'</option></select></td><td>'+
                '<input name="asignacion_tipo_tanque[]" id="asignacion_tipo_tanque" type="text" class="form-control form-control-sm" value="'+value.tipo_tanque+'" readonly></td><td>'+
                '<input name="asignacion_material[]" id="asignacion_material" type="text" class="form-control form-control-sm" value="'+value.material+'" readonly></td><td>'+
                '<input name="asignacion_precio_unitario[]" id="asignacion_precio_unitario" type="number" class="form-control form-control-sm" value="'+value.precio_unitario+'" readonly></td><td class="tdWidth">'+
                '<input name="asignacion_capacidad[]" id="asignacion_capacidad" type="number" class="form-control form-control-sm" value="'+value.capacidad+'" readonly></td><td>'+
                '<input name="asignacion_unidad_medida[]" id="asignacion_unidad_medida" type="text" class="form-control form-control-sm" value="'+value.unidad_medida+'" readonly></td><td>'+
                '</td></tr>';
            });

            $("#tbody-tr-asignacion").append(columnas);
        })
    }



    function save_asignacion(){
        // &&falta validar que los campos no esten vacios al enviarlo y cuando regresen limpiar los campos
        $.ajax({
            method: "post",
            url: "/asignaciones/"+$('#incidencia-asignacion').val()+"/"+$('#idShow').val(),
            // url: "/notasalida/save_edit_asignacion/"+$('#idShow').val(),
            data: $('#form-edit-asignacion').serialize(),
        }).done(function(msg){
            if(msg.alert == 'alert-danger'){
                mostrar_mensaje('#msg-modal-asignacion', msg.mensaje,'alert-danger' , null);
            }else{
                
                var contrato_id = $("#idShow").val();
                show_table_asignaciones(contrato_id, 'tableasignaciones', 'content-asignaciones');
                mostrar_mensaje('#msg-asignacion-save','editado correctamente','alert-primary' ,'#modal-edit-asignacion');
                window.open("/pdf/asignacion_tanque/"+ msg.nota_id, '_blank');
            }
        })  
    }
    function show_table_asignaciones(contrato_id, idTabla, idDiv) {
        
        $.get('/asignaciones/show/' + contrato_id, function(data) {
            var columnas='';
            $.each(data.asigTanques, function (key, value) {
                columnas+='<tr><td>'+value.cilindros+'</td><td>'+value.nombreGas+'</td><td>'+value.tipo_tanque+'</td><td>'+value.precio_unitario+'</td><td>'+value.capacidad+" "+value.unidad_medida+'</td></tr>';
            });

            $('#'+idTabla).remove();
            $('#'+idDiv).append(
                '<div id="'+idTabla+'" class="table-responsive" >'+
                    '<table class="table table-sm" style="font-size: 13px">'+
                        '<thead><tr style="background: #fff; color: black">'+
                            '<th>Cil.</th>'+
                            '<th>Gas</th>'+
                            '<th>tipo</th>'+
                            '<th>P.U.</th>'+
                            '<th>Capacidad</th>'+
                        '</tr></thead>'+
                        '<tbody>'+
                            columnas+
                        '</tbody>'+
                    '</table>'+
                '</div>'
            );
        })
    }
  // FIN FUNCION DE ASIGNACION DE TANQUES

    $("#tipo_contrato").change( function() {
        if ($(this).val() == "Industrial") {
            $(".tipo_tanque").prop("disabled", false);
            $(".tipo_tanque").empty();
            $(".tipo_tanque").append('<option value="Industrial">Industrial</option>'); //.val("Industrial");
        }
        if ($(this).val() == "Medicinal") {
            $(".tipo_tanque").prop("disabled", false);
            $(".tipo_tanque").empty();
            $(".tipo_tanque").append('<option value="Medicinal">Medicinal</option>'); //.val("Medicinal");
        } 
        if ($(this).val() == "Eventual") {
            $(".tipo_tanque").prop("disabled", false);
            $(".tipo_tanque").empty();
            $(".tipo_tanque").append('<option value="">Selecciona</option><option value="Industrial">Industrial</option><option value="Medicinal">Medicinal</option>');
        }

    });

    $('.numero-entero-positivo').keypress(function (event) {
        // console.log(event.charCode);
        if (
            event.charCode == 43  || //+
            event.charCode == 45  || //-
            event.charCode == 69  || //E
            event.charCode == 101 || //e
            event.charCode == 46    //.
            ){
            return false;
        } 
        return true;
    });

    $('.numero-decimal-positivo').keypress(function (event) {
        // console.log(event.charCode);
        if (
            event.charCode == 43 || //+
            event.charCode == 45 || //-
            event.charCode == 69 || //E
            event.charCode == 101 //e
            ){
            return false;
        } 
        return true;
    });

});