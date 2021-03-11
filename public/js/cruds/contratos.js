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
    $(document).on("click",".btnnota-edit",nota_edit);
    $(document).on("click",".btnnota-delete-modal", nota_detalle_delete);
    $(document).on("click","#btnnotaeliminar", nota_eliminar);
    $(document).on("click",".btnnota-devolucion", nota_devolucion);

    



    $('#table-contratos').on('click','tr', function(evt){

        var numContrato=$(this).find("td")[0].innerHTML;

        $.get('/showcontrato/' + numContrato + '', function(data) {
            $.each(data.contratos, function (key, value) {
                var variable = "#" + key + "Show";
                $(variable).val(value);
            });
            $("#btn-edit-modal").val(data.contratos.num_contrato);
        })

        $('#filatabla').remove();
        $('#cardtablas').append(
        "<div id='filatabla'>"+
            // "<h5 class='card-title'>NOTAS</h5>"+
                    // "<div class='col-md-5 text-right'>"+
                    //     "<a href='newnota/"+numContrato+"' class='btn btn-sm btn-gray'>"+
                    //         "<span class='fas fa-plus'></span>"+
                    //         "Nueva Nota"+
                    //     "</a>"+
                    // "</div>"+
                
                
                "<div class='row table-responsive ml-1' >"+ 
                    "<table id='tablecruddata' class='table table-sm table-striped table-hover'>"+
                        "<thead>"+
                            "<tr>"+
                                "<th scope='col'>"+'Folio'+"</th>"+
                                "<th scope='col'>"+'Fecha'+"</th>"+
                                // "<th scope='col'>"+'Pago Realizado'+"</th>"+
                                // "<th scope='col'>"+'Metodo Pago'+"</th>"+
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
            ajax: '/dt_nota/'+numContrato,
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

        $.ajax({
            method: "POST",
            url: "/newcontrato",
            data: {
                '_token': $('input[name=_token]').val(),
                'num_contrato': $('#num_contrato').val(),
                'cliente_id': $('#cliente_id').val(),
                'tipo_contrato': $('#tipo_contrato').val(),
                'asignacion_tanques': $('#asignacion_tanques').val(),
                'precio_transporte': $('#precio_transporte').val(),
                'direccion': $('#direccion').val(),
                'referencia': $('#referencia').val(),
                },
        })
            .done(function (msg) {
                mostrar_mensaje("#divmsg",msg.mensaje, "alert-warning",null);
                metodo_limpiar_campos();
                $('#tableinsertfila').append(
                    "<tr class='fila"+ msg.contratos.id+"'>"+
                        "<td class='text-center'>"+msg.contratos.num_contrato +"</td>"+
                        "<td class='text-center'>"+msg.contratos.tipo_contrato +"</td>"+
                        "<td><button class='btn btn-amarillo btn-delete-modal btn-xs' data-id='"+msg.contratos.id+"'><span class='fas fa-trash'></span></button>"+
                    "</tr>"); 
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
                    "<td><a class='btn btn-amarillo btn-delete-modal btn-xs ' data-id='"+msg.contratos.id+"'>"+
                    "<i class='fas fa-trash'></i>"+
                    "</a></td>"+
                    "</tr>");
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

});