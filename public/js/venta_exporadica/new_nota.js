$(document).ready(function () {
    //Funciones de Insertar filas de tanques
    $(document).on("click","#btn-insert-fila-entrada", insertar_fila_entrada);
    $(document).on("click","#btn-insert-fila-salida", insertar_fila_salida);
    $(document).on("click","#btnEliminarFila", eliminarFila);

    //Datos Facturacion 
    $(document).on("click","#btnFacturacion", datosfacturacion);
    $(document).on("click","#btnFacturacionCancelar", datosfacturacioncancelar);

    //
    $(document).on("click","#btn-registrar-tanque", registrar_tanque);


    //datos envio
    $(document).on("click","#btn-add-envio", addenvio);
    $(document).on("click","#btn-remove-envio", removeenvio);
    
    
    //Nota General
    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);
    $(document).on("click","#guardar-nota", guardar_nota);




//FUNCIONES FILAS
    //FUNCIONES INSERTAR FILA ENTRADA
    function insertar_fila_entrada(evnt) {
        $('#serie_tanque_entradaError').empty();
        var numserie= $('#serie_tanque_entrada').val().replace(/ /g,'');
    
        if(numserie == ''){
            $('#serie_tanque_entrada').addClass('is-invalid');
            $('#serie_tanque_entradaError').text('Necesario');
            return false;
        }
        
        if($('#tapa_tanque_entrada').val() == ''){
            $('#tapa_tanque_entrada').addClass('is-invalid');
            $('#tapa_tanque_entradaError').text('Necesario');
            return false;
        }
    
        var boolRepetido=false;
        var deleteespacio=$.trim(numserie);
        $(".classfilatanque_entrada").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == deleteespacio){
                boolRepetido=true;
            }
        })
    
        if(boolRepetido){
            $("#serie_tanque_entradaError").text('Número de serie ya agregado a esta nota');
                return false;
        }
    
        //validar si el tanque existe.
        $.ajax({
            method: "get",
            url: "../venta_exporadica/validar_existencia/"+numserie+'',
        }).done(function(msg){
            if(msg.mensaje == 'tanque-en-almacen'){
                $('#serie_tanque_entradaError').text('Tanque se encuantra registrado en almacén, estatus: '+ msg.tanqueEstatus);
                return false;
            }

            if(msg.mensaje =='alert-danger'){
                $('#num_seriefila').val($('#serie_tanque_entrada').val())
                $("#modal-registrar-tanque").modal('show');
            }else{
                var descrp=msg.mensaje.capacidad+", "+msg.mensaje.material+", "+msg.mensaje.fabricante+", "+msg.mensaje.tipo_gas;
                $('#tbody-tanques-entrada').append(
                    "<tr class='classfilatanque_entrada'>"+
                    "<td>"+msg.mensaje.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie_entrada[]' id='idInputNumSerie_entrada' value='"+msg.mensaje.num_serie +"'></input>"+
                    "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion_entrada[]' value='"+descrp +"'></input>"+
                    "<td>"+msg.mensaje.ph +"</td>"+ "<input type='hidden' name='inputPh_entrada[]' value='"+msg.mensaje.ph +"'></input>"+
                    "<td>"+$('#tapa_tanque_entrada').val() +"</td>"+ "<input type='hidden' name='inputTapa_entrada[]' value='"+$('#tapa_tanque_entrada').val() +"'></input>"+
                    "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                    "</tr>");
                    $("#serie_tanque_entrada").val('');
                    $("#tapa_tanque_entrada").val('');
            }
        })
    
        return false;
    
    
    }

    function registrar_tanque(){
        limpiar_errores_tanqueRegistro("Error");
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
        if($('#reguladormodal2').val() == '' ){  campovacio.push('reguladormodal2');msgerror.push('regulador'); }
        if($('#tapa_tanquemodal2').val() == '' ){  campovacio.push('tapa_tanquemodal2');msgerror.push('tapa'); }

        if(campovacio.length != 0){
            $.each(campovacio, function(index){
                $('#'+campovacio[index]+'Error').text('Campo '+msgerror[index]+ ' obligatorio');
            });
            return false;
        }

        var fabri;
        if($("#fabricanteoficial").val() == "Otros"){
            fabri = $("#otrofabricante").val();
        }else{
            fabri = $("#fabricanteoficial").val();
        }

        var cap=$('#capacidadnum').val()+' '+ $('#unidadmedida').val();

        var descrp=cap+", "+$('#materialfila').val()+", "+fabri+", "+$('#tipo_gasfila').val();
        $('#tablelistaTanques').append(
            "<tr class='classfilasdevolucion'>"+
            "<td>"+$('#num_seriefila').val() +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+$('#num_seriefila').val() +"'></input>"+
            "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion[]' value='"+descrp +"'></input>"+
            "<td>"+$('#phfila').val() +"</td>"+ "<input type='hidden' name='inputPh[]' value='"+$('#phfila').val() +"'></input>"+
            "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
            "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
            "</tr>"
        );
            limpiar_campos_tanqueRegistro();
            $('#modal-registrar-tanque').modal("hide");
    
    }

    function registrar_tanque(){
        limpiar_errores_tanqueRegistro("Error");
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
        if($('#reguladormodal2').val() == '' ){  campovacio.push('reguladormodal2');msgerror.push('regulador'); }
        if($('#tapa_tanquemodal2').val() == '' ){  campovacio.push('tapa_tanquemodal2');msgerror.push('tapa'); }

        if(campovacio.length != 0){
            $.each(campovacio, function(index){
                $('#'+campovacio[index]+'Error').text('Campo '+msgerror[index]+ ' obligatorio');
            });
            return false;
        }

        var fabri;
        if($("#fabricanteoficial").val() == "Otros"){
            fabri = $("#otrofabricante").val();
        }else{
            fabri = $("#fabricanteoficial").val();
        }

        var cap=$('#capacidadnum').val()+' '+ $('#unidadmedida').val();

        var descrp=cap+", "+$('#materialfila').val()+", "+fabri+", "+$('#tipo_gasfila').val();
        $('#tablelistaTanques').append(
            "<tr class='classfilasdevolucion'>"+
            "<td>"+$('#num_seriefila').val() +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+$('#num_seriefila').val() +"'></input>"+
            "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion[]' value='"+descrp +"'></input>"+
            "<td>"+$('#phfila').val() +"</td>"+ "<input type='hidden' name='inputPh[]' value='"+$('#phfila').val() +"'></input>"+
            "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
            "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
            "</tr>"
        );
            limpiar_campos_tanqueRegistro();
            $('#modal-registrar-tanque').modal("hide");
    
    }

    function limpiar_errores_tanqueRegistro(nombreerror){
        $("#num_seriefila"+ nombreerror).empty();
        $("#phfila"+ nombreerror).empty();
        $("#capacidadfila"+ nombreerror).empty();
        $("#materialfila"+ nombreerror).empty();
        $("#fabricantefila"+ nombreerror).empty();
        $("#tipo_gasfila"+ nombreerror).empty();
        $("#reguladormodal2"+ nombreerror).empty();
        $("#tapa_tanquemodal2"+ nombreerror).empty();
        $("#multamodal2"+ nombreerror).empty();        
    }

    function limpiar_campos_tanqueRegistro(){
        $("#num_seriefila").val("");
        $("#phfila").val("");
        $("#capacidadnum").val("");
        $("#unidadmedida").val("m3");
        $("#materialfila").val("");
        $("#otrofabricante").val("");
        $("#fabricanteoficial").val("");
        $("#tipo_gasfila").val("");

        $('#serie_tanque').val("");
        $("#tapa_tanque").val('');
    }

    $("#fabricanteoficial").change( function() {
        if ($(this).val() == "Otros") {
            $("#otrofabricante").prop("disabled", false);
        } else {
            $("#otrofabricante").prop("disabled", true);
            $("#otrofabricante").val('');
        }
    });


    //FUNCIONES INSERTAR FILA SALDIA
    function insertar_fila_salida() {
        
        var numserie= $('#serie_tanque').val().replace(/ /g,'');

        var campo= ['serie_tanque','cantidad','unidad_medida','precio_unitario','tapa_tanque','iva_particular'];
        var campovacio = [];

        $.each(campo, function(index){
            $('#'+campo[index]+'Error').empty().removeClass('is-invalid');
            $('#'+campo[index]).removeClass('is-invalid');
        });

        $.each(campo, function(index){
            if($("#"+campo[index]).val()=='' || $("#"+campo[index]).val()<=0    ){
                campovacio.push(campo[index]);
            }
        });

        if(campovacio.length != 0){
            $.each(campovacio, function(index){
                $("#"+campovacio[index]).addClass('is-invalid');
                $("#"+campovacio[index]+'Error').text('Necesario');
            });
            return false;
        }

        var boolRepetido=false;
        var deleteespacio=$.trim(numserie);
        $(".classfilatanque").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;

            if(valores == deleteespacio){
                boolRepetido=true;
            }
        })

        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a esta nota');
                return false;
        }

        //validar que tanque no ha sido registrado en almacene o no ha sido registrado como lleno.
        $.ajax({
            method: "post",
            url: "../venta_exporadica/validar_existencia_salida/"+numserie+'',
            data: {
                '_token': $('input[name=_token]').val(),
                },
        }).done(function(msg){
            
            if(msg.mensaje){
                //Insertar fila
                $.ajax({
                    method: "get",
                    url: "/insertfila/"+numserie+'',
                })
                    .done(function (msg) {

                        var precio_importe= $('#precio_unitario').val() * $('#cantidad').val();
                        console.log(precio_importe);
                        var iva =0;
                        if( $('#iva_particular').val() == 'SI'){
                            iva = precio_importe * 0.16;
                        }
        
                        if(msg.alert){
                            $('#tablelistaTanques').append(
                                "<tr class='classfilatanque'>"+
                                "<td>"+msg.tanque.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie_salida' value='"+msg.tanque.num_serie +"'></input>"+
                                "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                                "<td>"+msg.tanque.tipo_gas +"</td>"+ "<input type='hidden' name='input_tipo_gas[]' value='"+msg.tanque.tipo_gas +"'></input>"+
                                "<td>"+$('#cantidad').val() +"</td>"+ "<input type='hidden' name='input_cantidad[]' value='"+$('#cantidad').val() +"'></input>"+
                                "<td>"+$('#unidad_medida').val() +"</td>"+ "<input type='hidden' name='input_unidad_medida[]' value='"+$('#unidad_medida').val() +"'></input>"+
                                "<td>"+$('#precio_unitario').val() +"</td>"+ "<input type='hidden' name='input_precio_unitario[]' value='"+$('#precio_unitario').val() +"'></input>"+
                                "<td>"+precio_importe +"</td>"+ "<input type='hidden' name='input_importe[]' value='"+precio_importe +"'></input>"+
                                "<td>"+iva +"</td>"+ "<input type='hidden' name='input_iva_particular[]' value='"+iva +"'></input>"+

                                "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                                "</tr>");

                                actualizar_subtotal()
                                actualizar_ivageneral()

                                limpiar_inputs_fila();
                        }else{
                            $("#serie_tanqueError").text('Número de serie no existe');
                        }
        
                        return false;
                        
                    })
                        
                    .fail(function (jqXHR, textStatus) {
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
                $("#serie_tanqueError").text('Tanque no registrado en almacén o tanque vacio');
            }
        }).fail(function(){
            $("#serie_tanqueError").text('tanque no registrado');
            }
            
        );
        return false;
    }

    function limpiar_inputs_fila() {
        $("#serie_tanque").val("");
        $("#tapa_tanque").val("");
        $("#cantidad").val("");
        $("#unidad_medida").val("");
        $("#precio_unitario").val("");
        $("#iva").val("");
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
        actualizar_subtotal();
        actualizar_total();
    }

//FIN FUNCIONES FILAS


//Datos facturacion
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
                "<button type='button' class='btn btn-sm btn-gray' id='btnFacturacion'>"+
                    "<span class='fas fa-plus'></span>Datos Facturacion"+
                "</button>"+
            "</div>"
        );
    }
//fin Datos facturacion

//funciones aritmeticas
    function actualizar_subtotal(){

        var subtotal = 0;

        $(".classfilatanque").each(function(){
            
            var preciotanque=$(this).find("td")[6].innerHTML;
            subtotal=subtotal+parseFloat(preciotanque);
        })
        $('#label-subtotal').replaceWith( 
            "<label id='label-subtotal'>"+Intl.NumberFormat('es-MX').format(subtotal) +"</label>"
        );
        $('#input-subtotal').val(subtotal);

        actualizar_total();
    }

    function actualizar_ivageneral(){

        var ivaGen = 0;
        $(".classfilatanque").each(function(){
            var preciotanque=$(this).find("td")[7].innerHTML;
            ivaGen=ivaGen+parseFloat(preciotanque);
        })
        $('#label-ivaGen').replaceWith( 
            "<label id='label-ivaGen'>"+Intl.NumberFormat('es-MX').format(ivaGen) +"</label>"
        );
        $('#input-ivaGen').val(ivaGen);

        actualizar_total();
    }

    function actualizar_total(){
        var total=parseFloat($("#precio_envio").val())+parseFloat($("#input-ivaGen").val())+parseFloat($("#input-subtotal").val());
        $('#label-total').replaceWith( 
            "<label id='label-total'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );
        $('#input-total').val(total);
        $("#monto_pago").val(total);
    }

//fin funciones aritmeticas


//Funciones Envio
    function addenvio(){
        if($("#direccion_envio_modal").val() == '' || $("#referencia_envio_modal").val() == '' || $("#precio_envio_modal").val() == '' ){
            mostrar_mensaje('#msg-envio-modal','Faltan campos por rellenar','alert-danger', null)
            return false;
        }

        $('#div-btn-modal-envio').remove();
        $('#modal-envio').modal('hide');

        $('#row-envio').append(
            '<div id="input-group-envio">'+
                '<div class="form-row mb-3">'+
                    '<div class="col">'+
                        '<span class="ml-2"><strong>Datos Envio:</strong></span>'+
                    '</div>'+
                    '<div class="col text-right">'+
                        '<button id="btn-remove-envio" class="btn btn-sm btn-amarillo" type="button"><span class="fas fa-trash-alt"></span></button>'+
                    '</div>'+
                '</div>'+

                '<div class="form-row">'+
                    '<div class="input-group input-group-sm mb-3">'+
                        '<div class="input-group-prepend">'+
                            '<span class="input-group-text" id="inputGroup-sizing-sm">Dirección:</span>'+
                        '</div>'+
                        '<textarea name="direccion_envio" id="direccion_envio" class="form-control"  rows="2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>'+$("#direccion_envio_modal").val()+'</textarea>'+
                    '</div>'+
                '</div>'+
                '<div class="form-row">'+
                    '<div class="input-group input-group-sm mb-3">'+
                        '<div class="input-group-prepend">'+
                            '<span class="input-group-text" id="inputGroup-sizing-sm">Referencias:</span>'+
                        '</div>'+
                        '<textarea name="referencia_envio" id="referencia_envio" class="form-control" rows="2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>'+$("#referencia_envio_modal").val()+'</textarea>'+
                    '</div>'+
                '</div>'+
                // '<div class="form-row">'+
                //     '<div class="input-group input-group-sm mb-3">'+
                //         '<div class="input-group-prepend">'+
                //             '<span class="input-group-text" id="inputGroup-sizing-sm">Precio Envio:</span>'+
                //         '</div>'+
                //         '<input name="precio_envio" id="precio_envio" type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>'+
                //     '</div>'+
                // '</div>'+
            '</div>'
        )

        $('#label-precio-envio').replaceWith( 
            "<label id='label-precio-envio'>"+Intl.NumberFormat('es-MX').format($("#precio_envio_modal").val()) +"</label>"
        );
        $('#precio_envio').val($("#precio_envio_modal").val());
        actualizar_total();

    }

    function removeenvio(){
        $('#input-group-envio').remove();
        $('#row-envio').append(
            '<div id="div-btn-modal-envio" class="form-row justify-content-end">'+
                '<button id="btn-modal-envio" type="button" class="btn btn-sm btn-gray" data-toggle="modal" data-target="#modal-envio"> <span class="fas fa-plus"></span> Agregar Envio</button>'+
            '</div>'
        )
        $('#label-precio-envio').replaceWith( 
            "<label id='label-precio-envio'>"+Intl.NumberFormat('es-MX').format(0) +"</label>"
        );
        
        $('#precio_envio').val(0);
        
        $("#direccion_envio_modal").val('');
        $("#referencia_envio_modal").val('');
        $("#precio_envio_modal").val('');
        actualizar_total();
    }


//Funciones de nota en general

    function pagar_nota(){

        var campo= ['nombre_cliente','telefono','email'];
        var campovacio = [];
        //Limpiar errores
        $.each(campo, function(index){
            $('#'+campo[index]+'Error').empty();
            $('#'+campo[index]).removeClass('is-invalid');
        });
        //CaCHAR SI ESTAN VACIOS
        $.each(campo, function(index){
            if($("#"+campo[index]).val()=='' || $("#"+campo[index]).val()<=0    ){
                campovacio.push(campo[index]);
            }
        });
        //RECORRER Y MOSTRAR LOS ERRORES
        if(campovacio.length != 0){
            $.each(campovacio, function(index){
                $("#"+campovacio[index]).addClass('is-invalid');
                $("#"+campovacio[index]+'Error').text('Necesario');
            });
            return false;
        }

        //SI no hay tanques agregados en entrada manda error
        if($('input[id=idInputNumSerie_entrada]').length === 0) {
            mostrar_mensaje("#msg-tanques-entrada",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }

        //SI no hay tanques agregados en salida manda error
        if($('input[id=idInputNumSerie_salida]').length === 0) {
            mostrar_mensaje("#msg-tanques-salida",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }

        //Si Metodo de pago esta vacio mandar error
        if($("#metodo_pago").val()==''){
            $("#metodo_pago").addClass('is-invalid');
            $("#metodo_pagoError").text('Selecciona un metodo de pago');
            return false;
        }else{
            $("#metodo_pago").removeClass('is-invalid');
        }

        //si metodo de pago es iguala efectivo checar error
        $("#ingreso-efectivoError").empty();
        if($("#metodo_pago").val()=='Efectivo'){
            if($("#ingreso-efectivo").val() == 0){
                $("#ingreso-efectivoError").text('Campo ingreso de efectivo obligatorio');
                return false;
            }
            
            if($("#ingreso-efectivo").val() < parseFloat($("#input-total").val())){
                $("#ingreso-efectivoError").text('ingreso efectivo no puede ser menor a total a pagar');
                return false;
            }
        }


        $('#static-modal-pago').modal("show");

        var cambio = parseFloat($("#ingreso-efectivo").val())-parseFloat($("#input-total").val());


        if($("#metodo_pago").val() == "Efectivo"){
            $("#label-cambio").replaceWith(
                "<label id='label-cambio'>"+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
            );
        }

    }

    function guardar_nota(){
        // envio al controlador
        $.ajax({
            method: "post",
            url: "/venta_exporadica/save",
            data: $("#idFormNewVenta").serialize(), 
        }).done(function(msg){
            // window.open("/pdf/nota/"+ msg.notaId, '_blank');
            // location.reload();
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

    function cancelarnota(){
        window.location = "/contrato/"+ $('#idcliente').val();
    }


//FIN Funciones de nota en general




//Generales

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

    $("#metodo_pago").change( function() {
        if ($(this).val() == "Efectivo") {
            $("#ingreso-efectivo").prop("disabled", false);

        }else{
            $("#ingreso-efectivo").prop("disabled", true);
            $("#ingreso-efectivo").val(0);

        } 
    });

    $("#unidad_medida").change( function() {
        if ($(this).val() == "CARGA") {
            $("#cantidad").prop("readonly", true);
            $("#cantidad").val(1);

        }else{
            $("#cantidad").prop("readonly", false);
        } 
    });


    $('.numero-entero-positivo').keypress(function (event) {
        // console.log(event.charCode);
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

    $('.solo-texto').keypress(function (event) {
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

    $('.lenght-telefono').keypress(function (event) {
        if (this.value.length === 10) {
            return false;
        }
    });
});
    


