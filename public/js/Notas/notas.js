// SE ELIMINAAAAARAAAAAAAAAAAAA


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

    $(document).on("click",".btnnota-show-modal",nota_detalle);
    
    
    $(document).on("click","#btnnotaeliminar", metodo_eliminar);
    
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
    
    
    function nota_detalle() {
        $.get('/shownota/' + $(this).data('id') + '', function(data) {
            $.each(data.tanques, function (key, value) {
                var variable = "#" + key + "info";
                $(variable).val(value);
            });
        }).done(function (msg) {
            if(msg.accesso){
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-warning",null);
            }else{
                $("#modalmostrarnota").modal("show");
            }
        });;
        
    }
    
    
    

    


        

});
