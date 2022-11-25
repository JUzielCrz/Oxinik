$(document).ready(function () {

    // CRUD
    metodo_limpiar_span("Error");


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
                {data: 'created_at'},
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

        $('#modelo_reguladorError').empty();
        $('#modelo_regulador').removeClass("is-invalid");
        if($("#reguladores").val() > 0 && $("#modelo_regulador").val() == ''){
            $('#modelo_reguladorError').text("Mod. Regulador invalido");
            $('#modelo_regulador').addClass("is-invalid");
            return false;
        }

        var campo=['tipo_contrato', 'reguladores', 'direccion','referencia','calle1','calle2'];
        var camponombre=['# Contrato', 'Tipo contrato',  '# Reguladores','Dirección','Referencia','1ra Calle', '2da Calle'];
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
        $("input[name='deposito_garantiacreate[]']").each(function(indice, elemento) {
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
                            "<td class='text-center'>"+msg.contratos.id +"</td>"+
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
        $("#nombre_comercial"+ nombreerror).empty();
        $("#calle1"+ nombreerror).empty();
        $("#calle2"+ nombreerror).empty();
        $("#modelo_regulador"+ nombreerror).empty();
        $("#nombre_solidaria"+ nombreerror).empty();
        $("#telefono_solidaria"+ nombreerror).empty();
        $("#email_solidaria"+ nombreerror).empty();
        $("#direccion_solidaria"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos() {
        $("#nombre").val("");
        $("#tipo_contrato").val("");
        $("#nombre_comercial").val("");
        $("#asignacion_tanques").val("");
        $("#precio_transporte").val("");
        $("#direccion").val("");
        $("#calle1").val("");
        $("#calle2").val("");
        $("#referencia").val("");
        $("#link_ubicacion").val("");
        $("#reguladores").val(0);
        $("#modelo_regulador").val("");
        $("#deposito_garantia").val("");
        $("#observaciones").val("");
        $("#nombre_solidaria").val("");
        $("#telefono_solidaria").val("");
        $("#email_solidaria").val("");
        $("#direccion_solidaria").val("");
        

        $("#tbody-tr-asignacioncreate").empty();

        $("input[name='cilindroscreate[]']").val("");
        $("select[name='tipo_gascreate[]']").val("");
        $("select[name='tipo_tanquecreate[]']").val("");
        $("select[name='tipo_tanquecreate[]']").empty();
        $("select[name='materialcreate[]']").val("");
        $("select[name='capacidadcreate[]']").val("")
        $("input[name='precio_unitariocreate[]']").val("");
        $("input[name='deposito_garantiacreate[]']").val("");
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
                'cliente_id': $('#cliente_id').val(),
                'nombre': $('#nombreedit').val(),
                'tipo_contrato': $('#tipo_contratoedit').val(),
                'nombre_comercial': $('#nombre_comercialedit').val(),
                'modelo_regulador': $('#modelo_reguladoredit').val(),
                'reguladores': $('#reguladoresedit').val(),
                'precio_transporte': $('#precio_transporteedit').val(),
                'direccion': $('#direccionedit').val(),
                'referencia': $('#referenciaedit').val(),
                'calle1': $('#calle1edit').val(),
                'calle2': $('#calle2edit').val(),
                'link_ubicacion': $('#link_ubicacionedit').val(),
                'nombre_solidaria': $('#nombre_solidariaedit').val(),
                'telefono_solidaria': $('#telefono_solidariaedit').val(),
                'email_solidaria': $('#email_solidariaedit').val(),
                'direccion_solidaria': $('#direccion_solidariaedit').val(),
                },
        })
            .done(function (msg) {
                if(msg.mensaje == 'Sin permisos'){
                    mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
                    return false;
                }

                $('.fila'+ msg.contratos.id).replaceWith(" "+
                    "<tr class='fila"+ msg.contratos.id+"'  data-id='"+msg.contratos.id+"'>"+
                    "<td class='text-center'>"+msg.contratos.id +"</td>"+
                    "<td class='text-center'>"+msg.contratos.tipo_contrato +"</td>"+
                    "<td><a class='btn btn-amarillo btn-sm' target='_blank' href='/pdf/generar_contrato/"+msg.contratos.id+"'   title='Contrato'><i class='fas fa-file-pdf'></i></span></a></td>"+
                    "<td><a class='btn btn-amarillo btn-delete-modal btn-sm ' data-id='"+msg.contratos.id+"'>"+
                    "<i class='fas fa-trash'></i>"+
                    "</a></td>"+
                    "</tr>");
                    console.log(msg.contratos);
                    $('#idShow').val(msg.contratos.id),
                    $('#nombre_comercialShow').val(msg.contratos.nombre_comercial),
                    $('#reguladoresShow').val(msg.contratos.reguladores),
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

    $(document).on("click","#btn-save-asignacion-plus", save_asignacion_plus);
    $(document).on("click","#btn-save-asignacion-minus", save_asignacion_minus);

    $(document).on("click","#btn-modal-asignacion-minus", modal_edit_asignacion_minus);
    $(document).on("click","#btn-modal-asignacion-plus", modal_edit_asignacion_plus);
    

    function modal_edit_asignacion_plus(){
        if($('#asignacion_tanques').val() == '' || $('#idShow').val()==''){
            return false;
        }
        $(".tr-asignaciones").remove();
        $(".tr-asignacion-plus").remove();
        var contrato_id= $("#idShow").val();
        $.get('/asignaciones/show/' + contrato_id, function(data) {
            var columnas='';
            
            $.each(data.asigTanques, function (index, value) {
                columnas+='<tr class="tr-asignaciones"><td>'+
                value.cilindros+'</td><td>'+
                value.nombreGas+'</td><td>'+
                value.tipo_tanque+'</td><td>'+
                value.material+'</td><td>'+
                value.capacidad+'</td><td>'+
                value.unidad_medida+'</td><td>'+
                value.precio_unitario+'</td><td>'+
                '</td></tr>';
            });
            $("#tbody-asignaciones-anteriores").append(columnas);
        })
        $('#modal-asignacion-plus').modal("show");
    }

    function modal_edit_asignacion_minus(){
        
        if( $('#idShow').val()==''){
            return false;
        }
        
        $(".tr-asignacion-minus").remove();

        var contrato_id= $("#idShow").val();
        $.get('/asignaciones/show/' + contrato_id, function(data) {
            var columnas='';
            $.each(data.asigTanques, function (index, value) {
                columnas+='<tr class="tr-asignacion-minus"><td class="tdWidth">'+
                '<input name="asignacion_cilindros[]" id="asignacion_cilindros" type="number" class="form-control form-control-sm" value="'+value.cilindros+'" readonly></td><td class="tdWidth">'+
                '<input name="asignacion_variante[]" id="asignacion_variante" type="number" class="form-control form-control-sm" value=0></td><td style="width: 120px;">'+
                '<select name="asignacion_gas[]" id="asignacion_gas" class="form-control form-control-sm select-search"><option value="'+value.idGas+'">'+ value.nombreGas +'</option></select></td><td>'+
                '<input name="asignacion_tipo_tanque[]" id="asignacion_tipo_tanque" type="text" class="form-control form-control-sm" value="'+value.tipo_tanque+'" readonly></td><td>'+
                '<input name="asignacion_material[]" id="asignacion_material" type="text" class="form-control form-control-sm" value="'+value.material+'" readonly></td><td>'+
                '<input name="asignacion_capacidad[]" id="asignacion_capacidad" type="number" class="form-control form-control-sm" value="'+value.capacidad+'" readonly></td><td>'+
                '<input name="asignacion_unidad_medida[]" id="asignacion_unidad_medida" type="text" class="form-control form-control-sm" value="'+value.unidad_medida+'" readonly></td><td>'+
                '<input name="asignacion_precio_unitario[]" id="asignacion_precio_unitario" type="number" class="form-control form-control-sm" value="'+value.precio_unitario+'" readonly></td><td class="tdWidth">'+
                '<input name="asignacion_deposito_garantia[]" id="asignacion_deposito_garantia" type="number" class="form-control form-control-sm" value="0"></td>'+   
                '</tr>';
            });
            $("#tbody-asignacion-minus").append(columnas);
        })

        $('#modal-asignacion-minus').modal("show");

    }

    function save_asignacion_plus(){
        $('#alerta-tanques').empty();
        if($(".tr-asignacion-plus").length == 0 ){
            $('#alerta-tanques').append(
                "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+
                "No hay tanques en lista"+
                "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"+
                    "<span aria-hidden='true'>&times;</span>"+
                "</button>"+
                "</div>"
            );
            return false;
        }
        
        $.ajax({
            method: "post",
            url: "/asignaciones/aumento/"+$('#idShow').val(),
            data: $('#form-asignacion-plus').serialize(),
        }).done(function(msg){
            if(msg.alert == 'alert-danger'){
                mostrar_mensaje('#msg-modal-asignacion', msg.mensaje,'alert-danger' , null);
            }else{
                var contrato_id = $("#idShow").val();
                show_table_asignaciones(contrato_id, 'tableasignaciones', 'content-asignaciones');
                mostrar_mensaje('#msg-asignacion-save','editado correctamente','alert-primary' ,'#modal-asignacion-plus');
                window.open("/pdf/asignacion_tanque/"+ msg.nota_id, '_blank');
            }
        })  
    }

    function save_asignacion_minus(){

        $.ajax({
            method: "post",
            url: "/asignaciones/disminucion/"+$('#idShow').val(),
            data: $('#form-asignacion-minus').serialize(),
        }).done(function(msg){
            if(msg.alert == 'alert-danger'){
                mostrar_mensaje('#msg-asignacion-minus', msg.mensaje,'alert-danger' , null);
            }else{
                
                var contrato_id = $("#idShow").val();
                show_table_asignaciones(contrato_id, 'tableasignaciones', 'content-asignaciones');
                mostrar_mensaje('#msg-asignacion-save','editado correctamente','alert-primary' ,'#modal-asignacion-minus');
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
                            '<th>CIL.</th>'+
                            '<th>GAS</th>'+
                            '<th>TIPO</th>'+
                            '<th>PRECIO</th>'+
                            '<th>CAP</th>'+
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

    $('.lenght-telefono').keypress(function (event) {
        if (this.value.length === 10) {
            return false;
        }
    });

});