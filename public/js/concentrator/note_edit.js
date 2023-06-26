$(document).ready(function () {
    // $(document).on("click","#btn-subtract-hours", function (){
    //     $('#hours-available-edit').val($("#hours-available").val());
    //     $('#type-operation-edit').val('RESTA');
        
        
    //     $('#title-modal-hours').empty();
    //     $('#title-modal-hours').append('Restar Horas');

    //     $('#modal-hours').modal("show");
    // });

    // $(document).on("click","#btn-add-hours", function (){
    //     $('#hours-available-edit').val($("#hours-available").val());
    //     $('#type-operation-edit').val('SUMA');
        
        
    //     $('#title-modal-hours').empty();
    //     $('#title-modal-hours').append('Sumar Horas');

    //     $('#modal-hours').modal("show");
    // });

     //Validate Open Modal New Rent
     $(document).on("click","#new-rent", function (){
        $('#modal-rent').modal("show");
    });

    //Insert Row Rents
    $(document).on("click","#insert-rent", function (){
        
        if(input_required() != true) {
            return false;
        };

        if(price_day.value == ''){price_day.value = 0};
        if(price_week.value == ''){price_week.value = 0};
        if(price_mount.value == ''){price_mount.value = 0};

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
                    url: "/payment/store/"+note_id.value,
                    data: $("#form-payment").serialize(),
                }).done(function (msg) {
                    Swal.fire(
                        'Exito',
                        'Eliminado correctamente.',
                        'success'
                    )
                    add_row_payment(msg);
                    $('#modal-rent').modal("hide");
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

    function add_row_payment(msg){
        $('#tbody-rents').append(
            "<tr class='row-rent'>"+
            '<td>'+msg.id+'</td>'+
            '<td>'+msg.day+'</td>'+
            '<td> $'+msg.price_day+'</td>'+
            '<td>'+msg.week+'</td>'+
            '<td> $'+msg.price_week+'</td>'+
            '<td>'+msg.mount+'</td>'+
            '<td> $'+msg.price_mount+'</td>'+
            '<td>'+msg.date_start+'</td>'+
            '<td>'+msg.date_end+'</td>'+
            '<td></td>'+
            '<td> $'+msg.deposit_garanty+'</td>'+
            '<td> $'+msg.total+'</td>'+
            '<td></td>'+
            '<td>'+msg.status+
            '</td>'+
            '<td>'+msg.user_id+'</td>'+
            '<td>'+
            '<button class="btn btn-sm btn-verde btn_paymen_edit" data-id="'+msg.id+'" data-toggle="tooltip" data-placement="top" title="Editar Pago"><i class="fas fa-money-check-alt"></i></button>'+
                '<a class="btn btn-sm btn-verde text-white" href="/payment/pdf/'+msg.id+'" target="_blank" data-toggle="tooltip" data-placement="top" title="Ver PDF"><i class="fas fa-file-pdf"></i></a>'+
                '<button class="btn btn-sm btn-verde btn_destroy_paymen" data-id="'+msg.id+'" data-toggle="tooltip" data-placement="top" title="Eliminar"><span class="fas fa-trash"></span></button>'+
           '</td>'+
            '</tr>'
        );
    }


    //Delete row Rents
    $(document).on("click",".btn_destroy_paymen", function (){
         let row=$(this).closest('tr')
         
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Se eliminara esta pago definitivamente",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Si, Continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "delete",
                    url: "/payment/destroy/"+ $(this).data('id'),
                    data: $("#form-payment").serialize(),
                }).done(function () {                   
                    row.remove();
                    Swal.fire(
                        'Exito',
                        'Eliminado correctamente.',
                        'success'
                    )
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


    //EDIT PAYMENT

    $(document).on("click",".btn_paymen_edit", function (){
        const row = this.closest('tr');
        const cell = row.getElementsByTagName('td');

        const total = cell[11].innerText.replace('$','');
        const iva = parseFloat(total) * 0.16;
        const subtotal = parseFloat(total) - iva;

        $('#payment_id').val(cell[0].innerText);
        $('#total_pay').val(total);
        $('#modal-total').text(total);
        $('#modal-iva').text(iva);
        $('#modal-subtotal').text(subtotal);

        $('#modal_pay_rent').modal("show");
    });

    $(document).on("click","#btn-pay-save", function (){
        var table = document.getElementById('tbody-rents');
        var filas = table.getElementsByTagName('tr');
        for (var i = 0; i < filas.length; i++) {
            var celda = filas[i].cells[0]; 
          
            if (celda.textContent === payment_id.value) {
              var filaDeseada = filas[i];
              break;
            }
          }


        if(payment_method.value == ''){
            message('warning', 'ERROR', 'Selecciona metodo de pago',null,null);
            return false;
        }

        if(parseFloat(effective.value) < parseFloat(total_pay.value) && payment_method.value == 'Efectivo'){
            message('warning', 'ERROR', 'Cantidad Efectivo no puede ser menor a total',null,null);
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
                    url: "/payment/update_pay/"+payment_id.value,
                    data: $("#form_update_payment").serialize(),
                }).done(function (msg) {
                    Swal.fire(
                        msg.title,
                        msg.message,
                        msg.type
                    )
                    if (msg.type =='success') {
                        clear_modal_pay()
                        $('#modal_pay_rent').modal("hide");
                        filaDeseada.cells[13].textContent = 'PAGADO';
                    }
                    
                }).fail(function (){
                    Swal.fire(
                        'Error',
                        'Verifica tus datos',
                        'error'
                    )
                });
            }
        });
    })

    function clear_modal_pay(){
        $('#payment_id').val("");
        $('#total_pay').val("");
        $('#payment_method').val("");
        $('#effective').val("");
        $('#change').val("");
        $('#modal-total').empty();
        $('#modal-iva').empty();
        $('#modal-subtotal').empty();
    }

    //Function to send message to user
    function message(icono,titulo, mensaje, timer, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: timer,
            width: 300,
        })
    }

    //RETURN CONCENTRATOR

    $(document).on("click","#btn-save-return", function (){
        if(hours_works_consumed.value <= 0 || hours_works_consumed.value== "" ){
            message('error','Error','El Campo Horas Consumidas no debe de estar vacío');
            return false;
        }
        $.ajax({
            method: "post",
            url: "/concentrator/note/return_concentrator/"+$("#note_id").val(),
            data: $("#form-return-concentrator").serialize(),
        }).done(function (msg) {
            $('#modal_return_concentrator').modal("hide");
            Swal.fire(
                'Exito',
                'Eliminado correctamente.',
                'success'
            )
            add_row_return(msg);
        }).fail(function (){
            Swal.fire(
                'Error',
                'Verifica tus datos',
                'error'
            )
        });
    });


    function add_row_return(msg){
        console.log(msg);
        $('#tbody_return_concentrator').empty();
        $('#tbody_return_concentrator').append(
            '<tr class="row-rent">'+
                '<td>'+msg.concentrator+'</td>'+
                '<td>'+msg.note_id.return_concentrator+'</td>'+
                '<td>'+msg.note_id.hours_works_consumed+'</td>'+
            '</tr>'
        );
    }

    //close note
    $(document).on("click","#btn_close_note", function (){
        if(close_note.value == "" ){
            message('warning','Error','Debes selccionar al menos una opción');
            return false;
        }
        if (close_note.value == "CERRADA") {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "Después de cerrar nota no podrás hacer cambios dentro de esta nota.",
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
                        url: "/concentrator/note/close/"+ $("#note_id").val(),
                        data: $("#form-payment").serialize(),
                    }).done(function () {                   
                        Swal.fire(
                            'Exito',
                            'Eliminado correctamente.',
                            'success'
                        )
                        window.location.reload()
                    }).fail(function (){
                        Swal.fire(
                            'Error',
                            'Verifica tus datos',
                            'error'
                        )
                    });
                }
            });
        }

        

    });

    //disabled elements
    disabled_elements();

    function disabled_elements(){
        if(close_note.value == 'CERRADA'){
            $("#new-rent").prop("disabled", true);
            $(".disabled_element").prop("disabled", true);
            $("#btn_close_note").prop("disabled", true);
            $("#close_note").prop("disabled", true);
        }
    }
});