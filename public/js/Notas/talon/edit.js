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

    //Editar Cliente
    $(document).on("click","#btn-editar-cliente", editar_show);
    $(document).on("click","#btn-cliente-edit-save", editar_save);

    //Crear Cliente
    $(document).on("click","#btn-cliente-create-save", create_save);


    $('#serie_tanque').keypress(function (event) {
        // console.log(event.charCode);
        if (event.charCode == 13 ){
            event.preventDefault();
            insert_fila();
        } 
    });

    if($(".tr-tanques-salida").length == $(".classfilatanque_entrada").length){
        $('.bool_disabled').prop('disabled', true);
        $("#pendiente").val(false);
    }

    //FUNCIONES INSERTAR FILA SALIDA

    function insertar_fila_salida() {

        //Eliminar espacios
        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();
        console.log(numserie);
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
        $(".tr-tanques-salida").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == numserie){
                boolRepetido=true;
            }
        })
        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a esta nota');
                return false;
        }

        //validar si tanque pertenece a cliente
        var boolPertenencia=true;
        $(".classfilatanque_entrada").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == numserie){
                boolPertenencia=false;
            }
        })
        if(boolPertenencia){
            $("#serie_tanqueError").text('Tanque no pertenece a cliente');
            return false;
        }

        $.get('/tanque/show_numserie/' + numserie, function(msg) { 
            if(msg != ''){
                if(msg.estatus == 'LLENO-ALMACEN'){

                    var precio_importe= $('#precio_unitario').val() * $('#cantidad').val();
                    var iva =0;
                    if( msg.tipo_tanque  == 'Industrial'){
                        iva = precio_importe * 0.16;
                    }

                    $('#tbody-tanques-salida').append(
                        // "<tr class='tr-tanques-salida' style='font-size: 13px'>"+
                        //     "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie_salida[]' id='idInputNumSerie_salida' value='"+msg.num_serie +"'></input>"+
                        //     "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                        //     "<td>"+msg.material+", "+msg.fabricante+", "+msg.tipo_tanque+", PH: "+msg.ph +"</td>"+ 

                        //     "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                        // "</tr>"
                        "<tr class='tr-tanques-salida'>"+
                        "<td>"+numserie +"</td>"+ "<input type='hidden' name='inputNumSerie_salida[]' id='idInputNumSerie' value='"+numserie +"'></input>"+
                        "<td>"+msg.material+", "+ msg.fabricante+", "+ msg.gas_nombre+", "+ msg.tipo_tanque+"</td>"+
                        "<td>"+msg.ph+"</td>"+
                        "<td>"+$("#tapa_tanque").val()+"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$("#tapa_tanque").val() +"'></input>"+
                        "<td>"+$("#cantidad").val()+"</td>"+ "<input type='hidden' name='inputCantidad[]' value='"+$("#cantidad").val() +"'></input>"+
                        "<td>"+$("#unidad_medida").val()+"</td>"+ "<input type='hidden' name='inputUnidad_medida[]' value='"+$("#unidad_medida").val() +"'></input>"+
                        "<td>"+$("#precio_unitario").val()+"</td>"+ "<input type='hidden' name='inputPrecio_unitario[]' value='"+$("#precio_unitario").val() +"'></input>"+
                        "<td>"+precio_importe +"</td>"+ "<input type='hidden' name='input_importe[]' value='"+precio_importe +"'></input>"+
                        "<td>"+iva.toFixed(2) +"</td>"+ "<input type='hidden' name='input_iva_particular[]' value='"+iva.toFixed(2) +"'></input>"+
                        "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                        "</tr>"
                        );

                        mensaje("success","Exito", "Agregado Correctamente" , 1500, "#modal-registrar-tanque");
                        limpiar_campos();
                        actualizar_subtotal();
                        // limpiar_campos_tanque()

                }else{
                    $("#serie_tanqueError").text('Error Tanque - estatus: '+ msg.estatus);
                }
            }else{
                $("#serie_tanqueError").text('Número de serie no existe en almacén');
            }

        });

        return false;
    }

    function limpiar_campos(){
        $("#serie_tanque_entrada").val("");
        $("#tapa_tanque").val("");
        $("#cantidad").val("");
        $("#unidad_medida").val("");
        $("#precio_unitario").val("");
        $("#iva").val("");
    }

    $("#unidad_medida").change( function() {
        if ($(this).val() == "CARGA") {
            $("#cantidad").prop("readonly", true);
            $("#cantidad").val(1);

        }else{
            $("#cantidad").prop("readonly", false);
        } 
    });

    //CREATE CLIENTE
    function create_save() {

        $.ajax({
            method: "POST",
            url: "/clientes_sc/create",
            data: $("#form-cliente-sc").serialize(),
        })
        .done(function (msg) {
            show_datos(msg.cliente_id);
            mensaje('success','Exito', "Guardado Correctamente", 1500,'#modal-create-cliente')
        })
        .fail(function (jqXHR, textStatus) {
            
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key ;
                    $(idError).addClass('is-invalid');
                });
            }

            mensaje("error","Error", "Error al actualizar, verifique sus datos.", null, null);
        });
    }

    //EDITAR CLIENTE
    function editar_show() {
        $.get('/clientes_sc/show/' + $("#id_show").val(), function(data) {
            $.each(data, function (key, value) {
                var variable = "#" + key + "_edit";
                $(variable).val(value);
                
            });
            $("#nombre_edit").removeClass("is-invalid");
            $("#apPaterno_edit").removeClass("is-invalid");
            $("#apMaterno_edit").removeClass("is-invalid");

            const nombre_separado = data.nombre.split(' ');
            $("#nombre_edit").val(nombre_separado[0]);
            $("#apPaterno_edit").val(nombre_separado[1]);
            $("#apMaterno_edit").val(nombre_separado[2]);
            $("#modalmostrar").modal("show");
        })
        
    }
    function editar_save() {
        $.ajax({
            method: "POST",
            url: "/clientes_sc/update/"+$("#id_edit"),
            data: $("#form-cliente-sc-edit").serialize(),
        })
        .done(function (msg) {
            show_datos(msg.cliente_id);
            mensaje('success','Exito', "Guardado Correctamente", 1500,'#modal-editar-cliente')
        })
        .fail(function (jqXHR, textStatus) {
            
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key ;
                    $(idError).addClass('is-invalid');
                });
            }

            mensaje("error","Error", "Error al actualizar, verifique sus datos.", null, null);
        });
    }


    // FUNCIONES DE ENVIO
    function addenvio(){
        
        if($('#num_contrato').val() == ''){
            return false;
        }
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
        actualizar_total();
        
    }

    function removeenvio(){
        $('#input-group-envio').remove();
        $('#row-envio').append(
            '<button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>'
        )
        $('#precio_envio_nota').val(0);
        actualizar_total();
    }

    //Funciones finales de Nota General
    function pagar_nota(){
        $("#id_show").removeClass('is-invalid');
        if($("#id_show").val() == ''){
            $("#id_show").addClass('is-invalid');
            return false;
        }


        //SI no hay tanques agregados en salida manda error
        if($('#idInputNumSerie').length === 0) {
            mensaje('error','Error', 'No hay registro de tanques', null, null);
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

        if($(".tr-tanques-salida").length == $(".classfilatanque_entrada").length){
            $("#pendiente").val(0);
        }
        // envio al controlador
        $.ajax({
            method: "post",
            url: "/nota/talon/edit/save/"+$("#idnota").val(),
            data: $("#idFormNewVenta").serialize(), 
        }).done(function(msg){
            if(msg.alert =='success'){  
                window.open("/pdf/nota/talon/"+ msg.notaId, '_blank');
                location.reload();
            }
            if(msg.alert =='error'){  
                mensaje('error','Error', msg.mensaje , null, null);
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
                window.location= '/nota/talon/index';
            }
        })
    }

    //aritmeticas
    function actualizar_subtotal(){
        
        var importe = 0;

        $(".tr-tanques-salida").each(function(){
            var preciotanque=$(this).find("td")[7].innerHTML;
            importe=importe+parseFloat(preciotanque);
        })
        actualizar_ivageneral();

        var subtotal = importe -  $('#input-ivaGen').val();
        $('#label-subtotal').replaceWith( 
            "<label id='label-subtotal'>"+Intl.NumberFormat('es-MX').format(subtotal) +"</label>"
        );
        $('#input-subtotal').val(subtotal   );

        actualizar_total();
    }

    function actualizar_ivageneral(){

        var ivaGen = 0;
        $(".tr-tanques-salida").each(function(){
            var preciotanque=$(this).find("td")[8].innerHTML;
            ivaGen=ivaGen+parseFloat(preciotanque);
        })
        $('#label-ivaGen').replaceWith( 
            "<label id='label-ivaGen'>"+Intl.NumberFormat('es-MX').format(ivaGen) +"</label>"
        );
        $('#input-ivaGen').val(ivaGen);
    }

    function actualizar_total(){
        var importe = 0;

        $(".tr-tanques-salida").each(function(){
            var preciotanque=$(this).find("td")[7].innerHTML;
            importe=importe+parseFloat(preciotanque);
        })

        var total=parseFloat($("#precio_envio_nota").val()) + importe;
        $('#label-total').replaceWith( 
            "<label id='label-total'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );
        $('#input-total').val(total);
        $("#monto_pago").val(total);
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