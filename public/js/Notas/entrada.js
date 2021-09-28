$(document).ready(function () {
    
    //Link de botones


    $(document).on("click","#btn-registrar-tanque", registrar_tanque);

    $(document).on("click","#btn-pagar-nota", pagar_nota);
    $(document).on("click","#guardar-nota", guardar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);

    $(document).on("click","#btnInsertFila", validar_fila);
    $(document).on("click","#btn-continuar-RXtapa", recargo_xtapa);
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
                    url:"/nota/salida/search_contrato",
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
                $('#num_contrato').val(msg.contrato.num_contrato)
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
            
        $.get('/nota/entrada/tanques_pendientes/' + contrato_id, function(data) {
            var columnas='';
            $.each(data, function (key, value) {
                columnas+='<tr class="class-tanques-nota"><td>'+
                value.num_serie+'</td><td>'+
                value.tanque_desc+'</td><td>'+
                value.tapa_tanque+'</td><td>'+
                value.fecha+ '</td><td>' +
                value.nota_id+'</td><td>'+
                '<a type="button" href="/pdf/nota/'+value.nota_id+'" target="_blank" class="btn btn-sm btn-grisclaro btn-nota-id" ><i class="fas fa-sticky-note"></i></a></td></tr>';
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
                value.unidad_medida+'</td></tr>';
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
        evnt.preventDefault();
        var numserie= $('#serie_tanque').val().replace(/ /g,'');


        if($(".class-tanques-nota").length == 0) {
            mensaje_error('Cliente no adeuda mas tanques');
            return false;
        }
        if(numserie == ''){
            $('#serie_tanqueError').text('Necesario');
            return false;
        }
        $('#serie_tanque').removeClass('is-invalid');
        $('#serie_tanqueError').empty();
        if($('#tapa_tanque').val() == ''){
            $('#tapa_tanque').addClass('is-invalid');
            $('#tapa_tanqueError').text('Necesario');
            return false;
        }
        $('#tapa_tanque').removeClass('is-invalid');
        $('#tapa_tanqueError').empty();

        

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
            if(msg==''){//tanque no existe
                tanque_no_existe();
            }else{//tanque si existe
                var bandera_pendiete=false; //validar si el tanque es de los que adeuda
                var tapa_tanque_estatus="";
                $(".class-tanques-nota").each(function(index, value){
                    var tanquePendiente = $(this).find("td")[0].innerHTML;
                    if(tanquePendiente == numserie){
                        bandera_pendiete=true;
                        tapa_tanque_estatus=$(this).find("td")[2].innerHTML;
                    }
                })

                if(bandera_pendiete){
                    // si es de los que adeuda, el tanque le pertenece al contrato del cliente.
                    if( msg.estatus == "ENTREGADO-CLIENTE"){
                        if($('#tapa_tanque').val() == 'NO' && tapa_tanque_estatus == 'SI'){ ///si no viene con tapa
                            tanque_sin_tapa(numserie, msg.id);
                        }else{
                            insertar_fila(msg.id, 0);
                        }
                    }else{
                        //#serie si esta en su contrato pero su estatus es reportado o esta entregado a otro cliente;
                        Swal.fire({
                            icon: 'warning',
                            html: 'Este tanque se muestra con estatus: <br> <strong> '+msg.estatus+'</strong> <br> <p> Debes modificar estatus del tanque a <strong> "ENTREGADO-CLIENTE" </strong> si deseas agregarlo a esta nota <p>',
                            footer: '<a class="btn btn-link" target="_blank" href="/tanque/history/'+msg.id+'">ver historial <strong>'+msg.num_serie+'</strong></a>'
                        })
                    }
                    
                }else{
                    
                    //#serie no encontrado en su contrato pero si existe;
                    Swal.fire({
                        icon: 'warning',
                        html: 'Este tanque esta registrado en el sistema, pero no es de los entregados a este cliente <br> Estatus:  <strong> '+msg.estatus+'</strong> <br>',
                        showCancelButton: true,
                        confirmButtonText: 'Continuar de todos modos',
                        footer: '<a class="btn btn-link" target="_blank" href="/tanque/history/'+msg.id+'">ver historial <strong>'+msg.num_serie+'</strong></a>'+
                        '<a class="btn btn-link" target="_blank" href="/tanque/reportados/create'+msg.id+'">Levantar reporte <strong>'+msg.num_serie+'</strong></a>',
                        
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            diferente_cliente(msg.id, 0);
                        } 
                    })
                }
            
            }
        })
    return false
    }

    function tanque_sin_tapa(num_serie, tanque_id){
        $('#modal_generico_titulo').replaceWith('<h4 class="modal-title" id="modal_generico_titulo" style="color: red">Advertencia</h4>');
        
        $('#modal_general_contenido').empty();
        $('#modal_general_botones').empty();

        $('#modal_general_contenido').append(
            '<h5 class="text-center mt-3" style="font-size:16px">Tanque con serie: <strong>'+num_serie+'</strong>; Fue entregado con tapa</h5>'+
            '<div class="row justify-content-center mb-4 mt-4"> <div class="col-7">'+
            '<div class="input-group input-group-sm  ">'+
                '<div class="input-group-prepend">'+
                    '<span class="input-group-text">Recargos: $</span>'+
                '</div>'+
                '<input id="inputModal-recargos-xTapa" type="number" class="form-control form-control numero-decimal-positivo" value=0 aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">'+
            '</div></div></div><hr> '
        );
        $('#modal_general_botones').append(
            '<button type="button" class="btn btn-gray" id="btn-continuar-RXtapa"   data-id="'+tanque_id+'">Aceptar</button>'+
            '<button class="btn btn-gray ml-2" data-dismiss="modal">Cancelar</button>'
        );
        $("#modal_generico").css("width", "40%");
        $("#modal_generico").css("left", "30%");
        $('#modal_generico').modal('show');
        
    }
    
    function recargo_xtapa(){
        insertar_fila($(this).data('id'), $('#inputModal-recargos-xTapa').val());
        $('#modal_generico').modal('hide');
        
    }

    function tanque_no_existe(){
        $('#modal_generico_titulo').replaceWith('<h4 class="modal-title" id="modal_generico_titulo" style="color: red">Intercambio</h4>');
        $('#modal_general_contenido').empty();
        $('#modal_general_botones').empty();

        $.get('/nota/entrada/tanques_pendientes/' + $('#contrato_id').val(), function(data) {

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

                    $('#modal_general_contenido').append(
                        '<h5 style="font-size:13px">Tanque con #serie: <strong>'+$('#serie_tanque').val()+'</strong> no existe en inventario</h5>'+
                        '<hr>'+
                        '<h5 style="font-size:13px">Seleccione por que tanque se intercambiara:</h5>'+
                        '<div class="row ml-3" style="font-size:13px">'+radiobuttons+'</div>'+
                        '<hr>'+
                        '<p>Registra el tanque</p>'+
                        '<div class="form-row">'+
                            '<div class="form-group col-md-4">'+
                                '<label for="">#Serie</label>'+
                                '<input type="text" name="num_serie" id="num_serie" value="'+$('#serie_tanque').val()+'" class="form-control form-control-sm" placeholder="#" readonly required>'+
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
        
                            '<div class="form-group col-md-4">'+
                                '<label for="">PH</label>'+
                                '<input type="month" name="ph" id="ph" class="form-control form-control-sm">'+
                                '<span  id="phError" class="text-danger"></span>'+
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
                                    '<option value="Plaxair">Plaxair</option>'+
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
                        '<button type="button" class="btn btn-gray" id="btn-insertar-nuevo-tanque" >Aceptar</button>'+
                        '<button class="btn btn-gray ml-2" data-dismiss="modal">Cancelar</button>'
                    );

                    $("#modal_generico").css("width", "60%");
                    $("#modal_generico").css("left", "20%");
                    $('#modal_generico').modal('show');
                    
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

    function insertar_fila(id_tanque, recargo){
        
        $.get('/tanque/show/'+ id_tanque, function(msg) {
            var descrp=msg.capacidad+", "+msg.material+", "+msg.fabricante+", "+msg.tipo_gas;
            var nota_id="";
            $(".class-tanques-nota").each(function(index, value){
                if(msg.num_serie == $(this).find("td")[0].innerHTML){
                    nota_id=parseInt($(this).find("td")[4].innerHTML);
                }
            })

            $('#tablelistaTanques').append(
                "<tr class='classfilatanque'>"+
                    "<td>"+msg.num_serie +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                    "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion[]' value='"+descrp +"'></input>"+
                    "<td>"+msg.ph +"</td>"+  "<input type='hidden' name='inputPh[]' value='"+msg.ph +"'></input>"+
                    "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                    "<td>"+"SN"+"</td>"+ "<input type='hidden' name='inputCambio[]' value='SN'></input>"+
                    "<td>"+recargo+"</td>"+
                    "<input type='hidden' name='inputIdNota[]' value="+nota_id+"></input>"+
                    "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>");
            $("#serie_tanque").val('');
            $("#tapa_tanque").val('');
            actualizarrecargos();
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
                if($('input:radio[name=exampleRadios]:checked').val() == $(this).find("td")[0].innerHTML){
                    nota_id=parseInt($(this).find("td")[4].innerHTML);
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
                    "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                    "<td>"+$('input:radio[name=exampleRadios]:checked').val()+"</td>"+ "<input type='hidden' name='inputCambio[]' value='"+$('input:radio[name=exampleRadios]:checked').val()+"'></input>"+
                    "<td>"+$("#inputModal-recargos-xTapa").val()+"</td>"+
                    "<input type='hidden' name='inputIdNota[]' value="+nota_id+"></input>"+
                    "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>");
            $("#serie_tanque").val('');
            $("#tapa_tanque").val('');
            actualizarrecargos();
        })
    }

    function insertar_nuevo_tanque(){
        var campo= [
            'serie_tanque',
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

        var descrp=
        cap+", "+
        $("#material").val()+", "+
        fabri+", "+
        $("#tipo_tanque").val()+", "+
        $("#estatus").val()+", "+
        $("#tipo_gas").val()+" "+$("#tipo_gas option:selected").text();

        var nota_id="";
            $(".class-tanques-nota").each(function(index, value){
                if($('input:radio[name=exampleRadios]:checked').val() == $(this).find("td")[0].innerHTML){
                    nota_id=parseInt($(this).find("td")[4].innerHTML);
                }
            }); 
            if(nota_id==""){
                mensaje_error("Id de nota no encontrado");
                return false;
            };

            $('#tablelistaTanques').append(
                "<tr class='classfilatanque'>"+
                    "<td>"+$('#serie_tanque').val() +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+$('#serie_tanque').val() +"'></input>"+
                    "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion[]' value='"+descrp +"'></input>"+
                    "<td>"+$("#ph").val() +"</td>"+  "<input type='hidden' name='inputPh[]' value='"+$("#ph").val() +"'></input>"+
                    "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
                    "<td>"+$('input:radio[name=exampleRadios]:checked').val()+"</td>"+ "<input type='hidden' name='inputCambio[]' value='"+$('input:radio[name=exampleRadios]:checked').val()+"'></input>"+
                    "<td>"+$("#inputModal-recargos-xTapa").val()+"</td>"+
                    "<input type='hidden' name='inputIdNota[]' value="+nota_id+"></input>"+
                    "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>");
            $("#serie_tanque").val('');
            $("#tapa_tanque").val('');
            actualizarrecargos();
    }

    function diferente_cliente(tanque_id){
        $('#modal_generico_titulo').replaceWith('<h4 class="modal-title" id="modal_generico_titulo" style="color: red">Intercambio</h4>');
        $('#modal_general_contenido').empty();
        $('#modal_general_botones').empty();

        $.get('/nota/entrada/tanques_pendientes/' + $('#contrato_id').val(), function(data) {

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

                    $('#modal_general_contenido').append(
                        '<h5 style="font-size:13px">Tanque - #serie: <strong>'+$('#serie_tanque').val()+'</strong> </h5>'+
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
                        '<button type="button" class="btn btn-gray" data-id="'+tanque_id+'" id="btn-insertar-tanque-clientediferente" >Aceptar</button>'+
                        '<button class="btn btn-gray ml-2" data-dismiss="modal">Cancelar</button>'
                    );

                    $("#modal_generico").css("width", "60%");
                    $("#modal_generico").css("left", "20%");
                    $('#modal_generico').modal('show');
                    
                
                
            }
            
        });

        
    }


    function actualizarrecargos(){
        var recargos = 0;

        $(".classfilatanque").each(function(){
            var recargoImporte=$(this).find("td")[5].innerHTML;
            recargos=recargos+parseFloat(recargoImporte);
        })
        $('#recargosXtapa').val(recargos);

        actualizar_total();
    }

    function eliminarFila(){
        $(this).closest('tr').remove();
        actualizarrecargos();
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


        if(parseFloat($('#monto_pago').val()) <= 0) {
            $("#metodo_pagoError").text('Monto debe ser mayor a 0');
            return false;
        }

        $("#ingreso-efectivoError").empty();
        if($("#metodo_pago").val()=='Efectivo'){
            if(parseFloat($("#ingreso-efectivo").val()) == 0){
                $("#ingreso-efectivoError").text('Campo ingreso de efectivo obligatorio');
                return false;
            }
            if(parseFloat($("#ingreso-efectivo").val()) < parseFloat($("#monto_pago").val())){
                $("#ingreso-efectivoError").text('INGRESI EFECTIVO no puede ser menor a MONTO A PAGAR');
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


        $('#static-modal-pago').modal("show");

        var adeudo = parseFloat($("#input-total").val())- parseFloat($("#monto_pago").val());
        
        
        $("#label-adeudo").replaceWith(
            "<label id='label-adeudo'>"+Intl.NumberFormat('es-MX').format(adeudo)+"</label>"
        );
    
        var cambio = 0;
        if($("#metodo_pago").val() == "Efectivo"){
            cambio = parseFloat($("#ingreso-efectivo").val())-parseFloat($("#monto_pago").val());
            $("#label-cambio").replaceWith(
                "<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
            );
        }else{
            $("#label-cambio").replaceWith(
                "<label id='label-cambio'>$ "+Intl.NumberFormat('es-MX').format(cambio)+"</label>"
            );
        }

    }

    $('#recargos').keyup(function(){
        actualizar_total();
    });

    function actualizar_total(){
        var recargos=0;
        if($('#recargos').val() < 0 || $('#recargos').val() == '' ) {
            recargos=0;
        }else{
            recargos=parseFloat($("#recargos").val());
        }
        var total=recargos+parseFloat($("#recargosXtapa").val());
        $('#label-total').replaceWith( 
            "<label id='label-total'>$ "+Intl.NumberFormat('es-MX').format(total) +"</label>"
        );
        $('#input-total').val(total);
        $("#monto_pago").val(total);
    }

    function guardar_nota(){
        // envio al controlador
        $.ajax({
            method: "post",
            url: "/nota/entrada/save",
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

        }else{
            $("#ingreso-efectivo").prop("disabled", true);
            $("#ingreso-efectivo").val(0);

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




