$(document).ready(function () {

    var table = $('#table-data').DataTable({
        language: {"url": "/js/language_dt_spanish.json"},
        processing: true,
        serverSider: true,
        ajax: '/concentratorsMaintenance/data',
        columns: 
        [
            {data: 'id'},
            {data: 'serial_number'},
            {data: 'status'},
            {data: 'created_at'},
            {data: 'date_return'},
            {data: 'user_name'},
            {data: 'buttons'},
        ]
            
    });

    $(document).on("click","#btn_add", function (){
        $("#modal_add").modal('show');
    });

    $(document).on("click","#btn_save", function (){
        $.ajax({
            method: "POST",
            url: '/concentratorsMaintenance/store',
            data: $("#form-data").serialize(),
        }).done(function () {
            $("#modal_add").modal("hide");
            Swal.fire(
                'Exito!',
                'Guardado correctamente.',
                'success'
            )
            table.ajax.reload(null,false); 
        }).fail(function (){
            Swal.fire(
                'Error',
                'Verifica tus datos',
                'error'
            )
        })
    });
    $(document).on("click",".btn_destroy", function() {
        const selectname = table.row( ':eq(0)' ).data().id;
        console.log(selectname)
        
            Swal.fire({
                title: 'Estas seguro de eliminar Registro: '+selectname+'?',
                text: 'Se eliminará y no podrá revertirse además se modificará el estatus del concentrador a: "ALMACEN"',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F9C846',
                cancelButtonColor: '#329F5B',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "get",
                        url: "/concentratorsMaintenance/destroy/"+$(this).data('id'),
                    }).done(function () {
                    Swal.fire(
                        'Eliminado!',
                        'Eliminado correctamente.',
                        'success'
                    )
                    table.ajax.reload(null,false);
                    })
                }
            })
    });

    $(document).on("click",".btn_return_maintenance", function(){
        $.get("/concentratorsMaintenance/edit/"+$(this).data('id'), function(data) {
            $.each(data, function (key, value) {
                var variable = "#" + key +"_edit";
                $(variable).val(value);
            });
            if(data.status == 'OK'){
                $("#status_edit").prop("disabled", true);
                $("#observations_edit").prop("disabled", true);
                $("#work_hours_edit").prop("disabled", true);
            }
        })
        $('#modal_return').modal('show')
    });

    $(document).on("click","#btn_update", function (){
        $.ajax({
            method: "POST",
            url: '/concentratorsMaintenance/update/'+id_edit.value,
            data: $("#form-return-edit").serialize(),
        }).done(function () {
            $("#modal_return").modal("hide");
            Swal.fire(
                'Exito!',
                'Guardado correctamente.',
                'success'
            )
            table.ajax.reload(null,false); 
        }).fail(function (){
            Swal.fire(
                'Error',
                'Verifica tus datos',
                'error'
            )
        })
    });

    

    
});