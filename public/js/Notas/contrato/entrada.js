$(document).ready(function () {
    
    //Link de botones

    $(document).on("click","#btn-tanque_no_existe", tanque_no_existe);
    $(document).on("click","#btn-diferente_cliente", diferente_cliente);

    //$(document).on("click","#btn-registrar-tanque", registrar_tanque);

    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#guardar-nota", guardar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);

    $(document).on("click","#btnInsertFila", validar_fila);
    // $(document).on("click","#btn-continuar-RXtapa", recargo_xtapa);
    $(document).on("click","#btnEliminarFila", eliminarFila);

    $(document).on("click","#btn-insertar-nuevo-tanque", insertar_nuevo_tanque);
    $(document).on("click","#btn-insertar-tanque-clientediferente", insertar_tanque_clientediferente);
    

    //BUSCAR CONTRATO
        $('#search-contrato-id').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                    method: "POST",
                    url:"/nota/contrato/salida/search_contrato",
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
                url: "/nota/data_contrato/"+contrato[0],
                data: {'_token': $('input[name=_token]').val(),},
            })
            .done(function(msg) {
                $('#contrato_id').val(msg.contrato.contrato_id)
                $('#tipo_contrato').val(msg.contrato.tipo_contrato)
                $("#nombre_cliente").val('#'+msg.contrato.cliente_id+' - '+contrato[1]);
                $('#tablelistaTanques').empty();
                $('#serie_tanque').val('');
                $('#serie_tanqueError').empty();
                $('#tapa_tanque').val('');
                $('#tapa_tanqueError').empty();

                show_nota_lista_tanques(msg.contrato.contrato_id, 'tbody-tanques-nota');
                show_table_asignaciones(msg.contrato.contrato_id, 'tableasignaciones', 'content-asignaciones');
            })
            $(".InputsFilaEntrada").prop("disabled", false);
            $('#search-contrato-id').val('');
            
        }); 
    //FIN BUSCAR CONTRATO


    ///FUNCIONES PARA INSERTAR TABLAS
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

    function show_table_asignaciones(contrato_id, idTabla, idDiv) {
            
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
    // FIN FUNCIONES PARA INSERTAR TABLAS



    //FUNCIONES INSERTAR FILA 
    function validar_fila(evnt) {
        $('#serie_tanque').removeClass('is-invalid');
        $('#serie_tanqueError').empty();
        $('#span_no_existe').empty();
        

        var numserie= $('#serie_tanque').val().replace(/ /g,'').toUpperCase();

        if($(".class-tanques-nota").length == 0) {
            mensaje_error('Cliente no adeuda mas tanques');
            return false;
        }
        if(numserie == ''){
            $('#serie_tanqueError').text('Necesario');
            return false;
        }

        var boolRepetido=false;
        $(".classfilatanque").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            var valores2 = $(this).find("td")[4].innerHTML;
            if(valores == numserie || valores2 == numserie){
                boolRepetido=true;
            }
        })

        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a esta nota');
                return false;
        }
        

        //validar si el tanque existe
        $.get('/tanque/show_numserie/'+numserie, function(msg) {
            var observaciones ="-";
            if(msg==''){//si tanque no existe, muestra mensaje con opcion de registrar
                //tanque_no_existe();
                $("#serie_tanqueError").text('Cilindro con serie: '+numserie+' no existe -> ');
                $("#span_no_existe").append('<button type="button" class="btn btn-link" data-id="'+numserie+'" id="btn-tanque_no_existe"> Registrar </button>');
                $('#serie_tanque').val('');
                return false;
            }else{//tanque si existe
                $.get('/tanque/validar_ph/' + msg.ph, function(respuesta) {
                    if(respuesta.alert=='vencido'){
                        //detener 
                        $("#serie_tanqueError").text('PH: '+msg.ph+' -> Prueba hidrostática vencida');
                        $('#serie_tanque').val('');
                        return false;
                    }
                    if(respuesta.alert){
                        observaciones = 'PH: '+msg.ph+', '+respuesta.mensaje;
                        $('#serie_tanque').val('');
                    }
                    var bandera_pendiete=false; //validar si el tanque es de los que adeuda
                        var tapa_tanque_estatus="";
                        $(".class-tanques-nota").each(function(index, value){
                            var tanquePendiente = $(this).find("td")[1].innerHTML;
                            if(tanquePendiente == numserie){
                                bandera_pendiete=true;
                                tapa_tanque_estatus=$(this).find("td")[3].innerHTML;
                            }
                        })

                        if(bandera_pendiete){
                            // si es de los que adeuda, el tanque le pertenece al contrato del cliente.
                            if( msg.estatus == "ENTREGADO-CLIENTE"){
                                if($('#tapa_tanque').val() == 'NO' && tapa_tanque_estatus == 'SI'){ ///si no viene con tapa
                                    //tanque_sin_tapa(numserie, msg.id);
                                    observaciones = 'Tanque con serie: '+numserie+'; Fue entregado con tapa';
                                }
                                insertar_fila(msg.id, 0, observaciones);
                                $('#serie_tanque').val('');
                            }else{
                                //#serie si esta en su contrato pero su estatus es reportado o esta entregado a otro cliente;
                                $("#serie_tanqueError").append('<p>Este tanque se muestra con estatus: <strong> '+msg.estatus+'</strong> <br> Debes modificar estatus del tanque a <strong> "ENTREGADO-CLIENTE" </strong> si deseas agregarlo a esta nota'+
                                '<br>  <a class="btn btn-link" target="_blank" href="/tanque/history/'+msg.id+'">ver historial <strong>'+msg.num_serie+'</strong></a> </p>');
                                $('#serie_tanque').val('');
                            }
                            
                        }else{
                            
                            //#serie no encontrado en su contrato pero si existe;
                            $("#serie_tanqueError").append('<p>Este tanque esta registrado en el sistema, pero no es de los entregados a este cliente. Estatus:  <strong> '+msg.estatus+'</strong> <br>'+
                                '<a class="btn btn-link" target="_blank" href="/tanque/history/'+msg.id+'">ver historial <strong>'+msg.num_serie+'</strong></a>'+
                                '<a class="btn btn-link" target="_blank" href="/tanque/reportados/create">Levantar reporte <strong>'+msg.num_serie+'</strong></a>'+
                                '<button type="button" class="btn btn-link" data-id="'+msg.id+'" id="btn-diferente_cliente"> Continuar de todos modos </button>'+'</p>');
                                $('#serie_tanque').val('');
                        }
                });
                
            
            }
        })
    return false
    }

    function tanque_no_existe(){
        $('#modal_generico_titulo').replaceWith('<h4 class="modal-title" id="modal_generico_titulo" style="color: red">Intercambio</h4>');
        $('#modal_general_contenido').empty();
        $('#modal_general_botones').empty();

        var temp_serie=$(this).data('id');

        $.get('/nota/contrato/entrada/tanques_pendientes/' + $('#contrato_id').val(), function(data) {

            var radiobuttons='';

            $.each(data, function (key, value) {
                //entra tanque 1
                var boolbandera=true;
                var serienumber = value.num_serie;
                $(".classfilatanque").each(function(){
                    var valores = $(this).find("td")[0].innerHTML;
                    var valores2 = $(this).find("td")[4].innerHTML;
                    if(serienumber == valores || serienumber == valores2){
                        boolbandera=false;
                    }
                })

                if(boolbandera){
                    radiobuttons+=
                    '<div class="form-check">'+
                        '<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value='+value.num_serie+'>'+
                        '<label class="form-check-label" for="exampleRadios2"><strong>'+
                            value.num_serie+'</strong> '+value.tanque_desc+', Entregado con Tapa: <strong>'+ value.tapa_tanque+'</strong>'+
                        '</label>'+
                    '</div>'
                }
            });

            if(radiobuttons==""){
                mensaje_error("Este cliente no adeuda mas tanques")
            }else{

                var optiongases="";
                $.get('/catalogo_gases', function(data) {
                    
                    $.each(data, function (key, value) {
                        
                        optiongases += '<option value="'+value.id+'">'+value.nombre+'</option>'
                    });

                    var numserie = temp_serie.replace(/ /g,'').toUpperCase();
                    $('#modal_general_contenido').append(
                        '<h5 style="font-size:13px">Tanque con #serie: <strong>'+numserie+'</strong> no existe en inventario</h5>'+
                        '<hr>'+
                        '<h5 style="font-size:13px">Seleccione por que tanque se intercambiara:</h5>'+
                        '<div class="row ml-3" style="font-size:13px">'+radiobuttons+'</div>'+
                        '<hr>'+
                        '<p>Registra el tanque</p>'+
                        '<div class="form-row">'+
                            '<div class="form-group col-md-4">'+
                                '<label for="">#Serie</label>'+
                                '<input type="text" name="num_serie" id="num_serie" value="'+numserie+'" class="form-control form-control-sm" placeholder="#" readonly required>'+
                                '<span  id="num_serieError" class="text-danger"></span>'+
                            '</div>'+
        
                            '<div class="form-group col-md-2">'+
                                '<label for="">Capacidad</label>'+
                                '<select name="unidadmedida" id="unidadmedida" class="form-control form-control-sm">'+
                                    '<option value="">Selecciona</option>'+
                                    '<option value="Carga">Carga</option>'+
                                    '<option value="m3">m3</option>'+
                                    '<option value="kilos">kilos</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group col-md-2">'+
                                '<label for="">*</label>'+ 
                                '<input type="text" name="capacidadnum" id="capacidadnum" class="form-control form-control-sm numero-entero-positivo" max="10" placeholder="#" required>'+
                                '<span  id="capacidadError" class="text-danger"></span>'+
                            '</div>'+
        
                            '<div class="form-group col-md-2">'+
                                '<label for="">PH</label>'+
                                '<select name="ph_mes" id="ph_mes" class="form-control form-control-sm">'+
                                    '<option value="">Mes</option>'+
                                    '<option value="01">01</option>'+
                                    '<option value="02">02</option>'+
                                    '<option value="03">03</option>'+
                                    '<option value="04">04</option>'+
                                    '<option value="05">05</option>'+
                                    '<option value="06">06</option>'+
                                    '<option value="07">07</option>'+
                                    '<option value="08">08</option>'+
                                    '<option value="09">09</option>'+
                                    '<option value="10">10</option>'+
                                    '<option value="11">11</option>'+
                                    '<option value="12">12</option>'+
                                '</select>'+
                                '<span  id="phError" class="text-danger"></span>'+
                            '</div>'+
                            '<div class="form-group col-md-2">'+
                                '<label for="">.</label>'+
                                '<input type="number" name="ph_anio" id="ph_anio" class="form-control form-control-sm anio_format" placeholder="Anio">'+
                            '</div>'+
                        '</div>'+
        
                        '<div class="form-row">'+
                            
                            
                            '<div class="form-group col-md-3">'+
                                '<label for="">#Material</label>'+
                                '<select name="material" id="material" class="form-control form-control-sm">'+
                                    '<option value="">Selecciona</option>'+
                                    ' <option value="Acero">Acero</option>'+
                                    '<option value="Aluminio">Aluminio</option>'+
                                '</select>'+
                                '<span  id="materialError" class="text-danger"></span>'+
                            '</div>'+
                            '<div class="form-group col-md-3">'+
                                '<label for="">Tipo</label>'+
                                '<select name="tipo_tanque" id="tipo_tanque" class="form-control form-control-sm">'+
                                    '<option value="">Selecciona</option>'+
                                    '<option value="Industrial">Industrial</option>'+
                                    '<option value="Medicinal">Medicinal</option>'+
                                '</select>'+
                                '<span  id="tipo_tanqueError" class="text-danger"></span>'+
                            '</div>'+
        
                            '<div class="form-group col-md-2">'+
                                '<label for="">Fabricante</label>'+ 
                                '<select name="fabricanteoficial" id="fabricanteoficial" class="form-control form-control-sm">'+
                                    '<option value="">Selecciona</option>'+
                                    '<option value="Infra">Infra</option>'+
                                    '<option value="Praxair">Praxair</option>'+
                                    '<option value="Otros">Otros</option>'+
                                '</select>'+
                                '<span  id="fabricanteError" class="text-danger"></span>'+
                            '</div>'+
                            '<div class="form-group col-md-4">'+
                                '<label for="">*</label>'+ 
                                '<input type="text" name="otrofabricante" id="otrofabricante" class="form-control form-control-sm" required disabled>'+
                                '<span  id="fabricanteotrosError" class="text-danger"></span>'+
                            '</div>'+
                        '</div>'+
        
                        '<div class="form-row">'+
        
                            '<div class="form-group col-md-7">'+
                                '<label for="">Gas</label>'+ 
                                '<select name="tipo_gas" id="tipo_gas" class="form-control form-control-sm">'+
                                    '<option value="">Selecciona</option>'+
                                    optiongases+
                                '</select>'+
                                '<span  id="tipo_gasError" class="text-danger"></span>'+
                            '</div>'+
        
                            '<div class="form-group col-md-4">'+
                                '<label for="">Estatus</label>'+
                                '<select name="estatus" id="estatus" class="form-control form-control-sm">'+
                                    '<option value="">Selecciona</option>'+
                                    '<option value="VACIO-ALMACEN">VACIO-ALMACEN</option>'+
                                    '<option value="LLENO-ALMACEN">LLENO-ALMACEN</option>'+
                                    '<option value="INFRA">INFRA</option>'+
                                    '<option value="ENTREGADO-CLIENTE">ENTREGADO-CLIENTE</option>'+
                                    '<option value="MANTENIMIENTO">MANTENIMIENTO</option>'+
                                '</select>'+
                                '<span  id="estatusError" class="text-danger"></span>'+
                            '</div>'+
                        '</div>'+
                        '<hr>'+
                        '<p>Desea  agregar algún recargo: </p>'+
                        '<div class="input-group input-group-sm mb-3">'+
                            '<div class="input-group-prepend">'+
                                '<span class="input-group-text">Recargo: $</span>'+
                            '</div>'+
                            '<input id="inputModal-recargos-xTapa" type="number" class="form-control form-control-sm numero-decimal-positivo" value=0 aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">'+
                        '</div>'
        
                    );

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
                    
                    $('#modal_general_botones').append(
                        '<button type="button" class="btn btn-amarillo" id="btn-insertar-nuevo-tanque" >Aceptar</button>'+
                        '<button class="btn btn-amarillo ml-2" data-dismiss="modal">Cancelar</button>'
                    );

                    $("#modal_generico").css("width", "60%");
                    $("#modal_generico").css("left", "20%");
                    $('#modal_generico').modal('show');

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
                
            }
            
        });

        
    }

    function mensaje_error(mensaje){
        Swal.fire({
            icon: 'error',
            title: "Error",
            text: mensaje,
            width: '20rem',
            // showConfirmButton: true,
        })
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

    function insertar_fila(id_tanque, recargo, observaciones){
        
        $.get('/tanque/show/'+ id_tanque, function(msg) {
            var descrp=msg.capacidad+", "+msg.material+", "+msg.fabricante+", "+msg.tipo_gas;

            $('#tablelistaTanques').append(
                "<tr class='classfilatanque'>"+
                    "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                    "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion[]' value='"+descrp +"'></input>"+
                    "<td>"+msg.ph +"</td>"+  "<input type='hidden' name='inputPh[]' value='"+msg.ph +"'></input>"+
                    "<td class='width-column p-0 m-0'><select name='inputTapa[]' id='inputTapa' class='form-control form-control-sm p-0 m-0'><option value=''>Selecciona</option><option value='SI'>SI</option><option value='NO'>NO</option></select></td>"+
                    "<td>"+"SN"+"</td>"+ "<input type='hidden' name='inputCambio[]' value='SN'></input>"+
                    "<td class='width-column p-0 m-0'><input type='number' value="+recargo+" class='recargotapa form-control form-control-sm p-0 m-0'></input></td>"+
                    "<td>"+observaciones+"</td>"+
                    "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>");
            $("#serie_tanque").val('');
            $("#tapa_tanque").val('');
        })
    }

    function insertar_tanque_clientediferente(){
        if($('input:radio[name=exampleRadios]:checked').val() == undefined){
            mensaje_error("No ha seleccionado por que tanque se hara este cambio");
            return false;
        }
        $('#modal_generico').modal('hide');

        var nota_id="";
        
            $(".class-tanques-nota").each(function(index, value){
                if($('input:radio[name=exampleRadios]:checked').val() == $(this).find("td")[1].innerHTML){
                    nota_id=parseInt($(this).find("td")[5].innerHTML);
                }
            }); 
            if(nota_id==""){
                mensaje_error("Id de nota no encontrado");
                return false;
            };
        
        $.get('/tanque/show/'+ $(this).data('id'), function(msg) {
            var descrp=msg.capacidad+", "+msg.material+", "+msg.fabricante+", "+msg.tipo_gas;
            $('#tablelistaTanques').append(
                "<tr class='classfilatanque'>"+
                    "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                    "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion[]' value='"+descrp +"'></input>"+
                    "<td>"+msg.ph +"</td>"+  "<input type='hidden' name='inputPh[]' value='"+msg.ph +"'></input>"+
                    "<td class='width-column p-0 m-0'><select name='inputTapa[]' id='inputTapa' class='form-control form-control-sm p-0 m-0'><option value=''>Selecciona</option><option value='SI'>SI</option><option value='NO'>NO</option></select></td>"+
                    "<td>"+$('input:radio[name=exampleRadios]:checked').val()+"</td>"+ "<input type='hidden' name='inputCambio[]' value='"+$('input:radio[name=exampleRadios]:checked').val()+"'></input>"+
                    "<td class='width-column p-0 m-0'><input type='number' value="+$("#inputModal-recargos-xTapa").val()+" class='recargotapa form-control form-control-sm p-0 m-0'></input></td>"+
                    "<input type='hidden' name='inputIdNota[]' value="+nota_id+"></input>"+
                    "<td>Cilindro de cambiado</td>"+
                    "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>");
            $("#serie_tanque").val('');
            $("#tapa_tanque").val('');
            $("#serie_tanqueError").empty();
        })
    }

    function insertar_nuevo_tanque(){
        $("#serie_tanqueError").empty();
        $("#span_no_existe").empty();
        var campo= [
            'num_serie',
            'unidadmedida',
            'capacidadnum',
            'material',
            'tipo_tanque',
            'estatus',
            'ph_anio',
            'ph_mes',
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

        var cap=$('#capacidadnum').val()+' '+ $('#unidadmedida').val();
        
        if(fabri==""){
            $("#fabricanteError").text('Necesario');
            $("#fabricanteError").addClass('is-invalid');
            return false;
        }else{
            $("#fabricanteError").empty();
            $("#fabricanteError").removeClass('is-invalid');
        }
        
        if($('input:radio[name=exampleRadios]:checked').val() == undefined){
            mensaje_error("No ha seleccionado por que tanque se hara este cambio");
            return false;
        }
        $('#modal_generico').modal('hide');
        
        $("#phError").empty();
        $("#ph_anio").removeClass('is-invalid');
        if($('#ph_anio').val()<1950){
            $("#phError").text('Campo Incorrecto');
            $("#ph_anio").addClass('is-invalid');
            return false;
        }

        
        var descrp=
        cap+", "+
        $("#material").val()+", "+
        fabri+", "+
        $("#tipo_tanque").val()+", "+
        $("#estatus").val()+", "+
        $("#tipo_gas").val()+" "+$("#tipo_gas option:selected").text();

        var nota_id="";
        
            $(".class-tanques-nota").each(function(index, value){

                if($('input:radio[name=exampleRadios]:checked').val() == $(this).find("td")[1].innerHTML){
                    
                    nota_id=parseInt($(this).find("td")[4].innerHTML);
                }
            }); 
            if(nota_id==""){
                mensaje_error("Id de nota no encontrado");
                return false;
            };
            var numserie =  $('#num_serie').val().replace(/ /g,'').toUpperCase();
            $('#tablelistaTanques').append(
                "<tr class='classfilatanque'>"+
                    "<td>"+numserie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+numserie +"'></input>"+
                    "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion[]' value='"+descrp +"'></input>"+
                    "<td>"+$('#ph_anio').val()+'-'+$('#ph_mes').val()+"</td>"+  "<input type='hidden' name='inputPh[]' value='"+$('#ph_anio').val()+'-'+$('#ph_mes').val()+"'></input>"+
                    "<td class='width-column p-0 m-0'><select name='inputTapa[]' id='inputTapa' class='form-control form-control-sm p-0 m-0'><option value=''>Selecciona</option><option value='SI'>SI</option><option value='NO'>NO</option></select></td>"+
                    "<td>"+$('input:radio[name=exampleRadios]:checked').val()+"</td>"+ "<input type='hidden' name='inputCambio[]' value='"+$('input:radio[name=exampleRadios]:checked').val()+"'></input>"+
                    "<td class='width-column p-0 m-0'><input type='number' value="+$("#inputModal-recargos-xTapa").val()+" class='recargotapa form-control form-control-sm p-0 m-0'></input></td>"+
                    "<td>Nuevo Registro</td>"+
                    "<input type='hidden' name='inputIdNota[]' value="+nota_id+"></input>"+
                    "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>");
            $("#serie_tanque").val('');
            $("#tapa_tanque").val('');
    }

    function diferente_cliente(){
        var tanque_id= $(this).data('id');
        $('#modal_generico_titulo').replaceWith('<h4 class="modal-title" id="modal_generico_titulo" style="color: red">Intercambio</h4>');
        $('#modal_general_contenido').empty();
        $('#modal_general_botones').empty();

        $.get('/nota/contrato/entrada/tanques_pendientes/' + $('#contrato_id').val(), function(data) {

            var radiobuttons='';

            $.each(data, function (key, value) {
                //entra tanque 1

                var boolbandera=true;
                var serienumber = value.num_serie;
                $(".classfilatanque").each(function(){
                    var valores = $(this).find("td")[0].innerHTML;
                    var valores2 = $(this).find("td")[4].innerHTML;
                    if(serienumber == valores || serienumber == valores2){
                        boolbandera=false;
                    }
                    
                })

                if(boolbandera){
                    radiobuttons+=
                    '<div class="form-check">'+
                        '<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value='+value.num_serie+'>'+
                        '<label class="form-check-label" for="exampleRadios2"><strong>'+
                            value.num_serie+'</strong> '+value.tanque_desc+', Entregado con Tapa: <strong>'+ value.tapa_tanque+'</strong>'+
                        '</label>'+
                    '</div>'
                }

            });

            
            
            if(radiobuttons==""){
                mensaje_error("Este cliente no adeuda mas tanques")
            }else{
                var numserie =  $('#serie_tanque').val().replace(/ /g,'').toUpperCase();
                    $('#modal_general_contenido').append(
                        '<h5 style="font-size:13px">Tanque - #serie: <strong>'+numserie+'</strong> </h5>'+
                        '<hr>'+
                        '<h5 style="font-size:13px">Seleccione por que tanque se intercambiara:</h5>'+
                        '<div class="row ml-3" style="font-size:13px">'+radiobuttons+'</div>'+
                        '<hr>'+
                        '<p>Desea  agregar algún recargo: </p>'+
                        '<div class="input-group input-group-sm mb-3">'+
                            '<div class="input-group-prepend">'+
                                '<span class="input-group-text">Recargo: $</span>'+
                            '</div>'+
                            '<input id="inputModal-recargos-xTapa" type="number" class="form-control form-control-sm numero-decimal-positivo" value=0 aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">'+
                        '</div>'
        
                    );
                    
                    $('#modal_general_botones').append(
                        '<button type="button" class="btn btn-amarillo" data-id="'+tanque_id+'" id="btn-insertar-tanque-clientediferente" >Aceptar</button>'+
                        '<button class="btn btn-amarillo ml-2" data-dismiss="modal">Cancelar</button>'
                    );

                    $("#modal_generico").css("width", "60%");
                    $("#modal_generico").css("left", "20%");
                    $('#modal_generico').modal('show');
                    
                
                
            }
            
        });

        
    }


    function eliminarFila(){
        $(this).closest('tr').remove();
        
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

        if($('#contrato_id').val() == '') {
            mostrar_mensaje("error",'Error', 'falta información de contrato', 2000);
            return false;
        }


        //SI no hay tanques agregados manda error
        if($('input[id=idInputNumSerie]').length === 0) {
            mostrar_mensaje("error",'Error','No hay tanques en la lista', 2000);
            return false;
        }

        $("select[name='inputTapa[]']").each(function(indice, elemento) {
            
            if($(elemento).val()==""){
                $(elemento).addClass("is-invalid");
                mensaje('error','Error','Faltan campos por rellenar', 1500, null);
                return false;
            }else{
                actualizar_operaciones()
                $(elemento).removeClass("is-invalid");
                $('#static-modal-pago').modal("show");
            }
        });
    }


    $("#recargos").keyup( function() {
        actualizar_operaciones();
    });

    function actualizar_operaciones(){
        var recargosxtapa = 0;
        var otrosrecargos=0;

        if($('#recargos').val() < 0 || $('#recargos').val() == '' ) {
            otrosrecargos=0;
        }else{
            otrosrecargos=parseFloat($("#recargos").val());
        }

        $('.recargotapa').each(function(){
            recargosxtapa += parseFloat($(this).val());
        });

        $("#recargosXtapa").val(recargosxtapa);

        var total=otrosrecargos+recargosxtapa;
        $('#label-total').replaceWith( 
            "<label id='label-total'>$ "+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );
        $('#input-total').val(total);
    }


    function guardar_nota(){
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
        $.ajax({
            method: "post",
            url: "/nota/contrato/entrada/save",
            data: $("#form-entrada-nota").serialize(), 
        }).done(function(msg){
            location.reload();
        })
        .fail(function (jqXHR, textStatus) {
            //Si existe algun error entra aqui

            mostrar_mensaje('error','Error','Verifica tus datos', null);
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key + "Error";
                    
                    $(idError).text(value);
                });
            }
        });


    }

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


    //FIN Funcion registrar nota
    
    //FUNCIONES GENERALES
    function mostrar_mensaje(icono,titulo,mensaje, timer) {
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje
        })
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

    //FIN FUNCIONES GENERALES

    //cancelar nota
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




