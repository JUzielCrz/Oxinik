$(document).ready(function () {

    $(document).on("click","#btn-insert-fila-salida", insertar_fila_salida);
    $(document).on("click","#btnEliminarFila", eliminarFila);


    //Nota General
    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);
    $(document).on("click","#guardar-nota", guardar_nota);

    //Añadir envio a nota
    $(document).on("click","#btn-addEnvio", addenvio);
    $(document).on("click","#btn-remove-envio", removeenvio);


    $('#serie_tanque').keypress(function (event) {
        if (event.charCode == 13 ){
            event.preventDefault();
            insertar_fila_salida();
        }
    });

    //FUNCIONES INSERTAR FILA SALDIA
    function insertar_fila_salida() {
        
        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();;//eliminar espacios
        $("#serie_tanqueError").empty();
        
        //validar campos no vacios
        if(numserie==''){
            $("#serie_tanqueError").text("Número de serie necesario");
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
            $('#serie_tanque').val('');
            return false;
        }

        $.get('/tanque/show_numserie/' + numserie, function(msg) { 
            var observaciones='';
            if(msg != ''){
                $.get('/tanque/validar_talon/' + numserie, function(rsta) {
                    if(rsta){
                        $("#serie_tanqueError").text('Cilindro se encuentra en nota talon');
                        $('#serie_tanque').val('');
                        return false;
                    }
                    if(msg.estatus == 'LLENO-ALMACEN' || msg.estatus == 'TANQUE-RESERVA'){
                        if(msg.estatus == 'TANQUE-RESERVA'){
                            observaciones='Se eliminara de pendientes reserva';
                        }
                        // var precio_importe= $('#precio_unitario').val();
                        // var iva =0;
                                
                        // if( msg.tipo_tanque == 'Industrial'){
                        //     iva = precio_importe * 0.16;
                        // }
                        var tapa_tanque = "<option value=''>Selecciona</option><option value='SI'>SI</option><option value='NO'>NO</option>";
                        if($('#tapa_tanque').val()=='SI'){tapa_tanque = "<option value=''>Selecciona</option><option selected value='SI'>SI</option><option value='NO'>NO</option>";}
                        if($('#tapa_tanque').val()=='NO'){tapa_tanque = "<option value=''>Selecciona</option><option value='SI'>SI</option><option selected value='NO'>NO</option>";}
                        var unidad_medida = "<option value=''>Selecciona</option><option value='CARGA'>CARGA</option><option value='kg'>kg</option><option value='M3'>M3</option>";
                        if($('#unidad_medida').val()=='CARGA'){unidad_medida = "<option value=''>Selecciona</option><option selected value='CARGA'>CARGA</option><option value='kg'>kg</option><option value='M3'>M3</option>";}
                        if($('#unidad_medida').val()=='kg'){unidad_medida = "<option value=''>Selecciona</option><option value='CARGA'>CARGA</option><option selected value='kg'>kg</option><option value='M3'>M3</option>";}
                        if($('#unidad_medida').val()=='M3'){unidad_medida = "<option value=''>Selecciona</option><option value='CARGA'>CARGA</option><option value='kg'>kg</option><option selected value='M3'>M3</option>";}
                        var cantidad=$('#cantidad').val();
                        var importe=0;
                        importe=$('#importe').val();
                        var ivaPart=0;

                        ivaPart=0;
                        if( msg.tipo_tanque == 'Industrial'){
                            ivaPart=importe * 0.16;
                        }else{
                            ivaPart=0;
                        }

                        $('#tablelistaTanques').append(
                        "<tr class='classfilatanque'>"+
                        "<td class='p-0 m-0'>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                        "<td class='width-column p-0 m-0'><select name='inputTapa[]' id='inputTapa' class='form-control form-control-sm p-0 m-0'>"+tapa_tanque +"</select></td>"+
                        "<td class='p-0 m-0'>"+msg.gas_nombre +"</td>"+ "<input type='hidden' name='input_tipo_gas[]' value='"+msg.tipo_gas +"'></input>"+
                        "<td class='width-column p-0 m-0'><input type='number' name='input_cantidad[]' value='"+cantidad+"' class='form-control form-control-sm p-0 m-0'></input></td>"+
                        "<td class='width-column p-0 m-0'><select name='input_unidad_medida[]' id='input_unidad_medida' class='form-control form-control-sm p-0 m-0'>"+unidad_medida+"</select></td>"+
                        "<td class='width-column p-0 m-0'><input type='number' name='input_importe[]' id='input_importe' value='"+importe+"' class='import_unit form-control form-control-sm p-0 m-0'></input></td>"+
                        "<td class='width-column p-0 m-0'><input type='number' name='input_iva_particular[]' value="+ivaPart+" class='result_iva form-control form-control-sm p-0 m-0' readonly></input></td>"+    
                        "<td class='width-column p-0 m-0'>"+observaciones+"</td>"+
                        "<td class='p-0 m-0 text-center align-self-center'>"+ "<button type='button' class='btn btn-naranja p-0 m-0' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                        "</tr>");
                        
                        
                        $(".import_unit").keyup( function() {
                            var ivaPart=$(this).val() * 0.16;
                            if( msg.tipo_tanque == 'Industrial'){
                                $(this).parents("tr").find(".result_iva").val(ivaPart);

                            }else{
                                $(this).parents("tr").find(".result_iva").val(0);
                            }
                        });

                        limpiar_inputs_fila();

                    }else{
                        $("#serie_tanqueError").text('Error Tanque - estatus: '+ msg.estatus);
                        $('#serie_tanque').val('');
                    }
                });
            }else{
                $("#serie_tanqueError").text('Número de serie no existe en almacén');
                $('#serie_tanque').val('');
            }

        });
        $('#serie_tanque').val('');
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
        $('#serie_tanque').val('')
        if($('#tapa_tanque_check').is(':checked')!= true){
            $("#tapa_tanque").val('');
        }
        if($('#cantidad_check').is(':checked') != true){
            $("#cantidad").val(0);
        }
        if($('#unidad_medida_check').is(':checked') != true){
            $("#unidad_medida").val('');
        }
        if($('#importe_check').is(':checked') != true){
            $("#importe").val(0);
        }
    }

    //aritmeticas

    function actualizar_operaciones(){
        var importe = 0;
        var subtotal = 0;
        var iva_general = 0;
        var total = 0;

        //Operaciones
        $('.import_unit').each(function(){
            importe += parseFloat($(this).val());
        });

        $('.result_iva').each(function(){
            iva_general += parseFloat($(this).val());
        });

        subtotal= importe-iva_general;
        total=importe + parseFloat($("#precio_envio_nota").val());

        //remplazos de valores
        $('#label-ivaGen').replaceWith( 
            "<label id='label-ivaGen'>"+Intl.NumberFormat('es-MX').format(iva_general) +"</label>"
        );
        $('#label-subtotal').replaceWith( 
            "<label id='label-subtotal'>"+Intl.NumberFormat('es-MX').format(subtotal) +"</label>"
        );
        $('#label-total').replaceWith( 
            "<label id='label-total'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );

        $('#input-ivaGen').val(iva_general);
        $('#input-subtotal').val(subtotal);
        $('#input-total').val(total);
        $("#monto_pago").val(total);

    }
    
    // function actualizar_subtotal(){

    //     var importe = 0;

    //     $(".classfilatanque").each(function(){
    //         var preciotanque=$(this).find("td")[6].innerHTML;
    //         importe=importe+parseFloat(preciotanque);
    //     })
    //     actualizar_ivageneral();

    //     var subtotal = importe -  $('#input-ivaGen').val();
    //     $('#label-subtotal').replaceWith( 
    //         "<label id='label-subtotal'>"+Intl.NumberFormat('es-MX').format(subtotal) +"</label>"
    //     );
    //     $('#input-subtotal').val(subtotal);

    //     actualizar_total();
    // }

    // function actualizar_ivageneral(){

    //     var ivaGen = 0;
    //     $(".classfilatanque").each(function(){
    //         var preciotanque=$(this).find("td")[7].innerHTML;
    //         ivaGen=ivaGen+parseFloat(preciotanque);
    //     })
    //     $('#label-ivaGen').replaceWith( 
    //         "<label id='label-ivaGen'>"+Intl.NumberFormat('es-MX').format(ivaGen) +"</label>"
    //     );
    //     $('#input-ivaGen').val(ivaGen);
    // }

    // function actualizar_total(){
    //     var importe = 0;

    //     $(".classfilatanque").each(function(){
    //         var preciotanque=$(this).find("td")[6].innerHTML;
    //         importe=importe+parseFloat(preciotanque);
    //     })

    //     var total=parseFloat($("#precio_envio_nota").val()) + importe;
    //     $('#label-total').replaceWith( 
    //         "<label id='label-total'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
    //     );
    //     $('#input-total').val(total);
    //     $("#monto_pago").val(total);
    // }


    // FUNCIONES DE ENVIO
    function addenvio(){
        $('#btn-addEnvio').remove()
        $('#row-envio').append(
            '<div class="row mr-3" id="input-group-envio">'+
                '<div class="col-auto mr-auto">'+
                    '<div  class="input-group input-group-sm  mb-3">'+
                        '<div class="input-group-prepend ">'+
                            '<button id="btn-remove-envio" class="btn btn-sm btn-amarillo" type="button"><span class="fas fa-minus"></span></button>'+
                        '</div>'+
                        '<div class="input-group-append">'+
                            '<label class="ml-2">Envío: </label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="col-auto">'+
                    '<div  class="input-group input-group-sm  mb-3">'+
                        '<div class="input-group-prepend ">'+
                            '<label id="label_precio_envio">$ '+ Intl.NumberFormat('es-MX').format($('#precio_envio_show').val()) +'</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'
        )
        $('#precio_envio_nota').val($('#precio_envio_show').val());
        actualizar_operaciones();
    }

    function removeenvio(){
        $('#input-group-envio').remove();
        $('#row-envio').append(
            '<button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>'
        )
        $('#precio_envio_nota').val(0);
        actualizar_operaciones();
    }


    //Funciones finales de Nota General

    function pagar_nota(){
        
        if($('#id_show').val() == '') {
            mensaje('error','Error', 'Debes seleccionar un cliente o registralo', null, null);
            return false;
        }

        $("#nombre_cliente").removeClass('is-invalid');
        if($("#nombre_cliente").val() == ''){
            $("#nombre_cliente").addClass('is-invalid');
            return false;
        }

        //SI no hay tanques agregados en salida manda error
        if($('#idInputNumSerie').length === 0) {
            mensaje('error','Error', 'No hay registro de tanques de salida', null, null);
            return false;
        }

        if(validar_tabla_salidas()){
            mensaje('error','Error','Faltan campos por rellenar', 1500, null);
            return false;
        };
        
        $('#row-envio').empty();
        $('#row-envio').append(
            '<button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>'
        )
        $('#precio_envio_nota').val(0);

        $("#label-cambio").replaceWith("<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(0)+"</label>");
        $("#metodo_pago").val('');
        actualizar_operaciones();
        $('#static-modal-pago').modal("show");

    }

    function validar_tabla_salidas(){
        var banderamensaje=false;

        $("select[name='inputTapa[]']").each(function(indice, elemento) {
            if($(elemento).val()==""){
                $(elemento).addClass("is-invalid");
                banderamensaje=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        $("input[name='input_cantidad[]']").each(function(indice, elemento) {
            if($(elemento).val()=="" || $(elemento).val() < 1){
                $(elemento).addClass("is-invalid");
                banderamensaje=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        $("input[name='input_importe[]']").each(function(indice, elemento) {
            if($(elemento).val()=="" || $(elemento).val() < 1){
                $(elemento).addClass("is-invalid");
                banderamensaje=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        $("input[name='input_iva_particular[]']").each(function(indice, elemento) {
            if($(elemento).val()=="" || $(elemento).val() < 0){
                $(elemento).addClass("is-invalid");
                banderamensaje=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        $("select[name='input_unidad_medida[]']").each(function(indice, elemento) {
            if($(elemento).val()=="" || $(elemento).val() < 1){
                $(elemento).addClass("is-invalid");
                banderamensaje=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        return banderamensaje;
    }


    function guardar_nota(){
                // //Si Metodo de pago esta vacio mandar error
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

        var cambio = parseFloat($("#ingreso-efectivo").val())-parseFloat($("#input-total").val());

        if($("#metodo_pago").val() == "Efectivo"){
            $("#label-cambio").replaceWith(
                "<label id='label-cambio'>"+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
            );
        }
        // envio al controlador
        var dataForm= $("#idFormNewVenta").serialize()+'&metodo_pago='+$('#metodo_pago').val()+'&input-subtotal='+$('#input-subtotal').val()+'&input-total='+$('#input-total').val()+'&input-ivaGen='+$('#input-ivaGen').val();
        $("#guardar-nota").prop("disabled", true);
        $.ajax({
            method: "post",
            url: "/nota/foranea/salida/save",
            data: dataForm,  
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
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Continuar!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = '/nota/foranea/index';
            }
        })
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
    }


    $("#metodo_pago").change( function() {
        if ($(this).val() == "Efectivo") {
            $("#ingreso-efectivo").prop("disabled", false);
            var cambio= parseFloat($("#ingreso-efectivo").val())-parseFloat($("#input-total").val());
            $("#label-cambio").replaceWith(
                "<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
            );
        }else{
            $("#ingreso-efectivo").prop("disabled", true);
            $("#ingreso-efectivo").val(0);
            $("#label-cambio").replaceWith("<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(0)+"</label>");
        } 
    });

    $("#ingreso-efectivo").keyup( function() {
        var ingreso=$("#ingreso-efectivo").val();
        if(ingreso=='' || ingreso<0){
            ingreso=0;
        }
        var cambio= parseFloat(ingreso)-parseFloat($("#input-total").val());
        $("#label-cambio").replaceWith(
                "<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
        );
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