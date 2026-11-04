$(document).ready(function () {

    // Data Tables
    var listtabla = $('#tablecruddata').DataTable({
        "ordering": true,
        "order": [[ 0, 'desc' ]],
        language: {"url": "/js/language_dt_spanish.json"},
        processing: true,
        serverSide: false,
        ajax: '/nota/reserva/data',
        columns:[
            {data: 'id'},   
            {data: 'created_at'},
            {data: 'incidencia'},
            {data: 'driver'},
            {data: 'car'},
            {data: 'buttons', orderable: false, searchable: false, className: 'text-center'},
            
        ]
    });

    // $(document).on("click","#btnEliminarFila", eliminarFila);
    
    $(document).on("click",".btn-delete", nota_delete);
    $(document).on("click","#refresh-table", refresh_table);
    $(document).on("change", "#filtro-incidencia", function () {
        listtabla.column(2).search(this.value).draw();
    });
    $(document).on("click", "#btn-limpiar-reserva", function () {
        $("#filtro-incidencia").val("");
        listtabla.search("").columns().search("").draw();
    });


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
        var button = $(this);
        var incidencia = button.data('incidencia');
        var estatus = incidencia === "SALIDA" ? "LLENO-ALMACEN" : "TANQUE-RESERVA";

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
                $.get('/nota/reserva/delete/' + button.data('id'), function(msg) {
                    mensaje("success","EXITO", "Eliminado Correctamente", "1000", null)
                    listtabla.ajax.reload(null,false);
                }).fail(function () {
                    mensaje("error", "Error", "No fue posible eliminar la nota.", null, null);
                });
            }
        })
    }

    function refresh_table(){
        listtabla.ajax.reload(null,false);
    }
});
