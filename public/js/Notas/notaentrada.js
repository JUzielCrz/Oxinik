$(document).ready(function () {
    
    //Link de botones
    $(document).on("click",".btn-info-tanque", info_tanque);

    $(document).on("click","#btnInsertFila", insertfila);
    $(document).on("click","#btnEliminarFila", eliminarFila);

    $(document).on("click","#btn-registrar-tanque", registrar_tanque);

    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#guardar-nota", guardar_nota);


    //BUSCAR CONTRATO
        $('#search-contrato-id').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                    method: "POST",
                    url:"notasalida/searchcontrato",
                    data:{'query':query,'_token': $('input[name=_token]').val(),},
                    success:function(data){

                        $('#listar-contratos').fadeIn();  
                        $('#listar-contratos').html(data);

                    }
                });
            }
        });

        $(document).on('click', 'li', function(){  
            $('#listar-contratos').fadeOut();
            const contrato = $(this).text().split(', ');

            $.ajax({
                method: "post",
                url: "/datacontrato/"+contrato[0],
                data: {'_token': $('input[name=_token]').val(),},
            })
            .done(function(msg) {
                $('#contrato_id').val(msg.contrato.contrato_id)
                $('#num_contrato').val(msg.contrato.num_contrato)
                $('#tipo_contrato').val(msg.contrato.tipo_contrato)
                $("#nombre_cliente").val('#'+msg.contrato.cliente_id+' - '+contrato[1]);

                show_nota_lista_tanques(msg.contrato.contrato_id, 'tbody-tanques-nota');
                show_table_asignaciones(msg.contrato.contrato_id, 'tableasignaciones', 'content-asignaciones');
            })
            $(".InputsFilaEntrada").prop("disabled", false);
            $('#search-contrato-id').val('');
            
        }); 
    //FIN BUSCAR CONTRATO


    ///FUNCIONES PARA INSERTAR TABLAS
    function show_nota_lista_tanques(contrato_id, tbody) {
            
        $.get('/notaentrada/nota_lista_tanques/' + contrato_id, function(data) {
            var columnas='';
            
            $.each(data, function (key, value) {
                columnas+='<tr class="class-tanques-nota"><td><button type="button" class="btn btn-link btn-info-tanque" data-id="'+value.tanque_id+'">'+
                value.num_serie+'</button></td><td>'+
                value.tapa_tanque+'</td><td>'+
                value.folio_nota+'</td><td>'+
                value.fecha+'</td></tr>';
            });
            $('.class-tanques-nota').remove();
            $('#'+tbody).append(columnas);
        });
    }

    function show_table_asignaciones(contrato_id, idTabla, idDiv) {
            
        $.get('/showasignaciones/' + contrato_id, function(data) {

            var columnas='';
            $.each(data.asigTanques, function (key, value) {
                columnas+='<tr><td>'+value.cantidad+'</td><td>'+value.nombre+'</td></tr>';
            });

            $('#'+idTabla).remove();
            $('#'+idDiv).append(
                '<div id="'+idTabla+'">'+
                    '<table class="table table-sm">'+
                        '<tbody>'+
                            columnas+
                        '</tbody>'+
                    '</table>'+
                '</div>'
            );
        })
    }
    // FIN FUNCIONES PARA INSERTAR TABLAS

    ///INFORMACIUON DE TRANQUE
    function info_tanque() {
        $.get('/showtanque/' + $(this).data('id') + '', function(data) {
            $.each(data.tanques, function (key, value) {
                var variable = "#" + key + "info";
                $(variable).val(value);
            });
            $("#modalmostrar").modal("show");
        })
    }



    //FUNCIONES INSERTAR FILA 
    function insertfila(evnt) {
        evnt.preventDefault();
        var numserie= $('#serie_tanque').val().replace(/ /g,'');

        if(numserie == ''){
            $('#serie_tanque').addClass('is-invalid');
            $('#serie_tanqueError').text('Necesario');
            return false;
        }
        
        if($('#tapa_tanque').val() == ''){
            $('#tapa_tanque').addClass('is-invalid');
            $('#tapa_tanqueError').text('Necesario');
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

        //validar si el tanque existe.
        $.ajax({
            method: "get",
            url: "notaentrada/validar_existencia/"+numserie+'',
        }).done(function(msg){
            
            if(msg=='alert-danger'){
                $('#num_seriefila').val($('#serie_tanque').val())
                $("#modal-registrar-tanque").modal('show');
            }else{
                var descrp=msg.capacidad+", "+msg.material+", "+msg.fabricante+", "+msg.tipo_gas;
                $('#tablelistaTanques').append(
                    "<tr class='classfilatanque'>"+
                    "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                    "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion[]' value='"+descrp +"'></input>"+
                    "<td>"+msg.ph +"</td>"+ "<input type='hidden' name='inputPh[]' value='"+msg.ph +"'></input>"+
                    "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                    "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                    "</tr>");
                    $("#serie_tanque").val('');
                    $("#tapa_tanque").val('');
            }
        })

        return false;
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
        actualizar_subtotal();
        actualizar_total();
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

    //FIN FUNCIONES INSERTAR FILA 


    //Funcion registrar nota
    function pagar_nota(){

        if($('#num_contrato').val() == '') {
            mostrar_mensaje("#msg-contrato",'Error, falta información de contrato', "alert-danger",null);
            return false;
        }

        //SI no hay tanques agregados manda error
        if($('input[id=idInputNumSerie]').length === 0) {
            mostrar_mensaje("#msg-tanques",'Error, No hay tanques en la lista', "alert-danger",null);
            return false;
        }


        if($('#recargos').val() < 0) {
            $("#metodo_pagoError").text('Monto debe ser mayor a 0');
            return false;
        }
        $("#ingreso-efectivoError").empty();

        if($("#metodo_pago").val()=='Efectivo'){
            if($("#ingreso-efectivo").val() == 0){
                $("#ingreso-efectivoError").text('Campo ingreso de efectivo obligatorio');
                return false;
            }

            if(parseFloat($("#ingreso-efectivo").val()) < parseFloat($("#recargos").val())){
                $("#ingreso-efectivoError").text('INGRESI EFECTIVO no puede ser menor a RECARGOS');
                return false;
            }
        }

        if($("#metodo_pago").val()==''){
            $("#metodo_pago").addClass('is-invalid');
            $("#metodo_pagoError").text('Selecciona un metodo de pago');
            return false;
        }else{
            $("#metodo_pago").removeClass('is-invalid');
        }


        $('#static-modal-pago').modal("show");

        var cambio = $("#ingreso-efectivo").val()-$("#recargos").val();
    
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
            url: "/notaentrada/save",
            data: $("#form-entrada-nota").serialize(), 
        }).done(function(msg){
            console.log('paso');
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

    //FIN Funcion registrar nota

    //FUNCIONES GENERALES
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

    //FIN FUNCIONES GENERALES
});




