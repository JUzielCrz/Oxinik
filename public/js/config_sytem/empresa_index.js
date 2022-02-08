$(document).ready(function () {
    
    $(document).on("click","#btn-save", btn_save);
    
    function btn_save() {

        limpiar_span();
        $.ajax({
            method: "get",
            url: "/config/empresa/save",
            data: $("#formData").serialize(),
        })
            .done(function (msg) {
                mensaje("success","Exito",'Guardado Correctamente', 1500, null)
            })
            .fail(function (jqXHR, textStatus) {
                mensaje("error",'Error, verifique sus datos.', null,null);
                var status = jqXHR.status;
                if (status === 422) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        console.log(key);
                        var idError = "#" + key + "_userError";
                        $(idError).text(value);
                    });
                }
            });
        return false;
    }

    function limpiar_span() {
        $("#rfc").empty();
        $("#direccion").empty();
        $("#telefono1").empty();
        $("#telefono2").empty();
        $("#telefono3").empty();
        $("#num_cuenta1").empty();
        $("#clave1").empty();
        $("#banco1").empty();
        $("#titular1").empty();
        $("#num_cuenta2").empty();
        $("#clave2").empty();
        $("#banco2").empty();
        $("#titular2").empty();
    }

    function mensaje(icono,titulo, mensaje, timer){
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: timer,
            width: 300,
        })
    }
    $('.telefono').keypress(function (event) {
        if (this.value.length === 10) {
            return false;
        }
    });
    $('.numero-entero-positivo').keypress(function (event) {

        if (
            event.charCode == 43 || //+
            event.charCode == 45 || //-
            event.charCode == 69 || //E
            event.charCode == 101|| //e
            event.charCode == 46    //.
            ){
            return false;
        } 
        return true;
    });
});
