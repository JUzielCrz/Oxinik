$(document).ready(function () {
    $(document).on("click","#btn-insert-fila-entrada", validar_fila_entrada);
    $(document).on("click","#btn-insert-fila-salida", insertar_fila_salida);
    $(document).on("click","#btnEliminarFila", eliminarFila);

    //registro tanque
    $(document).on("click","#btn-registrar-tanque", validar_tanque);
    

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



    //FUNCIONES INSERTAR FILA ENTRADA
    function validar_fila_entrada() {
        //limpiar span input
        $('#serie_tanque_entradaError').empty();
        $('#tapa_tanque_entradaError').empty();
        //Eliminar espacios
        var numserie= $('#serie_tanque_entrada').val().replace(/ /g,'');
        //validar campos vacios
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
    
        //Bucar si ya esta agregado tanque a la lista
        var boolRepetido=false;
        $(".classfilatanque_entrada").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == numserie){
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
            url: "/tanque/show_numserie/"+numserie+'',
        }).done(function(msg){

            if(msg == ""){// entra si no existe tanque
                $('#num_serie').val($("#serie_tanque_entrada").val().replace(/ /g,''));
                $('#num_serie').prop("disabled", true);
                $("#modal-registrar-tanque").modal('show');
            }else{
                if(msg.estatus == "VENTA-EXPORADICA"){
                    insertar_fila_entrada(msg);
                    mensaje("info","Exito", "Este cilindro ya estaba registrado" , 2000, "#modal-registrar-tanque");
                }else{ 
                    //Tanque registrado en el sistema con estus diferente a VENTA-EXPORADICA
                    Swal.fire({
                        icon: 'warning',
                        html: 'Este tanque esta registrado en el sistema, pero no ha salido en alguna venta exporadica <br> Estatus tanque:  <strong> '+msg.estatus+'</strong> <br>',
                        showCancelButton: true,
                        confirmButtonText: 'Continuar de todos modos',
                        footer: '<a class="btn btn-link" target="_blank" href="/tanque/history/'+msg.id+'">ver historial <strong>'+msg.num_serie+'</strong></a>'+
                        '<a class="btn btn-link" target="_blank" href="/tanque/reporte/'+msg.id+'">Levantar reporte <strong>'+msg.num_serie+'</strong></a>',
                        
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            insertar_fila_entrada(msg);
                        } 
                    })
                }   
            }

        })
        return false;
    }

    function insertar_fila_entrada(msg){
        console.log(msg);
        var valorcampo=[];
        var inputRegistro=false;

        if(msg == 'REGISTRO-TANQUE'){
            var fabri;
            if($("#fabricanteoficial").val() == "Otros"){
                fabri = $("#otrofabricante").val();
            }else{
                fabri = $("#fabricanteoficial").val();
            }
            inputRegistro=true;
            valorcampo= [
                $('#num_serie').val(),// 0
                $('#unidadmedida').val(),// 1
                $('#capacidadnum').val(),// 2
                $('#material').val(),// 3
                $('#tipo_tanque').val(),// 4
                $('#estatus').val(),// 5
                $('#ph').val(),// 6
                $("#tipo_gas").val()+" "+$("#tipo_gas option:selected").text(),// 7
                fabri//8
            ];

        }else{
            
            valorcampo= [
                msg.num_serie,// 0
                msg.capacidad,// 1
                msg.capacidad,// 2
                msg.material,// 3
                msg.tipo_tanque,// 4
                msg.estatus,// 5
                msg.ph,// 6
                'gas id: '+msg.tipo_gas,// 7
                msg.fabricante//8
            ];
        }

        var capacidad=valorcampo[2]+' '+ valorcampo[1];
        var descrp= capacidad+", "+valorcampo[3]+", "+valorcampo[8]+", "+valorcampo[4]+", "+valorcampo[5]+", "+valorcampo[7];

        $('#tbody-tanques-entrada').append(
            "<tr class='classfilasdevolucion'>"+
            "<td>"+valorcampo[0] +"</td>"+ "<input type='hidden' name='inputNumSerie_entrada[]' id='idInputNumSerie_entrada' value='"+valorcampo[0] +"'></input>"+
            "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion_entrada[]' value='"+descrp +"'></input>"+
            "<td>"+valorcampo[6] +"</td>"+ "<input type='hidden' name='inputPh_entrada[]' value='"+valorcampo[6] +"'></input>"+
            "<td>"+$('#tapa_tanque_entrada').val() +"</td>"+ "<input type='hidden' name='inputTapa_entrada[]' value='"+$('#tapa_tanque_entrada').val() +"'></input>"+
            "<input type='hidden' name='inputRegistro[]' value="+inputRegistro+"></input>"+
            "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
            "</tr>"
        );

        mensaje("success","Exito", "Agregado Correctamente" , 1500, "#modal-registrar-tanque");
        limpiar_campos_tanque();
    }


    // para registro de tanque

    $("#fabricanteoficial").change( function() {
        if ($(this).val() == "Otros") {
            $("#otrofabricante").prop("disabled", false);
        } else {
            $("#otrofabricante").prop("disabled", true);
            $("#otrofabricante").val('');
        }
    });

    $("#unidadmedida").change( function() {
        if ($(this).val() == "Carga") {
            $("#capacidadnum").val(1);
            $("#capacidadnum").prop("disabled", true);
        } else {
            
            $("#capacidadnum").prop("disabled", false);
        }
    });

    function validar_tanque() {
        var campo= [
            'num_serie',
            'unidadmedida',
            'capacidadnum',
            'material',
            'tipo_tanque',
            'estatus',
            'ph',
            'tipo_gas'];
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


        var fabri;
        if($("#fabricanteoficial").val() == "Otros"){
            fabri = $("#otrofabricante").val();
        }else{
            fabri = $("#fabricanteoficial").val();
        }

        if(fabri==""){
            $("#fabricanteError").text('Necesario');
            $("#otrofabricante").addClass('is-invalid');
            $("#fabricanteoficial").addClass('is-invalid');
            return false;
        }else{
            $("#fabricanteError").empty();
            $("#otrofabricante").removeClass('is-invalid');
            $("#fabricanteoficial").removeClass('is-invalid');
        }

        var cap=$('#capacidadnum').val()+' '+ $('#unidadmedida').val();
        if($('#capacidadnum').val()==''){
            $("#capacidadError").text('El campo Capacidad es Obligatorio');
            return false;
        }

        var numserie= $('#num_serie').val().replace(/ /g,'');

        insertar_fila_entrada('REGISTRO-TANQUE');
    }

    function limpiar_campos_tanque(){
        $("#num_serie").val("");
        $("#ph").val("");
        $("#capacidadnum").val("");
        $("#unidadmedida").val("");
        $("#material").val("");
        $("#otrofabricante").val("");
        $("#fabricanteoficial").val("");
        $("#tipo_gas").val("");

        $('#serie_tanque_entrada').val("");
        $("#tapa_tanque_entrada").val('');
    }



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
                "<button type='button' class='btn btn-sm btn-gray' id='btnFacturacion'>"+
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
                '<button id="btn-modal-envio" type="button" class="btn btn-sm btn-gray" data-toggle="modal" data-target="#modal-envio"> <span class="fas fa-plus"></span> Agregar Envio</button>'+
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
        var campo= ['nombre_cliente','telefono','email', 'direccion'];
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
            });
            return false;
        }

        //SI no hay tanques agregados en entrada manda error
        if($('#idInputNumSerie_entrada').length === 0) {
            mensaje('error','Error', 'No hay registro de tanques de entrada', null, null);
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
            url: "/nota/exporadica/save",
            data: $("#idFormNewVenta").serialize(), 
        }).done(function(msg){
            if(msg.mensaje =='Registro-Correcto'){
                window.open("/pdf/nota/exporadica/"+ msg.notaId, '_blank');
                location.reload();
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
                location.reload();
            }
        })
    }

});