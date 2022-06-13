$(document).ready(function () {
    $(document).on("click","#btn-insert-fila-entrada", validar_fila_entrada);
    $(document).on("click","#btn-insert-fila-salida", insertar_fila_salida);
    $(document).on("click","#btnEliminarFila", eliminarFila);

    //registro tanque
    $(document).on("click","#btn-tanque_no_existe", function () {
        $("#num_serie").val($(this).data('id'));
        $("#modal-registrar-tanque").modal('show');
    });
    $(document).on("click","#btn-registrar-tanque", validar_tanque);

    //Nota General
    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);
    $(document).on("click","#guardar-nota", guardar_nota);

    //Añadir envio a nota
    $(document).on("click","#btn-addEnvio", addenvio);
    $(document).on("click","#btn-remove-envio", removeenvio);
    
    
    $(document).on("click","#btn-insertar_fila_entrada", function(){
        $.ajax({
            method: "get",
            url: "/tanque/show/"+$(this).data('id'),
        }).done(function(msg){
            insertar_fila_entrada(msg);
        });
    });

    


    //para lector de Cod barras
    $('#serie_tanque_entrada').keypress(function (event) {
        if (event.charCode == 13 ){
            event.preventDefault();
            validar_fila_entrada();
        } 
    });

    $('#serie_tanque').keypress(function (event) {
        if (event.charCode == 13 ){
            event.preventDefault();
            insertar_fila_salida();
        } 
    });

    //FUNCIONES INSERTAR FILA ENTRADA
    function validar_fila_entrada() {
        //limpiar span input
        $('#serie_tanque_entradaError').empty();
        $('#serie_tanque_entrada').removeClass('is-invalid');
        //Eliminar espacios
        var numserie= $('#serie_tanque_entrada').val().replace(/ /g,'').toUpperCase();
        //validar campos vacios
        if(numserie == ''){
            $('#serie_tanque_entrada').addClass('is-invalid');
            $('#serie_tanque_entradaError').text('Necesario');
            $("#serie_tanque_entrada").val('');
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
            $("#serie_tanque_entrada").val('');
            return false;
        }
    
        //validar si el tanque existe.
        $.ajax({
            method: "get",
            url: "/tanque/show_numserie/"+numserie,
        }).done(function(msg){

            if(msg == ""){// entra si no existe tanque
                $("#serie_tanque_entradaError").text('Cilindro con serie: '+numserie+' no existe -> ');
                $("#serie_tanque_entradaError").append('<button type="button" class="btn btn-link" data-id="'+numserie+'" id="btn-tanque_no_existe"> Registrar </button>');
                $("#serie_tanque_entrada").val('');

            }else{
                if(msg.estatus == "VENTA-EXPORADICA"){
                    insertar_fila_entrada(msg);
                }else{ 
                    //Tanque registrado en el sistema con estus diferente a VENTA-EXPORADICA
                    $("#serie_tanque_entradaError").append('<p>Este tanque esta registrado en el sistema, pero no ha salido en alguna venta exporadica. Estatus:  <strong> '+msg.estatus+'</strong> <br>'+
                        '<a class="btn btn-link" target="_blank" href="/tanque/history/'+msg.id+'">ver historial <strong>'+msg.num_serie+'</strong></a>'+
                        '<a class="btn btn-link" target="_blank" href="/tanque/reportados/create">Levantar reporte <strong>'+msg.num_serie+'</strong></a>'+
                        '<button type="button" class="btn btn-link" data-id="'+msg.id+'"  id="btn-insertar_fila_entrada"> Continuar de todos modos </button>'+'</p>');
                    $('#serie_tanque_entrada').val('');
                    

                }   
            }

        })
        return false;
    }

    function insertar_fila_entrada(msg){
        $("#serie_tanque_entradaError").empty();
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
                $('#ph_anio').val()+'-',// 6
                $('#ph_mes').val(),// 7
                $("#tipo_gas").val()+" "+$("#tipo_gas option:selected").text(),// 8
                fabri//9
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
                '',// 7
                msg.gas_nombre,// 8
                msg.fabricante//9
            ];
        }

        var capacidad=valorcampo[2]+' '+ valorcampo[1];
        var descrp= capacidad+", "+valorcampo[3]+", "+valorcampo[9]+", "+valorcampo[4]+", "+valorcampo[5]+", "+valorcampo[8];
        var pruebah= valorcampo[6]+valorcampo[7];
        // var tapaTanque=$('#tapa_tanque_entrada').val();

        $.get('/tanque/validar_ph/' + pruebah, function(respuesta) {
            
            var tdph;
            if(respuesta.alert){
                tdph="<td class='table-danger'>"+pruebah +"</td>"
            }else{
                tdph="<td>"+pruebah +"</td>"
            }
            $('#tbody-tanques-entrada').append(
                "<tr class='classfilasdevolucion'>"+
                "<td>"+valorcampo[0] +"</td>"+ "<input type='hidden' name='inputNumSerie_entrada[]' id='idInputNumSerie_entrada' value='"+valorcampo[0] +"'></input>"+
                "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion_entrada[]' value='"+descrp +"'></input>"+
                tdph+ "<input type='hidden' name='inputPh_entrada[]' value='"+pruebah +"'></input>"+
                // "<td>"+tapaTanque+"</td>"+ "<input type='hidden' name='inputTapa_entrada[]' value='"+tapaTanque +"'></input>"+
                "<td class='width-column p-0 m-0'><select name='inputTapa_entrada[]' id='inputTapa_entrada' class='form-control form-control-sm p-0 m-0'><option value=''>Selecciona</option><option value='SI'>SI</option><option value='NO'>NO</option></select></td>"+
                "<input type='hidden' name='inputRegistro[]' value='"+inputRegistro+"'></input>"+
                "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>"
            );
        });
        

        // mensaje("success","Exito", "Agregado Correctamente" , 1500, "#modal-registrar-tanque");
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
        $("#serie_tanque_entradaError").empty();
        var campo= [
            'num_serie',
            'unidadmedida',
            'capacidadnum',
            'material',
            'tipo_tanque',
            'estatus',
            'ph_anio',
            'ph_mes',
            'tipo_gas',
            'fabricanteoficial'];
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

        $("#phError").empty();
        $("#ph_anio").removeClass('is-invalid');
        if($('#ph_anio').val()<1950){
            $("#phError").text('Campo Incorrecto');
            $("#ph_anio").addClass('is-invalid');
            return false;
        }

        $("#modal-registrar-tanque").modal("hide");
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
        
        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();//eliminar espacios

        //validar campos no vacios
        if($("#serie_tanque").val()==""){
            $("#serie_tanqueError").text('Necesario campo numero de serie');
            $("#serie_tanque").val("");
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
            $("#serie_tanque").val("");
            return false;
        }


        $.get('/tanque/show_numserie/' + numserie, function(msg) { 
            if(msg != ''){
                $.get('/tanque/validar_talon/' + numserie, function(rsta) {
                    if(rsta){
                        $("#serie_tanqueError").text('Cilindro se encuentra en nota talon');
                        $("#serie_tanque").val("");
                        return false;
                    }
                    if(msg.estatus == 'LLENO-ALMACEN'){
                        var tapa_tanque = "<option value=''>Selecciona</option><option value='SI'>SI</option><option value='NO'>NO</option>";
                        if($('#tapa_tanque').val()=='SI'){tapa_tanque = "<option value=''>Selecciona</option><option selected value='SI'>SI</option><option value='NO'>NO</option>";}
                        if($('#tapa_tanque').val()=='NO'){tapa_tanque = "<option value=''>Selecciona</option><option value='SI'>SI</option><option selected value='NO'>NO</option>";}
                        var unidad_medida = "<option value=''>Selecciona</option><option value='CARGA'>CARGA</option><option value='kg'>kg</option><option value='M3'>M3</option>";
                        if($('#unidad_medida').val()=='CARGA'){unidad_medida = "<option value=''>Selecciona</option><option selected value='CARGA'>CARGA</option><option value='kg'>kg</option><option value='M3'>M3</option>";}
                        if($('#unidad_medida').val()=='kg'){unidad_medida = "<option value=''>Selecciona</option><option value='CARGA'>CARGA</option><option selected value='kg'>kg</option><option value='M3'>M3</option>";}
                        if($('#unidad_medida').val()=='M3'){unidad_medida = "<option value=''>Selecciona</option><option value='CARGA'>CARGA</option><option value='kg'>kg</option><option selected value='M3'>M3</option>";}
                        var cantidad=$('#cantidad').val();
                        var importe=$('#importe').val();
                        var ivaPart=0;

                        ivaPart=0;
                        if( msg.tipo_tanque == 'Industrial'){
                            ivaPart=importe * 0.16;
                        }else{
                            ivaPart=0;
                        }


                        $('#tablelistaTanques').append(
                            "<tr class='classfilatanque'>"+
                                "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie_salida' value='"+msg.num_serie +"'></input>"+
                                "<td class='width-column p-0 m-0'><select name='inputTapa[]' id='inputTapa' class='form-control form-control-sm p-0 m-0'>"+tapa_tanque +"</select></td>"+
                                "<td class='p-0 m-0'>"+msg.gas_nombre +"</td>"+ "<input type='hidden' name='input_tipo_gas[]' value='"+msg.tipo_gas +"'></input>"+
                                "<td class='width-column p-0 m-0'><input type='number' name='input_cantidad[]' value='"+cantidad+"' class='form-control form-control-sm p-0 m-0'></input></td>"+
                                "<td class='width-column p-0 m-0'><select name='input_unidad_medida[]' id='input_unidad_medida' class='form-control form-control-sm p-0 m-0'>"+unidad_medida+"</select></td>"+
                                "<td class='width-column p-0 m-0'><input type='number' name='input_importe[]' id='input_importe' value='"+importe+"' class='import_unit form-control form-control-sm p-0 m-0'></input></td>"+
                                "<td class='width-column p-0 m-0'><input type='number' name='input_iva_particular[]' value='"+ivaPart+"' class='result_iva form-control form-control-sm p-0 m-0' readonly></input></td>"+    

                                "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
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
        $("#id_show").removeClass('is-invalid');
        if($("#id_show").val() == ''){
            $("#id_show").addClass('is-invalid');
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

        if($('#idInputNumSerie_salida').length != $('#idInputNumSerie_entrada').length) {
            mensaje('error','Error', 'La cantidad de tanques de entrada deben ser igual a los de salida', null, null);
            return false;
        }
        if(validar_inputs_vacios()){
            mensaje('error','Error','Faltan campos por rellenar', 1500, null);
            return false;
        };

        $('#row-envio').empty();
        $('#row-envio').append(
            '<button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>'
        )
        $('#precio_envio_nota').val(0);
        
        actualizar_operaciones();

        $('#static-modal-pago').modal("show");

    }

    function validar_inputs_vacios(){
        var banderamensaje=false;

        $("select[name='inputTapa_entrada[]']").each(function(indice, elemento) {
            if($(elemento).val()==""){
                $(elemento).addClass("is-invalid");
                banderamensaje=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });

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
        $("#ingreso-efectivoError").empty();

        $("#ingreso-efectivoError").empty();
        if($("#metodo_pago").val()=='Efectivo'){
            if(parseFloat($("#ingreso-efectivo").val()) == 0 || $("#ingreso-efectivo").val() == ''){
                $("#ingreso-efectivoError").text('Campo ingreso de efectivo obligatorio');
                return false;
            }
            if(parseFloat($("#ingreso-efectivo").val()) < parseFloat($("#input-total").val())){
                $("#ingreso-efectivoError").text('INGRESO EFECTIVO no puede ser menor a MONTO A PAGAR');
                return false;
            }
        }

        if($("#metodo_pago").val()=='' && parseFloat($("#input-total").val()) > 0){
            $("#metodo_pago").addClass('is-invalid');
            $("#metodo_pagoError").text('Selecciona un metodo de pago');
            return false;
        }else{
            $("#metodo_pago").removeClass('is-invalid');
            $("#metodo_pagoError").empty();
        }

        // envio al controlador
        $("#guardar-nota").prop("disabled", true);
        var dataForm= $("#idFormNewVenta").serialize()+'&metodo_pago='+$('#metodo_pago').val()+'&input-subtotal='+$('#input-subtotal').val()+'&input-total='+$('#input-total').val();
        $.ajax({
            method: "post",
            url: "/nota/exporadica/save",
            data: dataForm, 
        }).done(function(msg){
            if(msg.alert =='success'){
                window.open("/pdf/nota/exporadica/"+ msg.notaId, '_blank');
                location.reload();
            }
            if(msg.alert =='error'){
                mensaje('error', 'Error', msg.mensaje, null, null);
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
                location.reload();
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

    $('.solo-texto').keypress(function (event) {
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