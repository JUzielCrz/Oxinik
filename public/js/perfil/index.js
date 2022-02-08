$(document).ready(function () {
    
    metodo_limpiar_span("Error");

        $("input").focusout(function () {
            var value = $(this).val();
            if (value.length == 0) {
                $(this).addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid");
            }
        });

    $(document).on("click","#btnnewemail", actualizaremail);
    $(document).on("click","#btnnewpassword", actualizarpassword);
    $(document).on("click","#guardar-datos", guardar_datos);
    
    function guardar_datos() {
        metodo_limpiar_span("editError");
        $.ajax({
            method: "POST",
            url: "/perfil/mis_datos",
            data: 
                {
                '_token': $('input[name=_token]').val(),
                'name': $('#user_name').val(),
                },
        })
            .done(function (msg) {
                
                if(msg.alert == "success"){
                    mostrar_mensaje("#msg-mis-datos",msg.mensaje, "alert-primary",null)
                }else{
                    $('#user_name').val(msg.useremail.email)
                    mostrar_mensaje("#msg-mis-datos",'error verifique sus datos', "alert-warning",null);
                }
                
            })
            .fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsgedit",'Error, verifique sus datos.', "alert-danger",null);
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

    function actualizaremail() {
        metodo_limpiar_span("editError");
        $.ajax({
            method: "POST",
            url: "/perfil/cambio_email",
            data: 
                {
                '_token': $('input[name=_token]').val(),
                'email': $('#emailedit').val(),
                'password': $('#passwordedit').val(),
                },
        })
            .done(function (msg) {
                
                if(msg.useremail == "false"){
                    mostrar_mensaje("#divmsgedit",msg.mensaje, "alert-warning",null)
                }else{
                    $('#email').append(
                        $('#email').val(msg.useremail.email)
                    );
                    mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#emailmodal")
                    metodo_limpiar_campos("edit") 
                    location.reload();
                }
                
            })
            .fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsgedit",'Error al cambiar contraseña, verifique sus datos.', "alert-danger",null);
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
    
    function actualizarpassword() {
        metodo_limpiar_span("editError");
        $.ajax({
            method: "POST",
            url: "/perfil/cambio_password",
            data: 
                {
                '_token': $('input[name=_token]').val(),
                'passwordactual': $('#passwordoneedit').val(),
                'password': $('#passwordtwoedit').val(),
                'password_confirmation': $('#passwordtreeedit').val(),
                },
        })
            .done(function (msg) {
                if(msg.validpass==true){
                    metodo_limpiar_campos("edit") 
                    mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-primary","#passwordmodal")
                }else{
                    mostrar_mensaje("#divmsgeditpass",msg.mensaje, "alert-warning",null)
                }
                
            })
            .fail(function (jqXHR, textStatus) {
                mostrar_mensaje("#divmsgedit",'Error al crear rol, verifique sus datos.', "alert-danger",null);
                var status = jqXHR.status;
                if (status === 422) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        var idError = "#" + key + "twoeditError";
                        $(idError).text(value);
                    });
                }
            });
        return false;
    }


    function metodo_limpiar_span(nombreerror) {
        $("#email"+ nombreerror).empty();
        $("#password"+ nombreerror).empty();
        $("#passwordone"+ nombreerror).empty();
        $("#passwordtwo"+ nombreerror).empty();
        $("#passwordtree"+ nombreerror).empty();
    }
    
    function metodo_limpiar_campos(nombre) {
        $("#email"+nombre).val("");
        $("#password"+nombre).val("");
        $("#passwordone"+nombre).val("");
        $("#passwordtwo"+nombre).val("");
        $("#passwordtree"+nombre).val("");
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
    
    $(document).on("click",".mostrarpassword", passwordedit);
    $(document).on("click",".mostrarpassword1", passwordoneedit);
    $(document).on("click",".mostrarpassword2", passwordtwoedit);
    $(document).on("click",".mostrarpassword3", passwordtreeedit);

    function passwordedit(){ mostrarPassword('passwordedit','.icon')}
    function passwordoneedit(){ mostrarPassword('passwordoneedit','.icon1')}
    function passwordtwoedit(){ mostrarPassword('passwordtwoedit','.icon2')}
    function passwordtreeedit(){ mostrarPassword('passwordtreeedit','.icon3')}

    function mostrarPassword(idelement, spanclass){
        var cambio = document.getElementById(idelement);
		if(cambio.type == "password"){
			cambio.type = "text";
			$(spanclass).removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$(spanclass).removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 


});
