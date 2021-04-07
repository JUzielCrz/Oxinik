$(document).ready(function () {

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

        // var numContrato=$(this).find("td")[0].innerHTML;
        var contrato_id=$(this).data('id');
        

        $.get('/showcontrato/' + contrato_id + '', function(data) {
            $.each(data.contratos, function (key, value) {
                var variable = "#" + key + "Show";
                $(variable).val(value);
            });
            
            $("#btn-edit-modal").val(data.contratos.num_contrato);

            show_table_asignaciones(contrato_id, 'tableasignaciones', 'content-asignaciones');

        })

        

        $('#filatabla').remove();
        $('#cardtablas').append(
        "<div id='filatabla'>"+
                "<div class='row table-responsive ml-1' >"+ 
                    "<table id='tablecruddata' class='table table-sm table-striped table-hover'>"+
                        "<thead>"+
                            "<tr>"+
                                "<th scope='col'>"+'Folio'+"</th>"+
                                "<th scope='col'>"+'Fecha'+"</th>"+
                                "<th scope='col'>"+'Núm. Contrato'+"</th>"+
                                "<th scope='col'>"+"</th>"+
                                "<th scope='col'>"+"</th>"+ 
                                "<th scope='col'>"+"</th>"+ 
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
            ajax: '/dt_nota/'+contrato_id,
            columns:[
                {data: 'folio_nota'},
                {data: 'fecha'},
                // {data: 'pago_realizado'},
                // {data: 'metodo_pago'},
                {data: 'num_contrato'},
                {data: 'btnDevolucion'},
                {data: 'btnEdit'},
                {data: 'btnDelete'},
            ]
        });
    });


    function metodo_insertar() {
        metodo_limpiar_span("Error");

        var dataForm= $("#idFormContrato").serialize()+'&cliente_id=' +  $('#cliente_id').val();
        $.ajax({
            method: "POST",
            url: "/newcontrato",
            data: dataForm,
        })
            .done(function (msg) {
                if(msg.alert == 'alert-danger'){
                    mostrar_mensaje("#divmsg",msg.mensaje, "alert-danger",null);
                }else{
                    metodo_limpiar_campos();
                    $('#tableinsertfila').append(
                        "<tr class='fila"+ msg.contratos.id+"' data-id='"+msg.contratos.id+"'>"+
                            "<td class='text-center'>"+msg.contratos.num_contrato +"</td>"+
                            "<td class='text-center'>"+msg.contratos.tipo_contrato +"</td>"+
                            "<td><button class='btn btn-amarillo btn-delete-modal btn-sm' data-id='"+msg.contratos.id+"'><span class='fas fa-trash'></span></button>"+
                        "</tr>"); 
                    mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modalinsertar");
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
    }
    
    function metodo_limpiar_campos() {
        $("#num_contrato").val("");
        $("#nombre").val("");
        $("#tipo_contrato").val("");
        $("#asignacion_tanques").val("");
        $("#precio_transporte").val("");
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

    function metodo_detalle_edit() {
        metodo_limpiar_span("editError");
        var numcontrato= $("#btn-edit-modal").val();
        $.get('/showcontrato/' + numcontrato, function(data) {
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
            url: "updatecontrato/"+$('#idedit').val()+'',
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
                },
        })
            .done(function (msg) {
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
            url: "deletecontrato/"+$('#ideliminar').text()+'',
            
        }).done(function (msg) {
            
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
        if($('#asignacion_tanques').val() == ''){
            return false;
        }
        limpiarasignacion();
        
        $("#h5-title-modal").replaceWith('<h5 class="modal-title" id="h5-title-modal">Aumento</h5>');
        $('#modal-edit-asignacion').modal("show");
        $('#incidencia-asignacion').val("AUMENTO");
    }

    function modal_edit_asignacion_minus(){
        if($('#asignacion_tanques').val() == ''){
            return false;
        }
        limpiarasignacion();
        var contrato_id= $("#idShow").val();
        show_table_asignaciones(contrato_id, 'table-show-asignaciones', 'show-asignaciones')
        $("#h5-title-modal").replaceWith('<h5 class="modal-title" id="h5-title-modal">Disminución</h5>');
        $('#modal-edit-asignacion').modal("show");
        $('#incidencia-asignacion').val("DISMINUCION");
    }

    function limpiarasignacion(){
        $.ajax({
            method: "get",
            url: "/catalogo_gases",
        }).done(function(msg){
            $(".trasignacion").remove();
            $('#table-show-asignaciones').remove();
            var opciones;
            opciones = '<option value="" selected>SELECCIONA</option>';
            $(msg).each(function(index, value){
                opciones += '<option value="'+value.id+'">'+ value.nombre +'</option>';
            });
            
            $("#tbody-tr-asignacion1").append(
                '<tr class="trasignacion">'+
                '<td>'+
                    '<input name="cantidadtanques[]" id="cantidadtanques" type="number" class="form-control form-control-sm"  placeholder="#">'+
                '</td>'+
                '<td>'+
                    '<select name="tipo_gas[]" id="tipo_gas" class="form-control form-control-sm">'+opciones +'</select>'+
                '</td>'+
                '<td>'+
                    '<button type="button" class="btn btn-amarillo btn-sm" id="btn-anadir-asignacion"><span class="fas fa-plus"></span></button>'+
                '</td>'+
            '</tr>'
            );  
        })
        
    }

    function save_asignacion(){

        // &&falta validar que los campos no esten vacios al enviarlo y cuando regresen limpiar los campos
        $.ajax({
            
            method: "post",
            url: "/asignacion/"+$('#incidencia-asignacion').val()+"/"+$('#idShow').val(),
            // url: "/notasalida/save_edit_asignacion/"+$('#idShow').val(),
            data: $('#form-edit-asignacion').serialize(),
        }).done(function(msg){
            
            if(msg.alert == 'alert-danger'){
                mostrar_mensaje('#msg-modal-asignacion', msg.mensaje,'alert-danger' , null);
            }else{
                
                var contrato_id = $("#idShow").val();
                show_table_asignaciones(contrato_id, 'tableasignaciones', 'content-asignaciones');
                mostrar_mensaje('#msg-asignacion-save','editado correctamente','alert-primary' ,'#modal-edit-asignacion');
                limpiarasignacion();
                window.open("/pdf/asignacion_tanque/"+ msg.nota_id, '_blank');
            }
        })  
    }
    function show_table_asignaciones(contrato_id, idTabla, idDiv) {
        
        $.get('/showasignaciones/' + contrato_id, function(data) {
            var columnas='';
            $.each(data.asigTanques, function (key, value) {
                columnas+='<tr><td>'+value.cantidad+'</td><td>'+value.nombre+'</td></tr>';
            });

            $('#'+idTabla).remove();
            $('#'+idDiv).append(
                '<div id="'+idTabla+'">'+
                    '<table class="table table-sm">'+
                        '<tbody>'+
                            columnas+
                        '</tbody>'+
                    '</table>'+
                '</div>'
            );
        })
    }
  // FIN FUNCION DE ASIGNACION DE TANQUES

});