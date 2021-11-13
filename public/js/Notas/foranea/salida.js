$(document).ready(function () {

    $(document).on("click","#btn-insert-fila-salida", insertar_fila_salida);
    $(document).on("click","#btnEliminarFila", eliminarFila);

    

    //Datos Facturacion 
    $(document).on("click","#btnFacturacion", datosfacturacion);
    $(document).on("click","#btnFacturacionCancelar", datosfacturacioncancelar);

    //datos envio
    $(document).on("click","#btn-add-envio", addenvio);
    $(document).on("click","#btn-remove-envio", removeenvio);

    //Nota General
    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);
    $(document).on("click","#guardar-nota", guardar_nota);


    //FUNCIONES INSERTAR FILA SALDIA
    function insertar_fila_salida() {
        
        var numserie= $('#serie_tanque').val().replace(/ /g,'');//eliminar espacios

        //validar campos no vacios
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

        //validar campos repetidos
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


        $.get('/tanque/show_numserie/' + numserie, function(msg) { 
            if(msg != ''){
                if(msg.estatus == 'LLENO-ALMACEN'){
                    var precio_importe= $('#precio_unitario').val() * $('#cantidad').val();
                    var iva =0;
                            
                    if( msg.tipo_tanque == 'Industrial'){
                        iva = precio_importe * 0.16;
                    }

                    $('#tablelistaTanques').append(
                        "<tr class='classfilatanque'>"+
                            "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie_salida' value='"+msg.num_serie +"'></input>"+
                            "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                            "<td>"+msg.tipo_gas +"</td>"+ "<input type='hidden' name='input_tipo_gas[]' value='"+msg.tipo_gas +"'></input>"+
                            "<td>"+$('#cantidad').val() +"</td>"+ "<input type='hidden' name='input_cantidad[]' value='"+$('#cantidad').val() +"'></input>"+
                            "<td>"+$('#unidad_medida').val() +"</td>"+ "<input type='hidden' name='input_unidad_medida[]' value='"+$('#unidad_medida').val() +"'></input>"+
                            "<td>"+$('#precio_unitario').val() +"</td>"+ "<input type='hidden' name='input_precio_unitario[]' value='"+$('#precio_unitario').val() +"'></input>"+
                            "<td>"+precio_importe +"</td>"+ "<input type='hidden' name='input_importe[]' value='"+precio_importe +"'></input>"+
                            "<td>"+iva +"</td>"+ "<input type='hidden' name='input_iva_particular[]' value='"+iva +"'></input>"+

                            "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                        "</tr>");

                        actualizar_subtotal();
                        limpiar_inputs_fila();

                }else{
                    $("#serie_tanqueError").text('Error Tanque - estatus: '+ msg.estatus);
                }
            }else{
                $("#serie_tanqueError").text('Número de serie no existe en almacén');
            }

        });

        return false;
    }

    $("#unidad_medida").change( function() {
        if ($(this).val() == "CARGA") {
            $("#cantidad").prop("readonly", true);
            $("#cantidad").val(1);

        }else{
            $("#cantidad").prop("readonly", false);
        } 
    });

    function limpiar_inputs_fila() {
        $("#serie_tanque").val("");
        $("#tapa_tanque").val("");
        $("#cantidad").val("");
        $("#unidad_medida").val("");
        $("#precio_unitario").val("");
        $("#iva").val("");
    }


    //Datos facturacion
    function datosfacturacion(){
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
                "<button type='button' class='btn btn-sm btn-amarillo' id='btnFacturacion'>"+
                    "<span class='fas fa-plus'></span>Datos Facturacion"+
                "</button>"+
            "</div>"
        );
    }
    //fin Datos facturacion

    //Funciones Envio
    function addenvio(){

        var campo= ['direccion_modal','referencia_modal','precio_modal', 'link_ubicacion_modal'];
        var campovacio = [];

        $.each(campo, function(index){
            $('#'+campo[index]+'Error').empty();
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


        if( $("#precio_envio_modal").val() < 0 ){
            mensaje('error','Error', 'Precio no puede ser menor a 0', null, null)
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
                        '<textarea name="direccion_envio" id="direccion_envio" class="form-control"  rows="2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>'+$("#direccion_modal").val()+'</textarea>'+
                    '</div>'+
                '</div>'+
                '<div class="form-row">'+
                    '<div class="input-group input-group-sm mb-3">'+
                        '<div class="input-group-prepend">'+
                            '<span class="input-group-text" id="inputGroup-sizing-sm">Referencias:</span>'+
                        '</div>'+
                        '<textarea name="referencia_envio" id="referencia_envio" class="form-control" rows="2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>'+$("#referencia_modal").val()+'</textarea>'+
                    '</div>'+
                '</div>'+
                '<div class="form-row">'+
                    '<div class="input-group input-group-sm mb-3">'+
                        '<div class="input-group-prepend">'+
                            '<span class="input-group-text" id="inputGroup-sizing-sm">Link Ubicación:</span>'+
                        '</div>'+
                        '<textarea name="link_ubicacion_envio" id="link_ubicacion_envio" class="form-control" rows="2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>'+$("#link_ubicacion_modal").val()+'</textarea>'+
                    '</div>'+
                '</div>'+
                '<div class="form-row">'+
                    '<div class="input-group input-group-sm mb-3">'+
                        '<div class="input-group-prepend">'+
                            '<span class="input-group-text" id="inputGroup-sizing-sm">Precio Envio:</span>'+
                        '</div>'+
                        '<input id="precio_envio_temporal" type="number" value="'+$("#precio_modal").val()+'" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>'+
                    '</div>'+
                '</div>'+
            '</div>'
        )

        $('#label-precio-envio').replaceWith( 
            "<label id='label-precio-envio'>$ "+Intl.NumberFormat('es-MX').format($("#precio_modal").val()) +"</label>"
        );
        $('#precio_envio').val($("#precio_modal").val());
        actualizar_total();

    }

    function removeenvio(){
        $('#input-group-envio').remove();
        $('#row-envio').append(
            '<div id="div-btn-modal-envio" class="form-row justify-content-end">'+
                '<button id="btn-modal-envio" type="button" class="btn btn-sm btn-amarillo" data-toggle="modal" data-target="#modal-envio"> <span class="fas fa-plus"></span> Agregar Envio</button>'+
            '</div>'
        )
        $('#label-precio-envio').replaceWith( 
            "<label id='label-precio-envio'>"+Intl.NumberFormat('es-MX').format(0) +"</label>"
        );
        
        $('#precio_envio').val(0);

        actualizar_total();
    }

    //funciones generales
    function mensaje(icono,titulo, mensaje, timer, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: timer,
            width: 300,
        })
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
        actualizar_subtotal();
    }

    $("#metodo_pago").change( function() {
        if ($(this).val() == "Efectivo") {
            $("#ingreso-efectivo").prop("disabled", false);

        }else{
            $("#ingreso-efectivo").prop("disabled", true);
            $("#ingreso-efectivo").val(0);

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

    //aritmeticas
    function actualizar_subtotal(){

        var importe = 0;

        $(".classfilatanque").each(function(){
            var preciotanque=$(this).find("td")[6].innerHTML;
            importe=importe+parseFloat(preciotanque);
        })
        actualizar_ivageneral();

        var subtotal = importe -  $('#input-ivaGen').val();
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
    }

    function actualizar_total(){
        var importe = 0;

        $(".classfilatanque").each(function(){
            var preciotanque=$(this).find("td")[6].innerHTML;
            importe=importe+parseFloat(preciotanque);
        })

        var total=parseFloat($("#precio_envio").val()) + importe;
        $('#label-total').replaceWith( 
            "<label id='label-total'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );
        $('#input-total').val(total);
        $("#monto_pago").val(total);
    }


    //Funciones finales de Nota General

    function pagar_nota(){
        $("#nombre_cliente").removeClass('is-invalid');
        if($("#nombre_cliente").val() == ''){
            $("#nombre_cliente").addClass('is-invalid');
            return false;
        }


        //SI no hay tanques agregados en salida manda error
        if($('#idInputNumSerie_salida').length === 0) {
            mensaje('error','Error', 'No hay registro de tanques de salida', null, null);
            return false;
        }

        //Si Metodo de pago esta vacio mandar error
        if($("#metodo_pago").val()==''){
            $("#metodo_pago").addClass('is-invalid');
            $("#metodo_pagoError").text('Selecciona un metodo de pago');
            return false;
        }else{
            $("#metodo_pago").removeClass('is-invalid');
            $("#metodo_pagoError").empty();
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
            url: "/nota/foranea/salida/save",
            data: $("#idFormNewVenta").serialize(), 
        }).done(function(msg){
            if(msg.mensaje =='Registro-Correcto'){
                window.open("/pdf/nota/foranea/"+ msg.notaId, '_blank');
                window.location = '/nota/foranea/index';
            }
            
        })
        .fail(function (jqXHR, textStatus) {
            //Si existe algun error entra aqui
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
        Swal.fire({
            title: 'CANCELAR',
            text: "¿Estas seguro de cancelar esta venta?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Continuar!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = '/nota/foranea/index';
            }
        })
    }


    
    //Para Validar Campos

    $('.anio_format').keypress(function (event) {
        if (this.value.length === 4||
            event.charCode == 43 || //+
            event.charCode == 45 || //-
            event.charCode == 69 || //E
            event.charCode == 101|| //e
            event.charCode == 46    //.
            ) {
            return false;
        }
    });

});