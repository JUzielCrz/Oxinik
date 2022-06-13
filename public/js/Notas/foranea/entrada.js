$(document).ready(function () {
    $(document).on("click","#btn-insert-fila-salida", insertar_fila_salida);
    $(document).on("click","#btn-eliminar-salida", eliminar_cilindro_salida);


    $(document).on("click","#btn-insert-fila-entrada", validar_fila_entrada);
    $(document).on("click","#btn-eliminar-entrada", eliminar_cilindro_entrada);

    $(document).on("click","#btnEliminarFila", eliminarFila);
    
    //registro tanque
    $(document).on("click","#btn-tanque_no_existe", function () {
        $("#num_serie").val($(this).data('id'));
        $("#modal-registrar-tanque").modal('show');
    });
    $(document).on("click","#btn-registrar-tanque", validar_tanque);
    

    //Nota General
    $(document).on("click","#btnCancelar", cancelarnota);
    $(document).on("click","#guardar-nota", guardar_nota);

    $(document).on("click","#btn-insertar_fila_entrada", function(){
        $.ajax({
            method: "get",
            url: "/tanque/show/"+$(this).data('id'),
        }).done(function(msg){
            insertar_fila_entrada(msg);
        });
    });


    $('#serie_tanque_entrada').keypress(function (event) {
        console.log('passs');
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


    actualizar_disables();

    //FUNCIONES INSERTAR FILA SALDIA
    function insertar_fila_salida(){
        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();;//eliminar espacios

        //validar campos no vacios
        if($("#serie_tanque").val()==""){
            $("#serie_tanqueError").text('Necesario campo numero de serie');
            $("#serie_tanque").val("");
            return false;
        }


        //validar campos repetidos
        var boolRepetido=false;
        var deleteespacio=$.trim(numserie);
        $(".tr-cilindros-salida").each(function(index, value){
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

        var observaciones='';
        $.get('/tanque/show_numserie/' + numserie, function(msg) { 
            if(msg != ''){
                $.get('/tanque/validar_talon/' + numserie, function(rsta) {
                    if(rsta){
                        $("#serie_tanqueError").text('Cilindro se encuentra en nota talon');
                        $("#serie_tanque").val("");
                        return false;
                    }
                    if(msg.estatus == 'LLENO-ALMACEN' || msg.estatus == 'TANQUE-RESERVA'){
                        if(msg.estatus == 'TANQUE-RESERVA'){
                            observaciones='Despues de guardar la nota, este cilindro se eliminara de PENDIENTES RESERVA';
                        }
                        
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

                        $('#tbody-cilindros-salida').append(
                            "<tr class='tr-cilindros-salida text-center' style='font-size: 13px'>"+
                            "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie_salida' value='"+msg.num_serie +"'></input>"+
                            "<td class='width-column p-0 m-0'><select name='inputTapa[]' id='inputTapa' class='form-control form-control-sm p-0 m-0'>"+tapa_tanque +"</select></td>"+
                            "<td class='p-0 m-0'>"+msg.gas_nombre +"</td>"+ "<input type='hidden' name='input_tipo_gas[]' value='"+msg.tipo_gas +"'></input>"+
                            "<td class='width-column p-0 m-0'><input type='number' name='input_cantidad[]' value='"+cantidad+"' class='form-control form-control-sm p-0 m-0'></input></td>"+
                            "<td class='width-column p-0 m-0'><select name='input_unidad_medida[]' id='input_unidad_medida' class='form-control form-control-sm p-0 m-0'>"+unidad_medida+"</select></td>"+
                            "<td class='width-column p-0 m-0'><input type='number' name='input_importe[]' id='input_importe' value='"+importe+"' class='import_unit form-control form-control-sm p-0 m-0'></input></td>"+
                            "<td class='width-column p-0 m-0'><input type='number' name='input_iva_particular[]' value='"+ivaPart+"' class='result_iva form-control form-control-sm p-0 m-0' readonly></input></td>"+    
                            "<td class='width-column p-0 m-0'>"+observaciones+"</td>"+
                            "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                            "</tr>");
                            
                            $(".import_unit").keyup( function() {
                                var ivaPart=$(this).val() * 0.16;
                                if( msg.tipo_tanque == 'Industrial'){
                                    $(this).parents("tr").find(".result_iva").val(ivaPart);

                                }else{
                                    $(this).parents("tr").find(".result_iva").val(0);
                                }
                                actualizar_operaciones()
                            });
                            limpiar_inputs_fila();
                            actualizar_operaciones();
                    }else{
                        $("#serie_tanqueError").text('Error Tanque - estatus: '+ msg.estatus);
                        $("#serie_tanque").val("");
                    }
                });
            }else{
                $("#serie_tanqueError").text('Número de serie no existe en almacén');
                $("#serie_tanque").val("");
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
    //FUNCIONES INSERTAR FILA ENTRADA
    function validar_fila_entrada(event) {

        //limpiar span input
        $('#serie_tanque_entradaError').empty();
        //Eliminar espacios
        var numserie= $('#serie_tanque_entrada').val().replace(/ /g,'').toUpperCase();
        //validar campos vacios
        if(numserie == ''){
            $('#serie_tanque_entrada').addClass('is-invalid');
            $('#serie_tanque_entradaError').text('Necesario');
            return false;
        }
    
        //Bucar si ya esta agregado tanque a la lista
        var boolRepetido=false;
        $(".tr-cilindros-entrada").each(function(index, value){
            if($(this).find("td")[0].innerHTML == numserie){
                boolRepetido=true;
            }
        })
        if(boolRepetido){
            $("#serie_tanque_entradaError").text('Número de serie ya agregado a esta nota');
                return false;
        }
    
        if($(".tr-cilindros-salida").length == $(".tr-cilindros-entrada").length){
            $("#serie_tanque_entradaError").text('No puedes revasar cantidad de cilindros');
            return false;
        }
        //validar si el tanque existe.
        $.ajax({
            method: "get",
            url: "/tanque/show_numserie/"+numserie+'',
        }).done(function(msg){
            var numserie= $('#serie_tanque_entrada').val().replace(/ /g,'').toUpperCase();
            if(msg == ""){// entra si no existe tanque
                
                $("#serie_tanque_entradaError").text('Cilindro con serie: '+numserie+' no existe -> ');
                $("#serie_tanque_entradaError").append('<button type="button" class="btn btn-link" data-id="'+numserie+'" id="btn-tanque_no_existe"> Registrar </button>');
                $("#serie_tanque_entrada").val('');
                // $('#num_serie').val(numserie);
                // $('#num_serie').prop("disabled", true);
                // $("#modal-registrar-tanque").modal('show');
            }else{
                if(msg.estatus == "VENTA-FORANEA"){
                    insertar_fila_entrada(msg);
                }else{ 
                    //Tanque registrado en el sistema con estus diferente a VENTA-FORANEA
                    $("#serie_tanque_entradaError").append('<p>Este tanque esta registrado en el sistema, pero no ha salido en alguna venta foranea. Estatus:  <strong> '+msg.estatus+'</strong> <br>'+
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
                $('#ph_anio').val(),// 6
                $('#ph_mes').val(),// 7
                $("#tipo_gas").val()+" "+$("#tipo_gas option:selected").text(),// 8
                fabri//9
            ];
            var pruebah= valorcampo[6]+'-'+valorcampo[7];
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
                'gas id: '+msg.tipo_gas,// 8
                msg.fabricante//9
            ];
            var pruebah= valorcampo[6];
        }

        var capacidad=valorcampo[2]+' '+ valorcampo[1];
        var descrp= capacidad+", "+valorcampo[3]+", "+valorcampo[9]+", "+valorcampo[4]+", "+valorcampo[5]+", "+valorcampo[8];
        

        $.get('/tanque/validar_ph/' + pruebah, function(respuesta) {
            tanqueSer=valorcampo[0];
            var numserie= tanqueSer.replace(/ /g,'').toUpperCase();
            var tdph;
            if(respuesta.alert){
                tdph="<td class='table-danger'>"+pruebah +"</td>"
            }else{
                tdph="<td>"+pruebah +"</td>"
            }
            $('#tbody-tanques-entrada').append(
                "<tr class='tr-cilindros-entrada text-center'>"+
                "<td>"+numserie +"</td>"+ "<input type='hidden' name='inputNumSerie_entrada[]' id='idInputNumSerie_entrada' value='"+numserie +"'></input>"+
                "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion_entrada[]' value='"+descrp +"'></input>"+
                tdph+ "<input type='hidden' name='inputPh_entrada[]' value='"+pruebah +"'></input>"+
                "<td class='width-column p-0 m-0'><select name='inputTapa_entrada[]' id='inputTapa_entrada' class='form-control form-control-sm p-0 m-0'><option value=''>Selecciona</option><option value='SI'>SI</option><option value='NO'>NO</option></select></td>"+
                "<input type='hidden' name='inputRegistro[]' value="+inputRegistro+"></input>"+
                "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>"
            );
        });
        
        limpiar_campos_tanque();
    }

    //disables
    function actualizar_disables(){
        if($(".tr-cilindros-salida").length <= $(".tr-cilindros-entrada").length && $(".tr-cilindros-salida").length>0){
            $('.disabled_entrada').prop('disabled', true);
        }else{
            $('.disabled_entrada').prop('disabled', false);
        }   
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

    //aritmeticas
    function actualizar_operaciones(){
        var importe = 0;
        var subtotal = 0;
        var iva_general = 0;
        var total = 0;

        //Operaciones
        $('.import_unit').each(function(){
            if($(this).val()==""){
                importe+=0;
            }else{
                importe += parseFloat($(this).val());
            }
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



    //Funciones finales de Nota General

    function guardar_nota(){
        if($(".tr-cilindros-salida").length <= 0){
            mensaje("error","Error", "No hay tanques de salida" , null, null);
            return false;
        }
        if($(".tr-cilindros-entrada").length > $(".tr-cilindros-salida").length){
            mensaje("error","Error", "Número de tanques de entrada no puede ser mayor a los de salida" , null, null);
            return false;
        }
        var boolBandera=false;
        $("select[name='inputTapa_entrada[]']").each(function(indice, elemento) {
            if($(elemento).val()==""){
                $(elemento).addClass("is-invalid");
                boolBandera=true;
            }else{
                $(elemento).removeClass("is-invalid");
            }
        });
        if(boolBandera){
            mensaje('error','Error','Faltan campos por rellenar', 1500, null);
            return false;
        }
        $.ajax({
            method: "post",
            url: "/nota/foranea/entrada/save/"+$("#idnota").val(),
            data: $("#idFormNewVenta").serialize(), 
        }).done(function(msg){
            if(msg.alert =='success'){  
                window.location = '/nota/foranea/index' 
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
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Continuar!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location= '/nota/foranea/index';
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

    function eliminar_cilindro_salida(){
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Se eliminara cilindro de esta nota y su estatus cambiara a LLENO-ALMACEN",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Si Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                var numserie=$(this).closest('tr').find("td")[0].innerHTML;
                var trfila=$(this).closest('tr');
                $.ajax({
                    method: "post",
                    url: "/nota/foranea/cambiar_estatus/"+numserie,
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'nota_id': $('#idnota').val(),
                    },
                }).done(function (msg) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Exito',
                        text: 'Eliminado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    trfila.remove();
                    actualizar_operaciones();
                    actualizar_disables()
                });
            }
        })
    }

    function eliminar_cilindro_entrada(){
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Se eliminara cilindro de esta nota y su estatus cambiara a VENTA-FORANEA",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Si Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                var numserie=$(this).closest('tr').find("td")[0].innerHTML;
                var trfila=$(this).closest('tr');
                $.ajax({
                    method: "post",
                    url: "/nota/foranea/cambiar_estatus_entrada/"+numserie,
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'nota_id': $('#idnota').val(),
                    },
                }).done(function (msg) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Exito',
                        text: 'Eliminado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    trfila.remove();
                    actualizar_disables()
                });
            }
        })
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
        actualizar_disables();
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