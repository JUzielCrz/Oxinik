$(document).ready(function () {

    // Data Tables
    var listtabla = $('#tablecruddata').DataTable({
        "ordering": true,
        "order": [[ 0, 'desc' ]],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
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

    $(document).on("click","#btnEliminarFila", eliminarFila);
    
    $(document).on("click",".btn-delete", nota_delete);
    $(document).on("click","#refresh-table", refresh_table);

    $('#serie_tanque').keypress(function (event) {
        // console.log(event.charCode);
        if (event.charCode == 13 ){
            event.preventDefault();
            insertar_cilindro();
        } 
    });

    function eliminarFila(){
        $(this).closest('tr').remove();
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
