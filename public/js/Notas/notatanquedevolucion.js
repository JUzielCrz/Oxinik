// $(document).ready(function () {


//     $(document).on("click","#btnGuardar", insertnota);
//     $(document).on("click","#btnCancelar", cancelardevolucion);

//     $(document).on("click","#btnModalDevolucion", modalDevolucion);
//     $(document).on("click","#btnInsertFila", insertFila);
//     $(document).on("click","#btnEliminarFila", eliminarFila);
    
//     $(document).on("click","#btnInsertFilaRegtanque", insertFilaRegTanque);
    





//     function modalDevolucion(){
//         $('#serie_tanqueError').empty();
//         if($('#serie_tanque').val() == ''){
//             $('#serie_tanqueError').text('Campo número de serie necesario');
//             return false;
//         }

//         var boolRepetido=false;
//         $(".classfilasdevolucion").each(function(index, value){
//             var valores = $(this).find("td")[0].innerHTML;
//             if(valores == $('#serie_tanque').val()){
//                 boolRepetido=true;
//             }
//         })

//         if(boolRepetido){
//             $("#serie_tanqueError").text('Número de serie ya agregado a devoluciones');
//                 return false;
//         }

//         var boolEncontrado;
//         $(".classfilatanque").each(function(){
//             var valores = $(this).find("td")[0].innerHTML;
//             if(valores == $('#serie_tanque').val()){
//                 boolEncontrado=true;
//             }
//         })
        
//         if (boolEncontrado) {
//             $(".classfilatanque").each(function(){

//                 if($(this).find("td")[0].innerHTML == $('#serie_tanque').val()){
//                     $('#serie_modal').val($(this).find("td")[0].innerHTML);
//                     $('#descripcion').val($(this).find("td")[1].innerHTML.trim());
//                     $('#regulador').val($(this).find("td")[3].innerHTML.trim());
//                     $('#tapa_tanque').val($(this).find("td")[4].innerHTML.trim());
//                 }
//             })
//             $('#modaldevolucion1').modal("show");
//         } else {
//             $('#num_seriefila').val($('#serie_tanque').val());
//             $('#modaldevolucion2').modal("show");
//         }
//     }
    
//     function insertFila(){
        
//         limpiar_span_modal1("Error");

//         var campo= [];
//         var texterror = [];

//         if($('#serie_modal').val() == ''){
//             campo.push('#serie_modal');
//             texterror.push('Número de serie necesario');
//         }
//         if($('#tapa_tanque').val() == ''){
//             campo.push('#tapa_tanque');
//             texterror.push('Tapa tanque de serie necesario');
//         }
//         if($('#regulador').val() == ''){
//             campo.push('#regulador');
//             texterror.push('Regulador de serie necesario');
//         }

//         if(campo.length != 0){
//             $.each(campo, function(index){
//                 $(campo[index]+'Error').text(texterror[index]);
//             });
//             return false;
//         }

//         $('#filadevolucion').append(
//             "<tr class='classfilasdevolucion'>"+
//             "<td>"+$('#serie_modal').val() +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+$('#serie_modal').val() +"'></input>"+
//             "<td>"+$('#descripcion').val() +"</td>"+ "<input type='hidden' name='inputDescripcion[]' value='"+$('#descripcion').val() +"'></input>"+
//             "<td>"+$('#regulador').val() +"</td>"+ "<input type='hidden' name='inputRegulador[]' value='"+$('#regulador').val() +"'></input>"+
//             "<td>"+$('#tapa_tanque').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanque').val() +"'></input>"+
//             "<td>"+$('#multa').val() +"</td>"+ "<input type='hidden' name='inputMulta[]' value='"+$('#multa').val() +"'></input>"+
//             "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
//             "</tr>"
//         );

        
//         limpiar_campos_modal1("Error");
//         $('#modaldevolucion1').modal("hide");
        
//         actualizarprecios();

        
//     }


//     function limpiar_span_modal1(nombreerror){
//         $("#serie_modal"+ nombreerror).empty();
//         $("#tapa_tanque"+ nombreerror).empty();
//         $("#regulador"+ nombreerror).empty();
//         $("#multa"+ nombreerror).empty();
//         $("#descripcion"+ nombreerror).empty();
        
//     }
//     function limpiar_campos_modal1(){
//         $("#serie_modal").val('');
//         $("#tapa_tanque").val('');
//         $("#precio").val('');
//         $("#regulador").val('');
//         $("#multa").val('');
//         $('#serie_tanque').val("");
//         $('#descripcion').val("");
//     }

//     function insertFilaRegTanque(){
//         limpiar_span_modal2("Error");
//         // VALIDACIONES
//         var  campovacio =[];
//         var  msgerror =[];
//         if($('#num_seriefila').val() == '' ){ campovacio.push('num_seriefila'); msgerror.push('número de serie');}
//         if($('#phfila').val() == '' ){        campovacio.push('phfila'); msgerror.push('prueba hidroestatica');}
//         if($('#capacidadnum').val() == '' ){  campovacio.push('capacidadfila'); msgerror.push('capacidad');}
//         if($('#materialfila').val() == '' ){  campovacio.push('materialfila'); msgerror.push('tipo de material');}
//         if($('#tipo_gasfila').val() == '' ){  campovacio.push('tipo_gasfila');msgerror.push('tipo de gas'); }
//         if($('#fabricanteoficial').val() == 'Otros' ){
//             if($("#otrofabricante").val() == ''){
//                 campovacio.push('fabricantefila');
//                 msgerror.push('fabricante');
//             }
//         }else{
//             if($("#fabricanteoficial").val() == ''){
//                 campovacio.push('fabricantefila');
//                 msgerror.push('fabricante'); 
//             }
//         }
//         if($('#reguladormodal2').val() == '' ){  campovacio.push('reguladormodal2');msgerror.push('regulador'); }
//         if($('#tapa_tanquemodal2').val() == '' ){  campovacio.push('tapa_tanquemodal2');msgerror.push('tapa'); }

//         if(campovacio.length != 0){
//             $.each(campovacio, function(index){
//                 $('#'+campovacio[index]+'Error').text('Campo '+msgerror[index]+ ' obligatorio');
//             });
//             return false;
//         }

//         var fabri;
//         if($("#fabricanteoficial").val() == "Otros"){
//             fabri = $("#otrofabricante").val();
//         }else{
//             fabri = $("#fabricanteoficial").val();
//         }

//         var cap=$('#capacidadnum').val()+' '+ $('#unidadmedida').val();

//         var descrp="intercambio, " +$('#phfila').val()+", "+cap+", "+$('#materialfila').val()+", "+fabri+", "+$('#tipo_gasfila').val();
//         $('#filadevolucion').append(
//             "<tr class='classfilasdevolucion'>"+
//             "<td>"+$('#num_seriefila').val() +"</td>"+ "<input type='hidden' name='inputNumSerie[]' id='idInputNumSerie' value='"+$('#num_seriefila').val() +"'></input>"+
//             "<td>"+descrp+"</td>"+"<input type='hidden' name='inputDescripcion[]' value='"+descrp +"'></input>"+
//             "<td>"+$('#reguladormodal2').val() +"</td>"+ "<input type='hidden' name='inputRegulador[]' value='"+$('#reguladormodal2').val() +"'></input>"+
//             "<td>"+$('#tapa_tanquemodal2').val() +"</td>"+ "<input type='hidden' name='inputTapa[]' value='"+$('#tapa_tanquemodal2').val() +"'></input>"+
//             "<td>"+$('#multamodal2').val() +"</td>"+ "<input type='hidden' name='inputMulta[]' value='"+$('#multamodal2').val() +"'></input>"+
//             "<td>"+ "<button type='button' class='btn btn-naranja' id='btnEliminarFila'><span class='fas fa-window-close'></span></button>" +"</td>"+
//             "</tr>"
//         );
//             limpiar_campos_modal2("Error");
//             $('#modaldevolucion2').modal("hide");
        
//             actualizarprecios();
    
//     }

//     function limpiar_span_modal2(nombreerror){
//         $("#num_seriefila"+ nombreerror).empty();
//         $("#phfila"+ nombreerror).empty();
//         $("#capacidadfila"+ nombreerror).empty();
//         $("#materialfila"+ nombreerror).empty();
//         $("#fabricantefila"+ nombreerror).empty();
//         $("#tipo_gasfila"+ nombreerror).empty();
//         $("#reguladormodal2"+ nombreerror).empty();
//         $("#tapa_tanquemodal2"+ nombreerror).empty();
//         $("#multamodal2"+ nombreerror).empty();        
//     }
//     function limpiar_campos_modal2(){
//         $("#num_seriefila").val("");
//         $("#phfila").val("");
//         $("#capacidadnum").val("");
//         $("#unidadmedida").val("m3");
//         $("#materialfila").val("");
//         $("#otrofabricante").val("");
//         $("#fabricanteoficial").val("");
//         $("#tipo_gasfila").val("");

//         $("#tapa_tanquemodal2").val('');
//         $("#reguladormodal2").val('');
//         $("#multamodal2").val('');
//         $('#serie_tanque').val("");
//     }


//     function eliminarFila( index, val){
//         $(this).closest('tr').remove();
//         actualizarprecios();

//     }

//     function actualizarprecios(){
//         var multa = 0;
//         $(".classfilasdevolucion").each(function(){
//             var duplamulta=$(this).find("td")[4].innerHTML;
//             if(duplamulta == ''){
//                 duplamulta=0;
//             }
//             multa=multa+parseFloat(duplamulta);
//         })
//         $('#sumamultas').replaceWith( 
//             "<label id='sumamultas'>"+Intl.NumberFormat('es-MX').format(multa) +"</label>"
//         );
//         var total= 0;
//         total=multa+parseFloat($("#subtotalhid").val());
//         $('#total').replaceWith( 
//             "<label id='total'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
//         );
//     }



//     function insertnota(){

//         metodo_limpiar_span_nota("Error");

//         //Concatena las variables dependiendo el select que seleccione
//         var pagoRealizado;
//         if($("#pago_realizado1").val() == "SI"){
//             pagoRealizado = $("#pago_realizado1").val()+' '+ $("#pago_realizado2").val();
//         }else{
//             pagoRealizado = $("#pago_realizado1").val();
//         }

//         //Valida si en el campo fecha de Pago realizado esta vacio y manda error
//         if($($("#pago_realizado1").val()== 'SI' && "#pago_realizado2").val()== ''){
//             mostrar_mensaje("#divmsgnota",'Error, Verifica tus datos', "alert-danger",null);

//             $("#pago_realizadoError").text('Selecciona fecha en que se realizo el pago');
//             return false;
//         }

        
//         //variable donde guarda todo el data que se envia al controllador
//         var dataFormulario=$("#idFormDevolucionNota").serialize()+'&pago_realizado=' + pagoRealizado;

//         //envio al controlador
//         $.ajax({
//             method: "post",
//             url: "/savedevolucionnota/"+ $('#ideditnota').val(),
//             data: dataFormulario, 
//         }).done(function(){
//             window.location = "/contrato/"+ $('#idcliente').val();
//         })
//         .fail(function (jqXHR, textStatus) {
//             //Si existe algun error entra aqui
//             mostrar_mensaje("#divmsgnota",'Error, Verifica tus datos', "alert-danger",null);
//             var status = jqXHR.status;
//             if (status === 422) {
//                 $.each(jqXHR.responseJSON.errors, function (key, value) {
//                     var idError = "#" + key + "Error";
//                     //$(idError).removeClass("d-none");
//                     $(idError).text(value);
//                 });
//             }
//         });

//     }
//     function metodo_limpiar_span_nota(nombreerror) {
//         $("#folio_nota"+ nombreerror).empty();
//         $("#fecha"+ nombreerror).empty();
//         $("#pago_realizado"+ nombreerror).empty();
//         $("#metodo_pago"+ nombreerror).empty();
//     }

//     function mostrar_mensaje(divmsg,mensaje,clasecss,modal) {
//         if(modal !== null){
//             $(modal).modal("hide");
//         }
//         $(divmsg).empty();
//         $(divmsg).addClass(clasecss);
//         $(divmsg).append("<p>" + mensaje + "</p>");
//         $(divmsg).show(500);
//         $.when($(divmsg).hide(5000)).done(function () {
//             $(divmsg).removeClass(clasecss);
//         });
//     }

//     $("#pago_realizado1").change( function() {
//         if ($(this).val() == "SI") {
//             $("#pago_realizado2").prop("disabled", false);
//         } else {
//             $("#pago_realizado2").prop("disabled", true);
//             $("#pago_realizado2").val('');
//         }
//     });


//     function cancelardevolucion(){
//         window.location = "/contrato/"+ $('#idcliente').val();
//     }


//     $("#fabricanteoficial").change( function() {
//         if ($(this).val() == "Otros") {
//             $("#otrofabricante").prop("disabled", false);
//         } else {
//             $("#otrofabricante").prop("disabled", true);
//             $("#otrofabricante").val('');
//         }
//     });

//     $('.precio').keypress(function (event) {
//         if (
//             event.charCode == 43 ||
//             event.charCode == 45 || 
//             event.charCode == 69 ||
//             event.charCode == 101   
//             ){
//             return false;
//         } 
//         return true;
//     });


//     $('.eliminar-espacio').keypress(function (event) {
//         if (
//             event.charCode == 32    
//             ){
//             return false;
//         } 
//         return true;
//     });


//     //ejecutar al cargar la pagina
//     var multa = 0;
//         $(".classfilasdevolucion").each(function(){
//             var duplamulta=$(this).find("td")[4].innerHTML;
//             if(duplamulta == ''){
//                 duplamulta=0;
//             }
//             multa=multa+parseFloat(duplamulta);
//         })
//         $('#sumamultas').replaceWith( 
//             "<label id='sumamultas'>"+Intl.NumberFormat('es-MX').format(multa) +"</label>"
//         );
//         var total= 0;
//         total=multa+parseFloat($("#subtotalhid").val());
//         $('#total').replaceWith( 
//             "<label id='total'>"+Intl.NumberFormat('es-MX').format(total) +"</label>"
//         );

// });




