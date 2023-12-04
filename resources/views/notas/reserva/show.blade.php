<div class="row">
    <div class="col">
        <h5 id="nota_id"></h5>
        <p>
            <span id="span-incidencia"></span> <br>
            <span id="span-user"></span><br>
            <span id="span-driver"></span>
            <span id="span-car"></span>
        </p>
    </div>
</div>
<hr>
<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
        <thead>
            <tr style="font-size: 13px">
                <th scope="col">#SERIE</th>
                <th scope="col">DESCRIPCIÓN</th>
            </tr>
        </thead>
        <tbody id="tbody-reserva-show" style="font-size: 13px">
            
        </tbody>
    </table>
</div>

<script>
    $(document).on("click",".btn-show", function(){
        $("#tbody-reserva-show").empty();
        $.get('/nota/reserva/show/' + $(this).data('id'), function(msg) { 
            $("#modal-show").modal("show");
            $("#nota_id").replaceWith("<h5 id='nota_id'>Nota id: "+msg.nota.id+"</h5>");
            $("#span-incidencia").replaceWith('<span id="span-incidencia">Incidencia: '+msg.nota.incidencia+'</span>');
            $("#span-user").replaceWith('<span id="span-user">Usuario: '+msg.user_name+'</span>');
            $("#span-driver").replaceWith('<span id="span-driver">Chofer: '+msg.nota.driver+'</span>');
            $("#span-car").replaceWith('<span id="span-car">Automóvil: '+msg.nota.car+'</span>');
            $.each(msg.tanques, function (key, value) {
                $("#tbody-reserva-show").append(
                    "<tr><td>"+value.num_serie+"</td><td>"+value.tipo_gas+", "+value.capacidad+", "+value.material+", "+value.fabricante+", "+value.nombre+", "+value.tipo_tanque+", PH: "+value.ph +"</td></tr>"
                );
            });
        });
    });
</script>