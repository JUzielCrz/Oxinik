$(document).ready(function () {

    //Botones para guardar todo
    $(document).on("click","#btnInsertAll", insertAll);
    $(document).on("click","#btnCancelarAll", cancelarAll);

    //Datos Facturacion 
    $(document).on("click","#btnFacturacion", datosfacturacion);
    $(document).on("click","#btnFacturacionCancelar", datosfacturacioncancelar);

    //insertar fila en seccion registro ENTRADA
    $(document).on("click","#btnRegEntrada", insertRegEntrada);
    $(document).on("click","#btnEliminarFilaEntrada", eliminarFilaEntrada);
    $(document).on("click","#btnEliminarFilaSalida", eliminarFilaSalida);

    //insertar fila en seccion registro SALIDA
    $(document).on("click","#btnRegSalida", insertRegSalida);
    
    var preciototal=0;

    function datosfacturacion(){
        console.log('collapse');
        $('#myCollapsible').collapse('toggle');
        $('#filaFacturacion').remove();  
    }

    function datosfacturacioncancelar(){
        
        $('#myCollapsible').collapse('toggle');
        //Limpiar inputs
        $('#rfc').val('');
        $('#cfdi').val('');
        $('#metodo_pago').val('');
        $('#direccion_factura').val('');
        //Insertar button
        $('#datosfacturacion').append(
            "<div class='form-row justify-content-end' id='filaFacturacion'>"+
                "<button type='button' class='btn btn-gray' id='btnFacturacion'>"+
                    "<span class='fas fa-plus'></span> Agregar Datos Facturacion"+
                "</button>"+
            "</div>"
        );
    }


//
    //metodo insertar fila en seccion entrada
    function insertRegEntrada(){
        span_registrar_tanque("Error");
        
        // VALIDACIONES
            var  campovacio =[];
            var  msgerror =[];
            if($('#num_seriefila').val() == '' ){ campovacio.push('num_seriefila'); msgerror.push('número de serie');}
            if($('#phfila').val() == '' ){        campovacio.push('phfila'); msgerror.push('prueba hidroestatica');}
            if($('#capacidadnum').val() == '' ){  campovacio.push('capacidadfila'); msgerror.push('capacidad');}
            if($('#materialfila').val() == '' ){  campovacio.push('materialfila'); msgerror.push('tipo de material');}
            if($('#tipo_gasfila').val() == '' ){  campovacio.push('tipo_gasfila');msgerror.push('tipo de gas'); }
            if($('#fabricanteoficial').val() == 'Otros' ){
                if($("#otrofabricante").val() == ''){
                    campovacio.push('fabricantefila');
                    msgerror.push('fabricante');
                }
            }else{
                if($("#fabricanteoficial").val() == ''){
                    campovacio.push('fabricantefila');
                    msgerror.push('fabricante'); 
                }
            }

            if(campovacio.length != 0){
                $.each(campovacio, function(index){
                    $('#'+campovacio[index]+'Error').text('Campo '+msgerror[index]+ ' obligatorio');
                });
                return false;
            }

        //TERMINA VALIDACIONES

        //INSERTAR FILA
        var fabri;
        if($("#fabricanteoficial").val() == "Otros"){
            fabri = $("#otrofabricante").val();
        }else{
            fabri = $("#fabricanteoficial").val();
        }

        var cap=$('#capacidadnum').val()+' '+ $('#unidadmedida').val();

        $('#tablaRegistrarTanque').append(
            "<tr class='classfilatanque'>"+
                        "<td>"+$('#num_seriefila').val() +"</td>"+ "<input type='hidden' name='registronum_serie[]' id='registronum_serie' value='"+$('#num_seriefila').val() +"'></input>"+
                        "<td>"+$('#phfila').val() +"</td>"+ "<input type='hidden' name='registroph[]' id='registroph' value='"+$('#phfila').val() +"'></input>"+
                        "<td>"+ cap + "<input type='hidden' name='registrocapacidad[]' id='registrocapacidad' value='"+ cap +"'></input>"+
                        "<td>"+$('#materialfila').val() +"</td>"+ "<input type='hidden' name='registromaterial[]' value='"+$('#materialfila').val() +"'></input>"+
                        "<td>"+fabri+"</td>"+ "<input type='hidden' name='registrofabricante[]' value='"+fabri +"'></input>"+
                        "<td>"+$('#tipo_gasfila').val() +"</td>"+ "<input type='hidden' name='registrotipogas[]' value='"+$('#tipo_gasfila').val() +"'></input>"+
                        "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                        "</tr>");
        
        limpiar_campos_registro('fila');
        mostrar_mensaje("#divmsgregistrotanques",'Registrado Correctamente', "alert-primary","#modalinsertar");
        

    }

    //meotodo para modal en registro de tanque
    $("#fabricanteoficial").change( function() {
        if ($(this).val() == "Otros") {
            $("#otrofabricante").prop("disabled", false);
        } else {
            $("#otrofabricante").prop("disabled", true);
            $("#otrofabricante").val('');
        }
    });

    //limpiar mensajes de error
    function span_registrar_tanque(nombreerror) {
        $("#num_seriefila"+ nombreerror).empty();
        $("#phfila"+ nombreerror).empty();
        $("#capacidadfila"+ nombreerror).empty();
        $("#materialfila"+ nombreerror).empty();
        $("#fabricantefila"+ nombreerror).empty();
        $("#tipo_gasfila"+ nombreerror).empty();
    }

    //Limpiar inputs
    function limpiar_campos_registro(nombre) {
        $("#num_serie"+nombre).val("");
        $("#ph"+nombre).val("");
        $("#capacidadnum").val("");
        $("#unidadmedida").val("m3");
        $("#material"+nombre).val("");
        $("#otrofabricante").val("");
        $("#fabricanteoficial").val("");
        $("#tipo_gas"+nombre).val("");
    }

    //eliminar filas
    function eliminarFilaEntrada(){
        $(this).closest('tr').remove();
    }

    function eliminarFilaSalida(){
        $(this).closest('tr').remove();

        preciototal = 0;
        $(".trTanqueSalida").each(function(index, value){
            preciototal=preciototal+parseFloat($(this).find("td")[2].innerHTML);
        })

        $('#total').remove();
        $('#preciototal').append( 
            "<label id='total'>"+Intl.NumberFormat('es-MX').format(preciototal) +"</label>"
        );
    }
    
    //INSERTAR FILA EN SECCION SALIDA
    function insertRegSalida(){
        limpiar_span_salida("salidaError");

        var numserie= $('#num_seriesalida').val().replace(/ /g,'');
        
        var campo= [];
        var texterror = [];

        if(numserie == ''){campo.push('#num_seriesalida'); texterror.push('número de serie');}
        if($('#preciosalida').val() == ''){ campo.push('#preciosalida');texterror.push('precio');}
        if($('#tapa_tanquesalida').val() == ''){campo.push('#tapa_tanquesalida'); texterror.push('tapa');}
        if($('#reguladorsalida').val() == ''){campo.push('#reguladorsalida');texterror.push('regulador');}

        if(campo.length != 0){
            $.each(campo, function(index){
                $(campo[index]+'Error').text('Campo '+texterror[index]+' obligatorio');
            });
            return false;
        }

        var boolRepetido=false;
        $(".trTanqueSalida").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == numserie){
                boolRepetido=true;
            }
        })

        if(boolRepetido){
            $("#num_seriesalidaError").text('Número de serie ya agregado');
                return false;
        }

        //validar que tanque no ha sido registrado en almacene o no ha sido registrado como lleno.
        $.ajax({
            method: "post",
            url: "/validventasalida/"+numserie+'',
            data: {
                '_token': $('input[name=_token]').val(),
                },
        }).done(function(msg){
            if(msg.mensaje){
                //Insertar fila
                $.ajax({
                    method: "post",
                    url: "/insertfila/"+numserie+'',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        },
                }).done(function (msg) {
                        if(msg.alert){
                            $('#tablelistaTanques').append(
                                "<tr class='trTanqueSalida'>"+
                                "<td>"+msg.tanque.num_serie +"</td>"+ "<input type='hidden' name='salidanum_serie[]' id='salidanum_serie' value='"+msg.tanque.num_serie +"'></input>"+
                                "<td>"+msg.tanque.capacidad+' '+msg.tanque.material+' '+msg.tanque.fabricante +
                                "<td>"+Number($('#preciosalida').val()) +"</td>"+ "<input type='hidden' name='salidaPrecio[]' value='"+$('#preciosalida').val() +"'></input>"+
                                "<td>"+$('#reguladorsalida').val() +"</td>"+ "<input type='hidden' name='salidaRegulador[]' value='"+$('#reguladorsalida').val() +"'></input>"+
                                "<td>"+$('#tapa_tanquesalida').val() +"</td>"+ "<input type='hidden' name='salidaTapa[]' value='"+$('#tapa_tanquesalida').val() +"'></input>"+
                                "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFilaSalida'><span class='fas fa-window-close'></span></button>" +"</td>"+
                                "</tr>");

                            preciototal=preciototal+Number($('#preciosalida').val());
                            $('#total').remove();
                            $('#preciototal').append( 
                                "<label id='total'>"+Intl.NumberFormat('es-MX').format(preciototal) +"</label>"
                            );

                            limpiar_input_salida();

                        }else{
                            $("#num_seriesalidaError").text('Número de serie no existe');
                        }

                        return false;
                        
                }).fail(function (jqXHR, textStatus) {
                        mostrar_mensaje("#divmsg",'Error al insertar', "alert-danger",null);
                        var status = jqXHR.status;
                        if (status === 422) {
                            $.each(jqXHR.responseJSON.errors, function (key, value) {
                                var idError = "#" + key + "Error";
                                //$(idError).removeClass("d-none");
                                $(idError).text(value);
                            });
                        }
                });
            }else{
                $("#num_seriesalidaError").text('Tanque no registrado en almacén o tanque vacio');
            }
        });

        
        return false;
    }

    function limpiar_span_salida(nombreerror){
        $("#num_serie"+ nombreerror).empty();
        $("#tapa_tanque"+ nombreerror).empty();
        $("#precio"+ nombreerror).empty();
        $("#regulador"+ nombreerror).empty();
    }
    function limpiar_input_salida(){
        $("#num_seriesalida").val('');
        $("#tapa_tanquesalida").val('');
        $("#preciosalida").val('');
        $("#reguladorsalida").val('');
    }
    
    
///MANDAR AL CONTROLADOR

    function insertAll(){


        metodo_limpiar_span('Error');

        //SI no hay tanquies agregados en seccion entrada
        if($('input[id=registronum_serie]').length === 0) {
            mostrar_mensaje("#divmsgentrada",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }
        //SI no hay tanquies agregados en seccion salida
        if($('input[id=salidanum_serie]').length === 0) {
            mostrar_mensaje("#divmsgsalida",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }

        //variable donde guarda todo el data que se envia al controllador
        var dataFormulario=$("#idFormNewVenta").serialize(); //+'&pago_realizado=' + pagoRealizado;

        //envio al controlador
        $.ajax({
            method: "post",
            url: "/insertventas",
            data: dataFormulario, 
        }).done(function(){
            
            window.location = "/ventas";
        })
        .fail(function (jqXHR, textStatus) {
            //Si existe algun error entra aqui
            mostrar_mensaje("#divmsgnota",'Error, Verifica tus datos', "alert-danger",null);
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key + "Error";
                    //$(idError).removeClass("d-none");
                    $(idError).text(value);
                });
            }
        });


    }

    function cancelarAll(){
        window.location = "/ventas";
    }






    //Metodos generales

    function metodo_limpiar_span(nombreerror) {
        $("#cliente"+ nombreerror).empty();
        $("#direccion"+ nombreerror).empty();
        $("#telefono"+ nombreerror).empty();
        $("#rfc"+ nombreerror).empty();
        $("#cfdi"+ nombreerror).empty();
        $("#direccion_factura"+ nombreerror).empty();
        $("#metodo_pago"+ nombreerror).empty();
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

    $('.precio').keypress(function (event) {
        // console.log(event.charCode);
        if (
            event.charCode == 43 ||
            event.charCode == 45 || 
            event.charCode == 69 ||
            event.charCode == 101   
            ){
            return false;
        } 
        return true;
    });
        

});
