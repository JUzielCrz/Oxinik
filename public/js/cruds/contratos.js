$(document).ready(function () {
    
    // Data Tables
    var idcliente=$('#cliente_id').val();
        var listtabla = $('#tablecruddata').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay informaci√≥n",
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
            ajax: '/dt_contrato/'+idcliente,
            columns:[
                {data: 'num_contrato'},
                {data: 'tipo_contrato'},
                {data: 'precio_definido'},
                {data: 'precio_transporte'},
                {data: 'btnNota'},
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

    $(document).on("click","#btnaccept",metodo_insertar);
    $(document).on("click",".btn-show-modal",metodo_detalle);
    $(document).on("click",".btn-edit-modal",metodo_detalle_edit);
    $(document).on("click",".btn-delete-modal", metodo_detalle_delete);
    $(document).on("click","#btneliminar",metodo_eliminar);
    $(document).on("click","#btnactualizar",metodo_actualizar);
    
    function metodo_insertar() {
        metodo_limpiar_span("Error");

        $.ajax({
            method: "POST",
            url: "/newcontrato",
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#idedit').val(),
                'num_contrato': $('#num_contrato').val(),
                'cliente_id': $('#cliente_id').val(),
                'nombre': $('#nombre').val(),
                'tipo_contrato': $('#tipo_contrato').val(),
                'precio_definido': $('#precio_definido').val(),
                'precio_transporte': $('#precio_transporte').val(),
                },
        })
            .done(function (msg) {
                mostrar_mensaje("#divmsg",msg.mensaje, "alert-warning",null);
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
        $("#num_contrato"+ nombreerror).empty();
        $("#tipo_contrato"+ nombreerror).empty();
        $("#precio_definido"+ nombreerror).empty();
        $("#precio_transporte"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos() {
        $("#num_contrato").val("");
        $("#nombre").val("");
        $("#tipo_contrato").val("");
        $("#precio_definido").val("");
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
    
    
    function metodo_detalle() {
        $.get('/showcontrato/' + $(this).data('id') + '', function(data) {
            $.each(data.contratos, function (key, value) {
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
        metodo_limpiar_span("editError");
        $.get('/showcontrato/' + $(this).data('id') + '', function(data) {
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
                'cliente_id': $('#cliente_idedit').val(),
                'nombre': $('#nombreedit').val(),
                'tipo_contrato': $('#tipo_contratoedit').val(),
                'precio_definido': $('#precio_definidoedit').val(),
                'precio_transporte': $('#precio_transporteedit').val(),
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
            method: "get",
            // route: 'contrato.destroy',
            url: "deletecontrato/"+$('#ideliminar').text()+'',
            
        }).done(function (msg) {
            listtabla.ajax.reload(null,false); 
            mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#modaleliminar");
        }).fail(function (jqXHR, textStatus){
            mostrar_mensaje("#divmsgindex",'Error al eliminar.', "alert-danger",null);
        });       
    }


    //Para Validar Campos

        $('.solo-text').keypress(function (event) {
            // console.log(event.charCode);
            if (event.charCode >= 65 && event.charCode <= 90 || e0\rßm˚¸   ’   7hÜ#    _keyhttps://static.xx.fbcdn.net/rsrc.php/v3iVN84/yH/l/es_LA/4dCKj_5Fhu4.js?_nc_x=JmX7FwoB24g&_nc_eui2=AeHsKaTmMC-NaUrSFOWvmX5tTdg91IZDLXlN2D3UhkMteeBOPHyXT-b31TbPFZnzl3qp1qYAI373yRDSNR2ztRfS 
https://facebook.com/    OÕ“W“ﬁ¿˘{$  ≠O,—   –  
Ñ¢       Äÿ  ‘   Ä   Ä   Ä   Ä    (Sµ®`"  †L`L   Qbû"i¸   selfQ`ÊAâ´   CavalryLogger   QcÆTÒº   start_js˘`   M`   Qc ¿ŒÀ   5K0BE   Qb˛D@˝   __d <Qm*cKæ-   CometEntityActorSelectorButton_viewer.graphql   (S0ê`   L`   D§a       Qf¢»É   argumentDefinitions ë`   L`   ía
      Qb∫|y˜   kindQdÜòì>   RootArgumentâQcÓ¸ö   scale   	 —QcZêô   FragmentQcPô|