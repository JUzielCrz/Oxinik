$(document).ready(function () {

    // Data Tables
    var listtabla = $('#tablecruddata').DataTable({
        "ordering": true,
        "order": [[ 0, 'desc' ]],
        language: {"url": "/js/language_dt_spanish.json"},
        processing: true,
        serverSider: true,
        ajax: '/nota/reserva/data',
        columns:[
            {data: 'id'},   
            {data: 'created_at'},
            {data: 'incidencia'},
            {data: 'driver'},
            {data: 'car'},
            {data: 'buttons'},
            
        ]
    });

    // $(document).on("click","#btnEliminarFila", eliminarFila);
    
    $(document).on("click",".btn-delete", nota_delete);
    $(document).on("click","#refresh-table", refresh_table);


    // function eliminarFila(){
    //     $(this).closest('tr').remove();
    // }

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

    function nota_delete(){
        var estatus
        if($(this).parents("tr").find("td")[3].innerHTML == "SALIDA"){
            estatus="LLENO-ALMACEN";
        }else{
            estatus="TANQUE-RESERVA";
        }

        Swal.fire({
            title: 'ELIMINAR',
            text: "Al eliminar esta nota los tanques cambiaran de estatus a "+estatus,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#2F4858',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Continuar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get('/nota/reserva/delete/' + $(this).data('id'), function(msg) { 
                    mensaje("success","EXITO", "Eliminado Correctamente", "1000", null)
                    listtabla.ajax.reload(null,false);
                });
            }
        })
    }

    function refresh_table(){
        listtabla.ajax.reload(null,false);
    }
});
