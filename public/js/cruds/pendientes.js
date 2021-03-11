

$(document).ready(function () {
    

    
    $(document).on("click","#btn-info-nota", mostrar_nota);

    $('#pendienteselect').change(function(){


        if($('#pendienteselect').val()=='pendiente-pagos'){
            $('#filatabla').remove();
            $('#cardtablas').append(
                "<div id='filatabla'>"+
                    "<div class='row table-responsive ml-1' >"+ 
                        "<table id='tablecruddata' class='table table-sm table-striped table-hover'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th scope='col'>"+'#Folio Nota'+"</th>"+
                                    "<th scope='col'>"+'Fecha'+"</th>"+
                                    "<th scope='col'>"+'#Contrato'+"</th>"+
                                    "<th scope='col'>"+'Total'+"</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody id='tbodycontenido'></tbody>"+
                        "</table>"+
                    "</div>"+
                "</div>"
            );

            $.ajax({
                method: "GET",
                url: "pendientepago",
                
            }).done(function(msg){
                $.each(msg.notas, function(index, value){
                $('#tbodycontenido').append(
                    
                        "<tr>"+
                        "<td><button typer='button' class='btn btn-link' id='btn-info-nota' data-id='"+value.folio_nota+"'>"+value.folio_nota+"</button></td>"+
                        "<td>"+value.fecha+"</td>"+
                        "<td>"+value.num_contrato+"</td>"+
                        "<td>"+value.total+"</td>"+
                        "</tr>"
                    );
                })

            });

        }

        if($('#pendienteselect').val()=='pendiente-tanques'){
            $('#filatabla').remove();
            $('#cardtablas').append(
                "<div id='filatabla'>"+
                    "<div class='row table-responsive ml-1' >"+ 
                        "<table id='tablecruddata' class='table table-sm table-striped table-hover'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th scope='col'>"+'#Serie'+"</th>"+
                                    "<th scope='col'>"+'Estatus'+"</th>"+
                                    "<th scope='col'>"+'#Nota'+"</th>"+
                                    "<th scope='col'>"+'Fecha'+"</th>"+
                                    "<th scope='col'>"+'Historial'+"</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody id='tbodycontenido'></tbody>"+
                        "</table>"+
                    "</div>"+
                "</div>"
            );

            $.ajax({
                method: "GET",
                url: "pendientetanques",
                
            }).done(function(msg){
                
                $.each(msg.tanques, function(index, value){
                    
                $('#tbodycontenido').append(
                    
                        "<tr>"+ 
                        "<td>"+value.num_serie+"</td>"+
                        "<td>"+value.estatus+"</td>"+
                        "<td>"+value.folioNota+"</td>"+
                        "<td>"+value.nota_fecha+"</td>"+
                        "<td>"+"<a type='button' class='btn btn-link' href='/historytanque/"+value.idtanque+"'>Historial</a>"+"</td>"+
                        "</tr>"
                    );
                })

            });

        }
    });



    function mostrar_nota(){
        limpiarmodal();
        console.log($(this).data('id'));
        $.get('/shownota/' + $(this).data('id'), function(data) {
            
            $.each(data.nota, function (key, value) {
                var variable = "#" + key;
                $(variable).val(value);
            });
            
            $.each(data.notatanque, function (key, value) {
                $("#tbodylisttanqinfo").append(
                    "<tr class='trmodalnota'>"+
                    "<td>"+value.num_serie+"</td>"+
                    "<td>"+value.ph+ value.material+value.capacidad+"</td>"+
                    "<td>"+value.precio+"</td>"+
                    "<td>"+value.regulador+"</td>"+
                    "<td>"+value.tapa_tanque+"</td>"+
                    "</tr>"
                );
            })
            

        }).done(function () {
            $("#modal-info-nota").modal("show");
        });;
    }

    function limpiarmodal(){
        $('#folio_nota').val('');
        $('#fecha').val('');
        $('#pago_realizado').val('');
        $('#metodo_pago').val('');
        $(".trmodalnota").remove();
    }


    function metodo_detalle() {
        $.get('/shownota/' + $('#get-serie-number').val(), function(data) {
            $.each(data.notas, function (key, value) {
                var variable = "#" + key;
                $(variable).val(value);
            });
        }).done(function (msg) {
            if(msg.accesso){
                mostrar_mensaje("#divmsgindex",msg.mensaje, "alert-warning",null);
            }else{
                $("#modal-info-nota").modal("show");
            }
        });;
        
    }

});
