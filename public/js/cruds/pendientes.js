

$(document).ready(function () {
    


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
                        "<td>"+value.folio_nota+"</td>"+
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
                        "<td>"+"<button type='button' class='btn btn-link'>Historial</button>"+"</td>"+
                        "</tr>"
                    );
                })

            });

        }
    });

});
