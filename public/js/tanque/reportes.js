$(document).ready(function () {
    
    $(document).on("click","#btn-save-reporte", save_reporte);
    $(document).on("click","#btn-cancelar",cancelar);
    $(document).on("click",".btn-eliminar", eliminar_reporte);

    // Data Tables
        var listtabla = $('#tablecruddata').DataTable({
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
            ajax: '/tanque/reportados/data',
            columns:[
                {data: 'reporte_id'},
                {data: 'num_serie'},
                {data: 'descripcion'},
                {data: 'estatus'},
                {data: 'observaciones'},
                {data: 'btnHistory'},
                {data: 'btbEliminar'},
            ]
        });

    function save_reporte() {

        var campo= [
            'num_serie',
            'observaciones',];
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
            mensaje('error','Error','Faltan campos por rellenar', null);
            return false;
        }
        var numserie= $('#num_serie').val().replace(/ /g,'');


        $.ajax({
            method: "POST",
            url: "/tanque/reportados/save",
            data: {
                '_token': $('input[name=_token]').val(),
                'num_serie': numserie,
                'observaciones': $("#observaciones").val(),
                }
        }).done(function (msg) {
            if(msg.mensaje == true){
                mensaje('success','Exito','Registrado correctamente', 1000);
                window.location = '/tanque/reportados';
            }else{
                mensaje('error','Error','Este tanque no existe, debes registrarlo primero', null);
            }
        }).fail(function (jqXHR, textStatus){
            mensaje('error','Error','ocurrio un error, puede que ya este reportado este cilindro', null);
        }); 


    }

    function mensaje(icono,titulo, mensaje, timer){
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: timer,
            width: 300,
        })
    }
    function eliminar_reporte() {
        Swal.fire({
            title: 'Elimar reporte',
            html: "<span>El reporte se eliminara y el tanque se restablecera con estatus: VACIO-ALMACEN <br> ¿Estas seguro de continuar?</span>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Continuar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "get",
                    url: "/tanque/reportados/eliminar/"+$(this).data('id'),
                }).done(function(msg){
                    if(msg){
                        mensaje('success','Exito','Eliminado Correctamente', 1500);
                        listtabla.ajax.reload(null,false); 
                    }else{
                        mensaje('error','Error','Ocurrio un error', null);
                    }
                })
            }
        })
        
    }

    function cancelar() {
        Swal.fire({
            title: 'CANCELAR',
            text: "¿Estas seguro de cancelar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Continuar!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = '/tanque/reportados';
            }
        })
        
    }
});