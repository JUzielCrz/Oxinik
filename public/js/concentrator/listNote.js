

$(document).ready(function () {

    // $(document).on("click",".btn-cancelar", cancelar);


    var listtabla = $('#table-data').DataTable({
        language: {"url": "/js/language_dt_spanish.json"},
        processing: true,
        serverSider: true,
        ajax: '/concentrator/listNote/data',
        columns: 
        [
            {data: 'id'},
            {data: 'name'},
            {data: 'created_at'},
            {data: 'phone_number'},
            {data: 'status'},
            {data: 'user_name'},
            {data: 'buttons'},
        ]
            
    });
    
    // function cancelar() {
    //     console.log('pass');
    //     Swal.fire({
    //         title: '¿Estas seguro?',
    //         text: "Se cambiaran los estatus de los cilindros a LLENO-ALMACEN",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#F9C846',
    //         cancelButtonColor: '#329F5B',
    //         confirmButtonText: 'Si, eliminar!',
    //         cancelButtonText: 'Cancelar'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 method: "get",
    //                 url: "/nota/exporadica/cancelar/"+$(this).data('id'),
    //             }).done(function (msg) {
    //                 if(msg.mensaje == 'Sin permisos'){
    //                     mensaje("error","Sin permisos", "No tienes los permisos suficientes para hacer este cambio", null, null);
    //                     return false;
    //                 }
    //                 Swal.fire(
    //                     'Exito',
    //                     'Eliminado correctamente.',
    //                     'success'
    //                 )
    //                 listtabla.ajax.reload(null,false);
    //             }).fail(function (){
    //                 Swal.fire(
    //                     'Error',
    //                     'Verifica tus datos',
    //                     'error'
    //                 )
    //             });
    //         }
    //     })
    // }
});
