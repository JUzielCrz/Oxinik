$(document).ready(function () {
    $(document).on("click","#btn_add", function(){
        $("#modal_title").replaceWith('<h5 id="modal_title">Agregar</h5>')
        $("#modal_driver").modal("show");
    });
    $(document).on("click",".btn_modal_driver", show);
    $(document).on("click","#btn_save", function (){
        if($("#id").val() == "" ){
            save_tank("POST", "drivers")
        }else{
            var link = "drivers/" + $("#id").val()
            save_tank("PUT", link)
        }
    });

    // Data Tables
        var listtabla = $('#tablecruddata').DataTable({
            language: {"url": "js/language_dt_spanish.json"},
            processing: true,
            serverSider: true,
            ajax: '/drivers/table/data',
            columns:[
                {data: 'id'},
                {data: 'apellido'},
                {data: 'nombre'},
                {data: 'licencia_tipo'},
                {data: 'licencia_numero'},
                {data: 'btnEdit'},
            ]
        });

    function show() {
        clean_inputs();
        $.get('/drivers/' + $(this).data('id'), function(data) {
            $.each(data, function (key, value) {
                var variable = "#" + key;
                $(variable).val(value);
            });
            $("#modal_title").replaceWith('<h5 id="modal_title">Editar</h5>')
            $("#modal_driver").modal("show");
        })
    }


    function save_tank(method, link) {
        var arr_input =['name','last_name']
        if(valid_input_required(arr_input)){
            $.ajax({
                method: method,
                url: link,
                data: $("#form_driver").serialize(),
            })
            .done(function (msg) {
                listtabla.ajax.reload(null,false);
                mensaje(msg.type_alert, msg.alert_type, "Los datos se guardaron correctamente", "#modal_driver");
            })
            return false;
        }
        return false
    }

    function valid_input_required(inputs){
        var campovacio = [];
        $.each(inputs, function(index){
            $('#'+inputs[index]+'Error').empty();
            $('#'+inputs[index]).removeClass('is-invalid');
        });

        $.each(inputs, function(index){
            if($("#"+inputs[index]).val()=='' || $("#"+inputs[index]).val()<=0    ){
                campovacio.push(inputs[index]);
            }
        });

        if(campovacio.length != 0){
            $.each(campovacio, function(index){
                $("#"+campovacio[index]).addClass('is-invalid');
                $("#"+campovacio[index]+'Error').text('Necesario');
            });
            return false;
        }
        return true;
    }

    function clean_inputs() {
        $("#apellido").val("");
        $("#nombre").val("");
        $("#licencia_tipo").val("");
        $("#licencia_numero").val("");
        $("#apellidoError").empty();
        $("#nombreError").empty();
        $("#licencia_tipoError").empty();
        $("#licencia_numeroError").empty();
    }

    function mensaje(icono,titulo, mensaje, modal){
        $(modal).modal("hide");
        Swal.fire({
            icon: icono,
            title: titulo,
            text: mensaje,
            timer: 1800,
            width: 300,
        })
    }

});