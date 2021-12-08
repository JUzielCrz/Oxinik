$(document).ready(function () {

    $(document).on("click","#btn-InsertFila", insert_fila);
    $(document).on("click","#btn-EliminarFila", eliminar_fila);
    $(document).on("click","#btn-registrar-tanque", validar_tanque);


    $(document).on("click","#btn-save", guardar_registros);


    $('#serie_tanque').keypress(function (event) {
        // console.log(event.charCode);
        if (event.charCode == 13 ){
            event.preventDefault();
            insert_fila();
        } 
    });

    actualizar_numeros();

    function insert_fila(){
        
        $('#serie_tanqueError').empty();

        var numserie= $('#serie_tanque').val().replace(/ /g,'');

        if(numserie ==''){
            $('#serie_tanqueError').text('Número de serie obligatorio');
            $('#serie_tanque').val('');
            return false;
        }

        var boolRepetido=false;
        $(".trFilaTanque").each(function(){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == numserie){
                boolRepetido=true;
            }
        })
        if(boolRepetido){
            $("#serie_tanqueError").text('Número de serie ya agregado a lista');
            $("#tbody_errores").append('<tr><td>'+$("#serie_tanque").val()+'</td><td>Repetido</td></tr>');
            $('#serie_tanque').val('');
            return false;
        }
        

        $.get('/tanque/show_numserie/'+numserie, function(msg) {
            if(msg==''){
                // $('#serie_tanqueError').text('Error, No exite registro de tanque con este número de serie');
                // $("#tbody_errores").append('<tr><td>'+$("#serie_tanque").val()+'</td><td>Sin Registrar</td></tr>');
                $("#modal-registrar-tanque").modal('show');
                $("#num_serie").val();
                $('#num_serie').val(numserie);
                $("#num_serie").prop("disabled", true);
                $('#estatus').val('INFRA');
                $("#estatus").prop("disabled", true);
                return false;
            }
            if(msg.estatus=='INFRA'){
                $("#tbodyfilaTanques").append(
                    "<tr class='trFilaTanque'>"+
                        "<td>"+msg.num_serie+"</td>"+"<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+msg.num_serie +"'></input>"+
                        "<td>"+msg.capacidad+"</td>"+
                        "<td>"+msg.material+"</td>"+
                        "<td>"+msg.ph+"</td>"+
                        "<td>"+msg.fabricante+"</td>"+
                        "<td>"+ "<button type='button' class='btn btn-naranja' id='btn-EliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                    "</tr>"
                );
                
                actualizar_numeros();
                
                $('#serie_tanque').val('');
            }else{
                $('#serie_tanqueError').text('Error, estatus tanque: '+ msg.estatus);
                $("#tbody_errores").append('<tr><td>'+$("#serie_tanque").val()+'</td><td>Estatus: '+msg.estatus+'</td></tr>');
                $('#serie_tanque').val('');
                return false;
            }
        });
    }

    function eliminar_fila(){
        $(this).closest('tr').remove();
        actualizar_numeros();
    }

    
    function guardar_registros(){
        //SI no hay tanques agregados manda error
        if($('input[id=idInputNumSerie]').length === 0) {
            mensaje('error','Error','No hay tanques en lista',null);
            return false;
        }

        var dataForm= $("#formCreateInfra").serialize()+'&cantidad_entrada=' + $('#cantidad_entrada').val();

        $.ajax({
            method: "post",
            url: "/infra/entrada_save",
            data: dataForm,
        }).done(function(msg){
            mensaje(msg.alert,msg.alert,msg.mensaje, null, null);
        })
        .fail(function (jqXHR, textStatus) {
            //Si existe algun error entra aqui
            mensaje('error','Error','Verifica tus datos', null);
            var status = jqXHR.status;
            if (status === 422) {
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    var idError = "#" + key + "Error";
                    $(idError).text(value);
                });
            }
        });
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

        var cap=$('#capacidadnum').val()+' '+ $('#unidadmedida').val();
        if($('#capacidadnum').val()==''){
            $("#capacidad"+"Error").text('El campo Capacidad es Obligatorio');
            return false;
        }

        if($('#ph_anio').val()<1950){
            $("#phError").text('Campo Incorrecto');
            $("#ph_anio").addClass('is-invalid');
            return false;
        }
        var numserie= $('#num_serie').val().replace(/ /g,'');
        $.ajax({
            method: "POST",
            url: "/tanque/create",
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#id').val(),
                'num_serie': numserie,
                'ph': $('#ph_anio').val()+'-'+$('#ph_mes').val() ,
                'capacidad': cap,
                'material': $('#material').val(),
                'fabricante': fabri,
                'tipo_gas': $('#tipo_gas').val(),
                'estatus': $('#estatus').val(),
                'tipo_tanque': $('#tipo_tanque').val(),
                },
        })
        .done(function (msg) {
            if(msg.mensaje == 'Sin permisos'){
                mensaje("error","Sin permisos", "No tienes los permisos suficientes para realizar esta acción.", null, null);
                return false;
            }
            $("#tbodyfilaTanques").append(
                "<tr class='trFilaTanque'>"+
                    "<td>"+$("#num_serie").val()+"</td>"+"<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+$("#num_serie").val() +"'></input>"+
                    "<td>"+$("#capacidadnum").val()+$("#unidadmedida").val()+"</td>"+
                    "<td>"+$("#material").val()+"</td>"+
                    "<td>"+$("#ph_anio").val()+"-"+$("#ph_mes").val()+"</td>"+
                    "<td>"+$("#fabricanteoficial").val()+" "+$("#otrofabricante").val()+"</td>"+
                    "<td>"+ "<button type='button' class='btn btn-naranja' id='btn-EliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
                "</tr>"
            );
            mensaje("success","EXITO", "Guardado correctamente.", 1000, '#modal-registrar-tanque');
            limpiar_campos_tanque();
            actualizar_numeros();
        })
        .fail(function (jqXHR, textStatus) {
            mensaje("error",'Error', 'Verifique sus datos.', null,null);
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

    function limpiar_campos_tanque(){
        $("#num_serie").val("");
        $("#ph_mes").val("");
        $("#ph_anio").val("");
        $("#unidadmedida").val("");
        $("#capacidadnum").val("");
        $("#material").val("");
        $("#fabricanteoficial").val("");
        $("#otrofabricante").val("");
        $("#tipo_gas").val("");
        $("#estatus").val("");
        $("#tipo_tanque").val("");
    }

    //funciones generales
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

    function actualizar_numeros(){
        var cant_filas=$('#tbodyfilaTanques tr').length;
        var diferencia=$('#cantidad_salida').val()-cant_filas;
        $("#cantidad_entrada_h").replaceWith(
            "<h1 id='cantidad_entrada_h' class='display-1' style='font-size: 5rem;'>"+ cant_filas+"</h1>"
        );
        $("#cantidad_diferencia_h").replaceWith(
            "<h1 id='cantidad_diferencia_h' class='display-1' style='font-size: 5rem;'>"+ diferencia+"</h1>"
        );
        $('#cantidad_entrada').val(cant_filas)
        $('#cantidad_diferencia').val(diferencia)
    };

});