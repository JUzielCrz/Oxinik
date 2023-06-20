$(document).ready(function () {
    $(document).on("click","#btn-subtract-hours", function (){
        $('#hours-available-edit').val($("#hours-available").val());
        $('#type-operation-edit').val('RESTA');
        
        
        $('#title-modal-hours').empty();
        $('#title-modal-hours').append('Restar Horas');

        $('#modal-hours').modal("show");
    });

    $(document).on("click","#btn-add-hours", function (){
        $('#hours-available-edit').val($("#hours-available").val());
        $('#type-operation-edit').val('SUMA');
        
        
        $('#title-modal-hours').empty();
        $('#title-modal-hours').append('Sumar Horas');

        $('#modal-hours').modal("show");
    });

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
        console.log(msg)
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
            '<td> $'+msg.deposit_garanty+'</td>'+
            '<td> $'+msg.total+'</td>'+
            '<td></td>'+
            '<td>'+msg.status+'</td>'+
            '<td>'+msg.user_id+'</td>'+
            '<td>'+
                '<a class="btn btn-sm btn-verde text-white" href="/payment/pdf/'+msg.id+'" target="_blank" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class="fas fa-file-pdf"></i></a>'+
                '<button class="btn btn-sm btn-verde" data-id="'+msg.id+'" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><span class="fas fa-trash"></span></button>'+
           '</td>'+
            '</tr>'
        );
    }


    //Delete row Rents
    $(document).on("click",".btn_destroy_paymen", function (){


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
                    console.log($(this).closest('tr'));
                    $(this).closest('tr').remove();

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
});