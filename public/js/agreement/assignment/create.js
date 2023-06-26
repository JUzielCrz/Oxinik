$(document).ready(function () {
    
    $(document).on("click","#insert_assignment", insert_assignment);
    $(document).on("click","#delete_line", delete_line);



    function insert_assignment(){
        var arr_input =['tank_number','gas_type','tank_type','material_type','capacity','unit_measurement', 'price', 'unit_guarantee_deposit']
        var guarantee = $("#unit_guarantee_deposit").val() *  $("#tank_number").val();
        if(validate_inputs(arr_input)){
            $("#line_assignment").append(
                '<tr>'+
                    '<td><button type="button" class="btn-amarillo ml-1  " id="delete_line"><span class="fas fa-minus"></span></button></td>'+
                    '<td>'+$("#tank_number").val()+'</td><input value="'+$("#tank_number").val()+'" type="number" name="tank_number[]" disabled></td>'+
                    '<td>'+$("#gas_type").val()+'</td><input value="'+$("#gas_type").val()+'" type="number" name="gas_type[]" disabled></td>'+
                    '<td>'+$("#tank_type").val()+'</td><input value="'+$("#tank_type").val()+'" type="number" name="tank_type[]" disabled></td>'+
                    '<td>'+$("#material_type").val()+'</td><input value="'+$("#material_type").val()+'" type="number" name="material_type[]" disabled></td>'+
                    '<td>'+$("#capacity").val()+'</td><input value="'+$("#capacity").val()+'" type="number" name="capacity[]" disabled></td>'+
                    '<td>'+$("#unit_measurement").val()+'</td><input value="'+$("#unit_measurement").val()+'" type="number" name="unit_measurement[]" disabled></td>'+
                    '<td>'+$("#price").val()+'</td><input value="'+$("#price").val()+'" type="number" name="price[]" disabled></td>'+
                    '<td>'+$("#unit_guarantee_deposit").val()+'</td><input value="'+$("#unit_guarantee_deposit").val()+'" type="number" name="unit_guarantee_deposit[]" disabled></td>'+
                    '<td>'+guarantee+'</td><input value="'+guarantee+'" type="number" name="guarantee_deposit[]" disabled></td>'+
                '</tr>'
            );
            $("#modal_assignments").modal("hide")
            clean_inputs(arr_input);
        }
        
    }

    function validate_inputs(inputs){
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

    function clean_inputs(inputs){ //Math.PI > 4 ? "Sip" : "Nop";
        $.each(inputs, function(index){
            inputs[index] != "tank_type" ? $('#'+inputs[index]).val(""):true;
        });
    }

    function delete_line(){
        $(this).closest('tr').remove();
    }

    $("#agreement_type").change( function() {
        $("#line_assignment").empty()
        if($("#agreement_type").val() == "Eventual"){
            $("#tank_type").prop("disabled", false);
        }else{
            $("#tank_type").val($("#agreement_type").val());
            $("#tank_type").prop("disabled", true);
            
        }  
    });
    
});