$(document).ready(function () {
    //validar fila entrada
    $(document).on("click","#btn-insert-fila-entrada", validar_fila_entrada);
    $(document).on("click","#btnEliminarFila", eliminarFila);

    //registro tanque
    $(document).on("click","#btn-registrar-tanque", validar_tanque);

    //Nota General
    $(document).on("click","#btn-guardar-nota", guardar_nota);
    $(document).on("click","#btnCancelar", cancelarnota);

    //Editar Cliente
    $(document).on("click","#btn-editar-cliente", editar_show);
    $(document).on("click","#btn-cliente-edit-save", editar_save);

    //Crear Cliente
    $(document).on("click","#btn-cliente-create-save", create_save);

    $('#serie_tanque_entrada').keypress(function (event) {
        if (event.charCode == 13 ){
            event.preventDefault();
            validar_fila_entrada();
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

    //FUNCIONES INSERTAR FILA entrada
    function validar_fila_entrada() {
        //Eliminar espacios
        var numserie= $('#serie_tanque_entrada').val().replace(/ /g,'').toUpperCase();

        //validar campos no vacios
        var campo= ['serie_tanque_entrada','tapa_tanque'];
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
    
        //Bucar si ya esta agregado tanque a la lista
        var boolRepetido=false;
        $(".classfilatanque").each(function(index, value){
            if($(this).find("td")[0].innerHTML == numserie){
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
            var numserie= $('#serie_tanque_entrada').val().replace(/ /g,'').toUpperCase();
            if(msg == ""){// entra si no existe tanque
                $('#num_serie').val(numserie);
                $('#num_serie').prop("disabled", true);
                $("#modal-registrar-tanque").modal('show');
            }else{
                if(msg.estatus == "VENTA-TALON"){
                    insertar_fila_entrada(msg);
                    mensaje("info","Aviso", "Este cilindro ya esta registrado en su base da datos" , 1000, "#modal-registrar-tanque");
                }else{ 
                    //Tanque registrado en el sistema con estus diferente a VENTA-talon
                    Swal.fire({
                        icon: 'warning',
                        html: 'Este tanque esta registrado en el sistema, pero no ha salido en alguna venta talon <br> Estatus tanque:  <strong> '+msg.estatus+'</strong> <br>',
                        showCancelButton: true,
                        confirmButtonText: 'Continuar de todos modos',
                        footer: '<a class="btn btn-link" target="_blank" href="/tanque/history/'+msg.id+'">ver historial <strong>'+msg.num_serie+'</strong></a>'+
                        '<a class="btn btn-link" target="_blank" href="/tanque/reportados/create">Levantar reporte <strong>'+msg.num_serie+'</strong></a>',
                        
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
        
        var tapaTanque=$('#tapa_tanque').val();

        $.get('/tanque/validar_ph/' + pruebah, function(respuesta) {
            var tdph;
            if(respuesta.alert){
                tdph="<td class='table-danger'>"+pruebah +"</td>"
            }else{
                tdph="<td>"+pruebah +"</td>"
            }
            var serie_cilindro=valorcampo[0];
            var serie_limpiado=serie_cilindro.replace(/ /g,'').toUpperCase();
            $('#tbody-tanques-entrada').append(
                "<tr class='classfilatanque'>"+
                "<td>"+serie_limpiado +"</td>"+ "<input type='hidden' name='inputNumSerie_entrada[]' id='idInputNumSerie_entrada' value='"+serie_limpiado +"'></input>"+
                "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion_entrada[]' value='"+descrp +"'></input>"+
                tdph+ "<input type='hidden' name='inputPh_entrada[]' value='"+pruebah +"'></input>"+
                "<td>"+tapaTanque+"</td>"+ "<input type='hidden' name='inputTapa_entrada[]' value='"+tapaTanque +"'></input>"+
                "<input type='hidden' name='inputRegistro[]' value="+inputRegistro+"></input>"+
                "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>"
            );

            mensaje("success","Exito", "Agregado Correctamente" , 1500, "#modal-registrar-tanque");
            limpiar_campos();
        });
    }

    $("#unidad_medida").change( function() {
        if ($(this).val() == "CARGA") {
            $("#cantidad").prop("readonly", true);
            $("#cantidad").val(1);

        }else{
            $("#cantidad").prop("readonly", false);
        } 
    });

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


        insertar_fila_entrada('REGISTRO-TANQUE');
    }

    function limpiar_campos(){
        $("#num_serie").val("");
        $("#ph_mes").val("");
        $("#ph_anio").val("");
        $("#capacidadnum").val("");
        $("#unidadmedida").val("");
        $("#material").val("");
        $("#otrofabricante").val("");
        $("#fabricanteoficial").val("");
        $("#tipo_gas").val("");
        $("#tipo_tanque").val("");
        $("#estatus").val("");

        $("#serie_tanque_entrada").val("");
        $("#tapa_tanque").val("");
        $("#cantidad").val("");
        $("#unidad_medida").val("");
        $("#precio_unitario").val("");
        $("#iva").val("");
    }


    //Funciones finales de Nota General
    function guardar_nota(){
        //validaciones
        $("#id_show").removeClass('is-invalid');
        if($("#id_show").val() == ''){
            $("#id_show").addClass('is-invalid');
            return false;
        }


        //SI no hay tanques agregados en salida manda error
        if($('#idInputNumSerie_entrada').length === 0) {
            mensaje('error','Error', 'No hay registro de tanques', null, null);
            return false;
        }
        
        // envio al controlador
        $.ajax({
            method: "post",
            url: "/nota/talon/create/save",
            data: $("#idFormNewVenta").serialize(), 
        }).done(function(msg){
            if(msg.mensaje =='Registro-Correcto'){
                window.open("/pdf/nota/talon/"+ msg.notaId, '_blank');
                window.location = '/nota/talon/index';
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
                window.location = '/nota/talon/index';
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