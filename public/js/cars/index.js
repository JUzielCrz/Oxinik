$(document).ready(function () {
    $(document).on("click","#btn_add", function(){
        $("#modal_title").replaceWith('<h5 id="modal_title">Agregar</h5>')
        $("#modal_car").modal("show");
    });
    $(document).on("click",".btn_modal_car", show);
    $(document).on("click","#btn_save", function (){
        if($("#id").val() == "" ){
            save_tank("POST", "cars")
        }else{
            var link = "cars/" + $("#id").val()
            save_tank("PUT", link)
        }
    });

    // Data Tables
        var listtabla = $('#tablecruddata').DataTable({
            language: {"url": "js/language_dt_spanish.json"},
            processing: true,
            serverSider: true,
            ajax: '/cars/table/data',
            columns:[
                {data: 'id'},
                {data: 'nombre'},
                {data: 'modelo'},
                {data: 'marca'},
                {data: 'placa'},
                {data: 'btnEdit'},
            ]
        });

    function show() {
        clean_inputs();
        $.get('/cars/' + $(this).data('id'), function(data) {
            $.each(data, function (key, value) {
                var variable = "#" + key;
                $(variable).val(value);
            });
            $("#modal_title").replaceWith('<h5 id="modal_title">Editar</h5>')
            $("#modal_car").modal("show");
        })
    }


    function save_tank(method, link) {
        var arr_input =['nombre','modelo', 'kilometraje']
        if(valid_input_required(arr_input)){
            $.ajax({
                method: method,
                url: link,
                data: $("#form_car").serialize(),
            })
            .done(function (msg) {
                listtabla.ajax.reload(null,false);
                mensaje(msg.type_alert, msg.alert_type, "Los datos se guardaron correctamente", "#modal_car");
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
        $("#modelo").val("");
        $("#kilometraje").val("");
        $("#nombre").val("");
        $("#nombreError").empty();
        $("#kilometrajeError").empty();
        $("#modeloError").empty();
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