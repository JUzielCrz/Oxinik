$(document).ready(function () {


    $(document).on("click","#btn-pagar-nota", pagar_nota);

    $(document).on("click","#btnInsertFila", insertfila);
    $(document).on("click","#btnEliminarFila", eliminarFila);


    $(document).on("click","#btn-addEnvio", addenvio);
    $(document).on("click","#btn-remove-envio", removeenvio);
    $(document).on("click","#btn-modal-envio", modal_edit_envio);
    $(document).on("click","#btn-save-envio", save_edit_envio);

    $(document).on("click","#guardar-nota", guardar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);

    //BUSCAR CONTRATO

        $('#numcontrato').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                    method: "POST",
                    url:"/nota/contrato/salida/search_contrato",
                    data:{'query':query,'_token': $('input[name=_token]').val(),},
                    success:function(data){
                        $('#listarcontratos').fadeIn();  
                        $('#listarcontratos').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function(){  
            $('#listarcontratos').fadeOut();  
            const numcontrato = $(this).text().split(', ');

            $.ajax({
                method: "post",
                url: "/nota/data_contrato/"+numcontrato[0],
                data: {'_token': $('input[name=_token]').val(),},
            })
            .done(function(msg) {
                $('#contrato_id').val(msg.contrato.contrato_id)
                if(msg.contrato.nombre == null){
                    $('#nombre_cliente').val('------')
                }else{
                    $('#nombre_cliente').val(msg.contrato.nombre+' '+msg.contrato.apPaterno+' '+msg.contrato.apMaterno)
                };  
                $('#nombre_empresa').val(msg.contrato.empresa)
                $('#tipo_contrato').val(msg.contrato.tipo_contrato)
                $('#tablelistaTanques').empty();

                show_nota_lista_tanques(msg.contrato.contrato_id, 'tbody-tanques-nota');
                show_table_asignaciones(msg.contrato.contrato_id, 'tableasignaciones', 'content-asignaciones');
            })

            $("#InputsFilaSalida").prop("disabled", false);

            $('#numcontrato').val('');
            
            if($("#input-group-envio").length){
                removeenvio(); 
            }
            
        }); 

        function show_nota_lista_tanques(contrato_id, tbody) {
            
            $.get('/nota/contrato/entrada/tanques_pendientes/' + contrato_id, function(data) {
                var columnas='';
                var contador=0;
                $.each(data, function (key, value) {
                    contador+=1;
                    columnas+='<tr class="class-tanques-nota"><td>'+
                    contador+'</td><td>'+
                    value.num_serie+'</td><td>'+
                    value.tanque_desc+'</td><td>'+
                    value.tapa_tanque+'</td><td>'+
                    value.fecha+ '</td><td>' +
                    value.nota_id+'</td><td>'+
                    '<a type="button" href="/pdf/nota/'+value.nota_id+'" target="_blank" class="btn btn-sm btn-verde btn-nota-id" ><i class="fas fa-sticky-note"></i></a></td></tr>';
                });
                $('.class-tanques-nota').remove();
                $('#'+tbody).append(columnas);
            });
        }
    //FIN BUSCAR CONTRATO



    $('#serie_tanque').keypress(function (event) {
        if (event.charCode == 13 ){
            event.preventDefault();
            insertfila();
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

    function insertfila() {

        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();
        $("#serie_tanqueError").empty();

        // var campo= ['serie_tanque','cantidad','unidad_medida','precio_unitario','tapa_tanque'];
        // var campovacio = [];

        // $.each(campo, function(index){
        //     $('#'+campo[index]+'Error').empty();
        //     $('#'+campo[index]).removeClass('is-invalid');
        // });

        // $.each(campo, function(index){
        //     if($("#"+campo[index]).val()=='' || $("#"+campo[index]).val()<=0    ){
        //         campovacio.push(campo[index]);
        //     }
        // });

        // if(campovacio.length != 0){
        //     $.each(campovacio, function(index){
        //         $("#"+campovacio[index]).addClass('is-invalid');
        //         $("#"+campovacio[index]+'Error').text('Necesario');
        //     });
        //     return false;
        // }

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
            if(msg != ''){
                $.get('/tanque/validar_talon/' + numserie, function(rsta) {
                    if(rsta){
                        $("#serie_tanqueError").text('Cilindro se encuentra en nota talon');
                        $('#serie_tanque').val('');
                        return false;
                    }
                    $.get('/tanque/validar_ph/' + msg.ph, function(respuesta) {
                        if(respuesta.alert=='vencido'){
                            //detener 
                            mensaje("error","PH: "+msg.ph, respuesta.mensaje, null, null);
                            $('#serie_tanque').val('')
                            return false;
                        }
                        if(respuesta.alert){
                            mensaje("warning","PH: "+msg.ph, respuesta.mensaje, null, null);
                        }
                        if(msg.estatus == 'LLENO-ALMACEN' || msg.estatus == 'TANQUE-RESERVA'){
                            var observaciones='';
                            if(msg.estatus == 'TANQUE-RESERVA'){
                                observaciones='Se eliminara reserva';
                                // mensaje('info','Exito','Despues de guardar la nota este cilindro se eliminara de PENDIENTES RESERVA',null,null);
                            }
                            $.ajax({
                                method: "post",
                                url: "/nota/contrato/salida/validar_tanqueasignacion",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'contrato_id': $('#contrato_id').val(),
                                    'num_serie': numserie,
                                    },
                            })
                            .done(function(msgasignacion){
                                var tapa_tanque = "<option value=''>Selecciona</option><option value='SI'>SI</option><option value='NO'>NO</option>";
                                if($('#tapa_tanque').val()=='SI'){tapa_tanque = "<option value=''>Selecciona</option><option selected value='SI'>SI</option><option value='NO'>NO</option>";}
                                if($('#tapa_tanque').val()=='NO'){tapa_tanque = "<option value=''>Selecciona</option><option value='SI'>SI</option><option selected value='NO'>NO</option>";}
                                var unidad_medida = "<option value=''>Selecciona</option><option value='CARGA'>CARGA</option><option value='kg'>kg</option><option value='M3'>M3</option>";
                                if($('#unidad_medida').val()=='CARGA'){unidad_medida = "<option value=''>Selecciona</option><option selected value='CARGA'>CARGA</option><option value='kg'>kg</option><option value='M3'>M3</option>";}
                                if($('#unidad_medida').val()=='kg'){unidad_medida = "<option value=''>Selecciona</option><option value='CARGA'>CARGA</option><option selected value='kg'>kg</option><option value='M3'>M3</option>";}
                                if($('#unidad_medida').val()=='M3'){unidad_medida = "<option value=''>Selecciona</option><option value='CARGA'>CARGA</option><option value='kg'>kg</option><option selected value='M3'>M3</option>";}
                                var cantidad=$('#cantidad').val();
                                var precio_unitario=$('#precio_unitario').val();
                                var ivaPart=0;

                                ivaPart=0;
                                if( msg.tipo_tanque == 'Industrial'){
                                    ivaPart=precio_unitario * 0.16;
                                }else{
                                    ivaPart=0;
                                }

                                if(msgasignacion.mensaje){
                                    $('#tablelistaTanques').append(
                                        "<tr class='classfilatanque'>"+
                                        "<td class='p-0 m-0'>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                                        "<td class='width-column p-0 m-0'><select name='inputTapa[]' id='inputTapa' class='form-control form-control-sm p-0 m-0'>"+tapa_tanque +"</select></td>"+
                                        "<td class='p-0 m-0'>"+msg.gas_nombre +"</td>"+ "<input type='hidden' name='input_tipo_gas[]' value='"+msg.tipo_gas +"'></input>"+
                                        "<td class='width-column p-0 m-0'><input type='number' name='input_cantidad[]' value="+cantidad+" class='form-control form-control-sm p-0 m-0'></input></td>"+
                                        "<td class='width-column p-0 m-0'><select name='input_unidad_medida[]' id='input_unidad_medida' class='form-control form-control-sm p-0 m-0'>"+unidad_medida+"</select></td>"+
                                        "<td class='width-column p-0 m-0'><input type='number' name='input_importe[]' id='input_importe' value="+precio_unitario+" class='import_unit form-control form-control-sm p-0 m-0'></input></td>"+
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

                                        limpiar_campos_salida();
                                        return false;
                                }else{
                                    $("#serie_tanqueError").text('No tiene asignado en contrato este tipo de tanque');
                                }
                            }); 
                        }else{
                            $("#serie_tanqueError").text('Error Tanque - estatus: '+ msg.estatus);
                        }
                    });
                });
            }else{
                $("#serie_tanqueError").text('Número de serie no existe');
                $('#serie_tanque').val('')
                return false;
            }
            
        });
        $('#serie_tanque').val('')
        return false;
    }

    function limpiar_campos_salida(){
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
        if($('#precio_unitario_check').is(':checked') != true){
            $("#precio_unitario").val(0);
        }
    };
    function eliminarFila(){
        $(this).closest('tr').remove();
    }

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
        total=importe + parseFloat($("#precio_envio").val());

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


  // FUNCIONES DE ENVIO
    function addenvio(){
        if($('#contrato_id').val() == ''){
            return false;
        }
        $.ajax({
            method: "get",
            url: "/contrato/envio/show/"+$("#contrato_id").val(),
            data: {'_token': $('input[name=_token]').val(),},
        })
        .done(function(msg) {
            $('#btn-addEnvio').remove();

            if($("#input-group-envio").length){
                return false;
            }else{
                $('#row-envio').append(
                    '<div class="row mr-3" id="input-group-envio">'+
                        '<div class="col-auto mr-auto">'+
                            '<div  class="input-group input-group-sm  mb-3">'+
                                '<div class="input-group-prepend ">'+
                                    '<button id="btn-remove-envio" class="btn btn-sm btn-amarillo" type="button"><span class="fas fa-minus"></span></button>'+
                                '</div>'+
                                '<div class="input-group-prepend ">'+
                                        '<button id="btn-modal-envio" class="btn btn-amarillo btn-sm " type="button"><span class="fas fa-edit"></span></button>'+
                                '</div>'+
                                '<div class="input-group-append">'+
                                    '<label class="ml-2">Envío: </label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-auto">'+
                            '<div  class="input-group input-group-sm  mb-3">'+
                                '<div class="input-group-prepend ">'+
                                    '<label id="label_precio_envio">$ '+ Intl.NumberFormat('es-MX').format(msg.contratos.precio_transporte) +'</label>'+
                                '</div>'+
                                
                            '</div>'+
                        '</div>'+

                    '</div>'
                )
                $('#precio_envio').val(msg.contratos.precio_transporte);
                $('#precio_transporte').val(msg.contratos.precio_transporte);
                $('#direccion').val(msg.contratos.direccion);
                $('#referencia').val(msg.contratos.referencia);
                actualizar_operaciones();
            }
        })
        
        
    }

    function removeenvio(){
        $('#input-group-envio').remove();
        $('#row-envio').append(
            '<button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>'
        )
        $('#precio_envio').val(0);
        actualizar_operaciones();
    }

    function modal_edit_envio(){
        $('#modal-edit-evio').modal("show");
    }

    function save_edit_envio(){

        $.ajax({
            method: "post",
            url: "/nota/contrato/salida/save_envio/"+$('#contrato_id').val(),
            data: $('#form-edit-envio').serialize(),
        }).done(function(msg){
            $('#precio_envio').val(msg.precio_transporte);
            actualizar_operaciones();
            mostrar_mensaje('#msg-envio-save','editado correctamente','alert-primary' ,'#modal-edit-evio');
            $('#label_precio_envio').replaceWith('<label id="laber_envio">$ '+ Intl.NumberFormat('es-MX').format(msg.precio_transporte) +'</label>');
        })  
    }
  // FIN FUNCIONES DE ENVIO

    function pagar_nota(){
        actualizar_operaciones();
        if($('#contrato_id').val() == '') {
            mostrar_mensaje("#msg-contrato",'Error, falta información de contrato', "alert-danger",null);
            return false;
        }

        if(validar_tabla_saldas()){
            mensaje('error','Error','Faltan campos por rellenar', 1500, null);
            return false;
        };
        
        //SI no hay tanques agregados manda error
        if($('input[id=idInputNumSerie]').length === 0) {
            mostrar_mensaje("#msg-tanques",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }

        $('#static-modal-pago').modal("show");
    }

    function validar_tabla_saldas(){
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

    $("#metodo_pago").change( function() {
        if ($(this).val() == "Efectivo") {
            $("#ingreso-efectivo").prop("disabled", false);
            var cambio= parseFloat($("#ingreso-efectivo").val())-parseFloat($("#monto_pago").val());
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
        var cambio= parseFloat($("#ingreso-efectivo").val())-parseFloat($("#monto_pago").val());
        $("#label-cambio").replaceWith(
                "<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
        );
    });

    $("#monto_pago").keyup( function() {
        var adeudo = parseFloat($("#input-total").val())- parseFloat($("#monto_pago").val());
        $("#label-adeudo").replaceWith(
            "<label id='label-adeudo'>"+Intl.NumberFormat('es-MX').format(adeudo)+"</label>"
        );
        var cambio= parseFloat($("#ingreso-efectivo").val())-parseFloat($("#monto_pago").val());
        $("#label-cambio").replaceWith(
                "<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
        );
    });

    function guardar_nota(){
        if(parseFloat($('#monto_pago').val()) < 0) {
            $("#metodo_pagoError").text('Monto debe ser mayor igual a 0');
            return false;
        }

        $("#ingreso-efectivoError").empty();
        if($("#metodo_pago").val()=='Efectivo'){
            if(parseFloat($("#ingreso-efectivo").val()) == 0){
                $("#ingreso-efectivoError").text('Campo ingreso de efectivo obligatorio');
                return false;
            }
            if(parseFloat($("#ingreso-efectivo").val()) < parseFloat($("#monto_pago").val())){
                $("#ingreso-efectivoError").text('INGRESO EFECTIVO no puede ser menor a MONTO A PAGAR');
                return false;
            }
        }

        if($("#metodo_pago").val()==''){
            $("#metodo_pago").addClass('is-invalid');
            $("#metodo_pagoError").text('Selecciona un metodo de pago');
            return false;
        }else{
            $("#metodo_pago").removeClass('is-invalid');
            $("#metodo_pagoError").empty();
        }


        if(parseFloat($("#monto_pago").val()) > parseFloat($("#input-total").val())){
            $("#ingreso-efectivoError").text('Monto de pago no puede ser mayor al total de la nota');
            return false;
        }else{
            $("#ingreso-efectivoError").empty();
        }


        // envio al controlador
        $("#guardar-nota").prop("disabled", true);
        $.ajax({
            method: "post",
            url: "/nota/contrato/salida/save",
            data: $("#form-salida-nota").serialize(), 
        }).done(function(msg){
            window.open("/pdf/nota/"+ msg.notaId, '_blank');
            location.reload();
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


      // FUNCIONES DE ASIGNACION DE TANQUES

    function show_table_asignaciones(contrato_id, idTabla, idDiv) {
        console.log(contrato_id);
        $.get('/asignaciones/show/' + contrato_id, function(data) {
            
            var columnas='';
            $.each(data.asigTanques, function (key, value) {
                columnas+='<tr><td>'+
                value.cilindros+'</td><td>'+
                value.nombreGas+'</td><td>'+
                value.tipo_tanque+'</td><td>'+
                value.material+'</td><td> $'+
                value.precio_unitario+'</td><td>'+
                value.capacidad+" "+value.unidad_medida+'</td></tr>';
            });

            $('#'+idTabla).remove();
            $('#'+idDiv).append(
                '<div id="'+idTabla+'" class="table-responsive">'+
                    '<table class="table table-sm" style="font-size:12px;">'+
                        '<tbody>'+
                            columnas+
                        '</tbody>'+
                    '</table>'+
                '</div>'
            );
        })
    }

    

    
  // FIN FUNCIONES DE ASIGNACION DE TANQUES



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

    function mensaje(icono,titulo, mensaje, tiempo, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: tiempo,
            width: 300,
        })
    }

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

    $('.numero-decimal-positivo').keypress(function (event) {
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

    //Cancelar nota
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
                location.reload();
            }
        })
    }

});




