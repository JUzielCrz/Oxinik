$(document).ready(function () {
    $(document).on("click","#btn-insert", valid);


    //Validate for Inserte Row Concentrator
    function valid() {
        //limpiar span input
        $('#serial_concentratorError').empty();
        $('#serial_concentrator').removeClass('is-invalid');
        //Eliminar espacios
        var serial_number= $('#serial_concentrator').val().replace(/ /g,'').toUpperCase();
        //validar campos vacios
        if(serial_number == ''){
            $('#serial_concentrator').addClass('is-invalid');
            $('#serial_concentratorError').text('Necesario');
            $("#serial_concentrator").val('');
            return false;
        }
        
        //Bucar si ya esta agregado concentrator a la lista
        var boolRepetido=false;
        $(".row-concentrator").each(function(index, value){
            var valores = $(this).find("td")[0].innerHTML;
            if(valores == serial_number){
                boolRepetido=true;
            }
        })
        if(boolRepetido){
            $("#serial_concentratorError").text('Número de serie ya agregado a esta nota');
            $("#serial_concentrator").val('');
            return false;
        }
    
        //validar si el concentrator existe.
        $.ajax({
            method: "get",
            url: "/concentrators/show_serial/"+serial_number,
        }).done(function(msg){
            if (msg == ""){// entra si no existe concentrator
                $("#serial_concentratorError").text('No existe -> Registralo antes');
                $("#serial_concentrator").val('');
            }else if(msg.status != 'ALMACEN'){
                $("#serial_concentratorError").text('Estatus -> '+ msg.status);
                $("#serial_concentrator").val('');
            } else{
                insert_row(msg); 
            }

        })
        return false;
    }

    // Insert Row Concentrator
    function insert_row(msg){
        $("#serial_concentratorError").empty();
        $('#tbody-concentrators').empty();
        $('#tbody-concentrators').append(
            "<tr class='row-concentrator'>"+
            '<td>'+msg.serial_number+'</td>'+'</td><input type="hidden" name="serial_number" value="'+msg.serial_number+'">'+
            '<td>'+msg.brand+'</td>'+
            '<td>'+msg.work_hours+'</td>'+
            '<td>'+msg.capacity+'</td>'+
            '<td>'+msg.description+'</td>'+
            "<td>"+ "<button type='button' class='btn btn-naranja' id='delete-row'><span class='fas fa-window-close'></span></button>" +"</td>"+

            "</tr>"
        );
    }

    //Validate Open Modal New Rent
    $(document).on("click","#new-rent", function (){
        $('#modal-rent').modal("show");
    });

    

    $("#day").change( () => {rent_subtotal('day'); sum_date();}); 
    $("#price_day").keyup( () => rent_subtotal('day')); 
    $("#week").change( () => {rent_subtotal('week'); sum_date();}); 
    $("#price_week").keyup( () => rent_subtotal('week')); 
    $("#mount").change( () => {rent_subtotal('mount'); sum_date();}); 
    $("#price_mount").keyup( () => rent_subtotal('mount')); 

    $("#deposit_garanty").keyup( () => rent_total()); 

    //arithmetic operations  in forms of rents 
    function rent_subtotal(time){
        const quantity_time= $("#"+time).val() == '' ? 0  : $("#"+time).val();
        const price_time= $("#price_"+time).val() == '' ? 0  : $("#price_"+time).val();
        const total = parseFloat(quantity_time) * parseFloat (price_time);
        $("#total_"+time).val(total);
        rent_total();
    }

    function rent_total(){
        const total_day=  $("#total_day").val() == '' ? 0  : $("#total_day").val();
        const total_week=  $("#total_week").val() == '' ? 0  : $("#total_week").val();
        const total_mount=  $("#total_mount").val() == '' ? 0  : $("#total_mount").val();
        const deposit_garanty=  $("#deposit_garanty").val() == '' ? 0  : $("#deposit_garanty").val();

        const total = parseFloat(total_day) + parseFloat(total_week) + parseFloat(total_mount) + parseFloat(deposit_garanty);
        const iva_general = total * 0.16;
        const subtotal =  total - iva_general;

        $('#rent_iva').val(iva_general);
        $('#rent_subtotal').val(subtotal);
        $('#rent_total').val(total);
    }

    // Change Date
    $("#date_start").change( () => { sum_date()}); 

    function sum_date() {
        var dateStartInput = document.getElementById('date_start');
        var dateEndInput = document.getElementById('date_end');
      
        var dateStart = new Date(dateStartInput.value); // get input date 'date_start'
        var sum_day = parseInt($('#day').val()); 
        var sum_week = parseInt($('#week').val()); 
        var sum_mount = parseInt($('#mount').val());
      
        var dateEnd = new Date(dateStart);
        dateEnd.setDate(dateStart.getDate() + sum_day); 
        dateEnd.setDate(dateEnd.getDate() + (sum_week * 7)); 
        dateEnd.setMonth(dateEnd.getMonth() + sum_mount);
      
        // Formatea la fecha final en el formato 'YYYY-MM-DD'
        var formattedDate = dateEnd.toISOString().substring(0, 10);
      
        // Establece el valor en el input 'date_end'
        dateEndInput.value = formattedDate;
      }
      
      
    

    //Insert Row Rents
    $(document).on("click","#insert-rent", function (){
        
        if(input_required() != true) {
            return false;
        };

        if(price_day.value == ''){price_day.value = 0};
        if(price_week.value == ''){price_week.value = 0};
        if(price_mount.value == ''){price_mount.value = 0};

        $('#modal-rent').modal("hide");
        $('#tbody-rents').empty();
        $('#tbody-rents').append(
            "<tr class='row-rent'>"+
            '<td>'+$("#day").val()+'</td><input type="hidden" name="day" value="'+$("#day").val()+'">'+
            '<td> $'+$("#price_day").val()+'</td><input type="hidden" name="price_day" value="'+$("#price_day").val()+'">'+
            '<td>'+$("#week").val()+'</td><input type="hidden" name="week" value="'+$("#week").val()+'">'+
            '<td> $'+$("#price_week").val()+'</td><input type="hidden" name="price_week" value="'+$("#price_week").val()+'">'+
            '<td>'+$("#mount").val()+'</td><input type="hidden" name="mount" value="'+$("#mount").val()+'">'+
            '<td> $'+$("#price_mount").val()+'</td><input type="hidden" name="price_mount" value="'+$("#price_mount").val()+'">'+
            '<td>'+$("#date_start").val()+'</td><input type="hidden" name="date_start" value="'+$("#date_start").val()+'">'+
            '<td>'+$("#date_end").val()+'</td><input type="hidden" name="date_end" value="'+$("#date_end").val()+'">'+
            '<td>'+$("#deposit_garanty").val()+'</td><input type="hidden" name="deposit_garanty" value="'+$("#deposit_garanty").val()+'">'+
            '<td>'+$("#rent_total").val()+'</td><input type="hidden" name="total"  id="total" value="'+$("#rent_total").val()+'">'+
            "<td>"+ "<button type='button' class='btn btn-naranja' id='delete-row'><span class='fas fa-window-close'></span></button>" +"</td>"+
            "</tr>"
        );

    });

    //Function to save note
    $(document).on("click","#save-note", function (){
        $("#id_show").removeClass('is-invalid');
        if($("#id_show").val() == ''){
            $("#id_show").addClass('is-invalid');
            mensaje('error','Error', 'No hay datos de cliente', null, null);
            return false;
        }

        //SI no hay concentrators agregados en entrada manda error
        if($('.row-concentrator').length === 0) {
            mensaje('error','Error', 'No hay registro de Concentradores', null, null);
            return false;
        }

        //SI no hay concentrators agregados en entrada manda error
        if($('.row-rent').length === 0) {
            mensaje('error','Error', 'No hay registro en seccion renta', null, null);
            return false;
        }

        const total =$("#total").val()
        const iva = total * 0.16
        const subtotal = total-iva

        $("#modal-total").text(total);
        $("#modal-iva").text(iva);
        $("#modal-subtotal").text(subtotal);
        $("#modal-pay").modal("show")
    });

    $(document).on("click","#btn-store", function (){
        if(payment_method.value == ""){
            $("#payment_method").addClass('is-invalid');
            return false;
        }
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Se guardarán todos los cambios",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Si, Continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: "/concentrator/note/store",
                    data: $("#form-note").serialize(),
                }).done(function (msg) {
                    Swal.fire(
                        'Exito',
                        'Eliminado correctamente.',
                        'success'
                    )
                    window.open('/concentrator/note/pdf/'+ msg.note_id, '_blank');
                    window.location= '/concentrator/listNote';
                }).fail(function (){
                    Swal.fire(
                        'Error',
                        'Verifica tus datos',
                        'error'
                    )
                });
            }
        });
    });



    // Function for validate inputs
    function input_required(){
        const campos = ['date_start','date_end']

        var campovacio = [];
        $.each(campos, function(index){
            $('#'+campos[index]+'Error').empty();
            $('#'+campos[index]).removeClass('is-invalid');
        });

        $.each(campos, function(index){
            if($("#"+campos[index]).val()=='' || $("#"+campos[index]).val()<=0    ){
                campovacio.push(campos[index]);
            }
        });

        if(campovacio.length != 0){
            $.each(campovacio, function(index){
                $("#"+campovacio[index]).addClass('is-invalid');
                $("#"+campovacio[index]+'Error').text('Dato necesario');
            });
            return false;
        }

        $("#day").removeClass('is-invalid');
        if( day.value <= 0 && week.value <= 0 && mount.value <= 0){ 
            $("#day").addClass('is-invalid');
            return false
        }

        return true;
    }

    //Function to send message to user
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
    //Function to delete rows
    $(document).on("click","#delete-row", function (){
        $(this).closest('tr').remove();
    });

});