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

    //Editar Cliente
    $(document).on("click","#btn-cliente-create-save", create_save);


    $('#serie_tanque').keypress(function (event) {
        if (event.charCode == 13 ){
            event.preventDefault();
            insertar_fila_salida();
        } 
    });

    //BUSCAR CLIENTE Y RELLENAR CAMPOS SHOW
    $('#search_cliente').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
            $.ajax({
                method: "POST",
                url:"/clientes_sc/search",
                data:{'query':query,'_token': $('input[name=_token]').val(),},
                success:function(data){
                    $('#listarclientes').fadeIn();  
                    $('#listarclientes').html(data);
                }
            });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#listarclientes').fadeOut();  
        const clientes_sc = $(this).text().split(', ');
        show_datos(clientes_sc[0]);
        $("#search_cliente").val("")
        
    }); 

    function show_datos(id) {
        $.ajax({
            method: "get",
            url: "/clientes_sc/show/"+id,
            data: {'_token': $('input[name=_token]').val(),},
        })
        .done(function(msg) {
            $.each(msg, function(index, value){
                $("#"+index+"_show").val(value);
            });
        })
        if($("#input-group-envio").length){
            removeenvio(); 
        }
    }

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

    //FUNCIONES INSERTAR FILA SALDIA
    function insertar_fila_salida() {
        
        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();;//eliminar espacios

        //validar campos no vacios
        var campo = ['serie_tanque','cantidad','unidad_medida','precio_unitario','tapa_tanque','iva_particular'];
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
                $.get('/tanque/validar_talon/' + numserie, function(rsta) {
                    if(rsta){
                        $("#serie_tanqueError").text('Cilindro se encuentra en nota talon');
                        return false;
                    }
                    if(msg.estatus == 'LLENO-ALMACEN' || msg.estatus == 'TANQUE-RESERVA'){
                        if(msg.estatus == 'TANQUE-RESERVA'){
                            mensaje('info','Exito','Despues de guardar la nota este cilindro se eliminara de PENDIENTES RESERVA',null,null);
                        }
                        var precio_importe= $('#precio_unitario').val();
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
                });
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

        var total=parseFloat($("#precio_envio_nota").val()) + importe;
        $('#label-total').replaceWith( 
            "<label id='label-total'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );
        $('#input-total').val(total);
        $("#monto_pago").val(total);
    }


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
        actualizar_subtotal();
        
    }

    function removeenvio(){
        $('#input-group-envio').remove();
        $('#row-envio').append(
            '<button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>'
        )
        $('#precio_envio_nota').val(0);
        actualizar_subtotal();
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