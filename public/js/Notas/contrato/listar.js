

$(document).ready(function () {
    

    
    $(document).on("click","#btn-entradas", entradas);
    $(document).on("click","#btn-salidas", salidas);
    // $(document).on("click","#btn-exporadicas", exporadicas);
    $(document).on("click","#btn-adeudos", adeudos);

    $(document).on("click",".btn-cancelar-salida", cancelar_salida);

    salidas();
    
    function entradas(){
        var titulo_table="Notas Entradas"; 
        var titulo_columnas=
            "<thead><tr>"+
                "<th>ID</th>"+
                "<th>#CONTRATO</th>"+
                "<th>FECHA</th>"+
                "<th>METODO DE PAGO</th>"+
                "<th>RECARGOS</th>"+
                "<th>OBSERVACIONES</th>"+
                "<th>USUARIO</th>"+
                "<th></th>"+
            "</tr></thead>";
        var contenido_columnas=
            [{data: 'nota_id'},
            {data: 'num_contrato'},
            {data: 'fecha'},
            {data: 'metodo_pago'},
            {data: 'recargos'},
            {data: 'observaciones'},
            {data: 'user_name'},
            {data: 'btnNota'}
        ];
            
        var link_data="/nota/contrato/listar/entradas/data";
        
        insertar_tabla(titulo_table,titulo_columnas,contenido_columnas, link_data);
    }
    function salidas(){
        var titulo_table="Notas Salidas"; 
        var titulo_columnas=
            "<thead><tr>"+
                "<th>ID</th>"+
                "<th>#CONTRATO</th>"+
                "<th>FECHA</th>"+
                "<th>PAGO CUBIERTO</th>"+
                "<th>ESTATUS</th>"+
                "<th>USUARIO</th>"+
                "<th></th>"+
                "<th></th>"+
                "<th></th>"+
            "</tr></thead>";
        var contenido_columnas=
            [
                {data: 'nota_id'},
                {data: 'num_contrato'},
                {data: 'fecha'},
                {data: 'pago_cubierto'},
                {data: 'estatus'},    
                {data: 'user_name'},
                {data: 'btnShow'},
                {data: 'btnNota'},
                {data: 'btnCancelar'},
            ];
            
        var link_data="/nota/contrato/listar/salidas/data";
        
        insertar_tabla(titulo_table,titulo_columnas,contenido_columnas, link_data);
    }

    function adeudos(){
        var titulo_table="Notas Sin Liquidar"; 
        var titulo_columnas=
            "<thead><tr>"+
                "<th>ID</th>"+
                "<th>#CONTRATO</th>"+
                "<th>FECHA</th>"+
                "<th>PAGO CUBIERTO</th>"+
                "<th>OBSERVACIONES</th>"+
                "<th>USUARIO</th>"+
                "<th>VER</th>"+
                "<th>NOTA</th>"+
            "</tr></thead>";
        var contenido_columnas=
            [{data: 'nota_id'},
            {data: 'num_contrato'},
            {data: 'fecha'},
            {data: 'pago_cubierto'},
            {data: 'observaciones'},
            {data: 'user_name'},
            {data: 'btnShow'},
            {data: 'btnNota'}];
        var link_data="/nota/contrato/listar/adeudos/data";
        
        insertar_tabla(titulo_table,titulo_columnas,contenido_columnas, link_data);
    }


    // function exporadicas(){
    //     var titulo_table="Notas Ventas Exporadicas"; 
    //     var titulo_columnas=
    //         "<thead><tr>"+
    //             "<th>ID</th>"+
    //             "<th>CLIENTE</th>"+
    //             "<th>FECHA</th>"+
    //             "<th>TELEFONO</th>"+
    //             "<th>TOTAL</th>"+
    //             "<th>USUARIO</th>"+
    //             "<th></th>"+
    //         "</tr></thead>";
    //     var contenido_columnas=
    //         [{data: 'id'},
    //         {data: 'nombre_cliente'},
    //         {data: 'fecha'},
    //         {data: 'telefono'},
    //         {data: 'total'},
    //         {data: 'user_name'},
    //         {data: 'btnNota'}];
    //     var link_data="/nota/listar/exporadica/data";
        
    //     insertar_tabla(titulo_table,titulo_columnas,contenido_columnas, link_data);
    // }


    function insertar_tabla(titulo_table, titulo_columnas,contenido_columnas, link_data){
        
        $("#titulo-table").replaceWith("<h5 id='titulo-table'>"+titulo_table+"</h5>")
        $("#insert-table").empty();
        $("#insert-table").append(
            '<div class="table-responsive">'+
                '<table class="table table-hover table-sm" id="table-data" style="font-size: 13px">'+
                    titulo_columnas+
                '</table>'+
            '</div>'
        );

        // Data Tables
        var listtabla = $('#table-data').DataTable({
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
            ajax: link_data,
            columns: contenido_columnas
            
        });
    }
    
    function cancelar_salida() {
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Se cambiaran los estatus de los cilindros a llenos en almacen",
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
                    url: "/nota/contrato/salida/cancelar/"+$(this).data('id'),
                }).done(function (msg) {
                    if(msg.mensaje == 'Sin permisos'){
                        mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
                        return false;
                    }
                    Swal.fire(
                        'Exito',
                        'Eliminado correctamente.',
                        'success'
                    )
                    listtabla.ajax.reload(null,false);
                }).fail(function (){
                    Swal.fire(
                        'Error',
                        'Verifica tus datos',
                        'error'
                    )
                });
            }
        })
    }
});
