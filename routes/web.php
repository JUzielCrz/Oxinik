<?php

use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('/home', 'HomeController@index')->name('home');

  
  /* Notas */
    Route::get('/nota/salida', 'NotaController@salidas');
    Route::post('/nota/salida/search_contrato', 'NotaController@search_contrato');
    Route::post('/nota/data_contrato/{num_contrato}', 'NotaController@data_contrato'); //url para buscar contrato en nota salida
    Route::get('/nota/data/{contrato_id}', 'NotaController@nota_data');
    Route::post('/nota/salida/validar_tanqueasignacion', 'NotaController@salida_validar_tanqueasignacion');
    // Route::get('/nota/insertar_fila/{numserietanque}', 'NotaController@insertar_fila');
    Route::post('nota/salida/save', 'NotaController@salida_save');
    Route::post('/nota/salida/save_envio/{num_contrato}', 'NotaController@save_envio');

    // nota entrada
    Route::get('/nota/entrada', 'NotaController@entradas');
    Route::get('/nota/entrada/tanques_pendientes/{contrato_id}', 'NotaController@tanques_pendientes');
    Route::post('/nota/entrada/adeudos_tanques', 'NotaController@adeudos_tanques');
    Route::post('/nota/entrada/save', 'NotaController@save_entrada');

    // nota exporadica
    Route::get('/nota/exporadica', 'NotaExporadicaController@index');
    Route::post('/nota/exporadica/save', 'NotaExporadicaController@save');
    
    ///* Listar notas */
    Route::get('/nota/listar/index', 'NotaListasController@index');

    // Route::get('/pendientes/index', 'PendienteController@indexgeneral')->name('pendientes');
    // Route::get('/pendientepago', 'PendienteController@pendientepago');
    // Route::get('/pendientetanques', 'PendienteController@pendientetanques');

  /* Clientes */
    Route::get('/cliente/index', 'clienteController@index');
    Route::get('/cliente/data', 'clienteController@data');
    Route::post('/cliente/create', 'clienteController@create');
    Route::get('/cliente/show/{id}', 'clienteController@show');
    Route::post('/cliente/update/{id}', 'clienteController@update');
// Route::post('/deletecliente/{id}', 'clienteController@destroy');
// // DataTables 
    

  /* Contratos */
    Route::get('/contrato/{id}', 'ContratoController@index')->name('contrato.index');
    Route::post('/contrato/create', 'ContratoController@create');
    Route::post('/contrato/update/{id}', 'ContratoController@update');
    Route::get('/contrato/destroy/{id}', 'ContratoController@destroy');
    Route::get('/contrato/show/{contrato_id}', 'ContratoController@show');



  /* Tanques */
    Route::get('/tanque/index', 'TanqueController@index');
    Route::post('/tanque/create', 'TanqueController@create');
    Route::get('/tanque/show/{id}', 'TanqueController@show');
    Route::get('/tanque/show_numserie/{num_serie}', 'TanqueController@show_numserie');
    Route::post('/tanque/update/{id}', 'TanqueController@update');
    Route::get('/tanque/data', 'TanqueController@tanques_data');
    Route::get('/tanque/history/{id}', 'TanqueController@history')->name('tanques.history');
    Route::post('/tanque/baja/{id}', 'TanqueController@baja_tanque');
    Route::get('/tanque/history/data/{serietanque}', 'TanqueController@history_data');

    Route::get('/tanque/lista_bajas', 'TanqueController@lista_bajas');
    Route::get('/tanque/lista_bajas/data', 'TanqueController@lista_bajas_data');
    Route::post('/tanque/restablecer/{id}', 'TanqueController@restablecer_tanque');

    //GASES
    Route::get('/gas/index', 'CatalogoGasController@index');
    Route::get('/gas/data', 'CatalogoGasController@gas_data');
    Route::get('/gas/show/{id}', 'CatalogoGasController@show');
    Route::post('/gas/create', 'CatalogoGasController@create');
    Route::post('/gas/update/{id}', 'CatalogoGasController@update');
    Route::get('/gas/delete/{id}', 'CatalogoGasController@destroy');

    Route::get('/catalogo_gases', 'CatalogoGasController@catalogo_gases');

  //Asignaciones
    Route::get('/asignaciones/show/{contrato_id}', 'AsignacionController@show');
    Route::post('/asignaciones/aumento/{contrato_id}', 'AsignacionController@asignacion_plus');
    Route::post('/asignaciones/disminucion/{contrato_id}', 'AsignacionController@asignacion_minus');

  //pdf
    Route::get('/pdf/asignacion_tanque/{idasignacion}', 'PDFController@asignacion_tanques'); 
    Route::get('/pdf/nota/{idnota}', 'PDFController@pdf_nota')->name('pdf.nota_salida'); 
    Route::get('/pdf/generar_contrato/{idcontrato}', 'PDFController@generar_contrato')->name('pdf.contrato'); 
    Route::get('/pdf/nota/exporadica/{idnota}', 'PDFController@pdf_nota_exporadica')->name('pdf.nota_exporadica'); 

  

























  //     
//     
//     
//     
//     








//  Route::post('/inserttanque', 'TanqueController@store');




//   // Route::get('/nota/{id}', 'NotaController@index')->name('nota.index');
//   Route::get('contrato/newnota/{idContrato}', 'NotaController@newnota')->name('nueva.nota');
//   Route::get('/shownota/{folioNota}', 'NotaController@show');
//   Route::post('/nota/deletenota/{id}', 'NotaController@destroy');
//   Route::post('/updatenota/{idNota}', 'NotaController@update');
//   Route::get('/editnota/{folionota}', 'NotaController@editnota');
//   Route::get('/devolucionnota/{folionota}', 'NotaController@devolucionnota');
//   Route::post('/savedevolucionnota/{idNota}', 'NotaController@savedevolucionnota');

//   // DataTables 


//     // Route::get('/inserttablacontrato/{numcontrato}', 'ContratoController@inserttabla');

//     // General
//     Route::post('/updatecontrato/{id}', 'ContratoController@update');
//     Route::get('/deletecontrato/{id}', 'ContratoController@destroy');


  

    

//     // DataTables 
//     Route::get('/dt_ventas', 'VentaExporadicaController@datatablesindex')->name('dt_ventas');








    
//   /* Reportes */
    Route::get('/reportes', 'ReportesController@index');
//     Route::get('/dt_reportelisttanques/{estatus}', 'ReportesController@dt_listtanques')->name('dt_reportelisttanques');


 
//   //INFRA
  Route::get('infra', 'InfraController@index');
//   Route::get('dt_infra', 'InfraController@datatables')->name('dt_infra');
//   Route::get('createinfra', 'InfraController@create');
//   Route::post('buscartanqueinfra/{serie}', 'InfraController@buscartanque');
//   Route::post('savenoteinfra', 'InfraController@savenote');
//   Route::get('/deleteinfra/{id}', 'InfraController@delete');
  
  
//   Route::get('editinfra/{id}', 'InfraController@edit');
//   Route::get('actualizarnoteinfra', 'InfraController@update');

//     //Mantenimiento
    Route::get('mantenimiento', 'MantenimientoController@index');
//     Route::get('dt_mantenimiento', 'MantenimientoController@datatables')->name('dt_mantenimiento');
//     Route::get('createmantenimiento', 'MantenimientoController@create');
//     Route::post('buscartanquemantenimiento/{serie}', 'MantenimientoController@buscartanque');
//     Route::post('savenotemantenimiento', 'MantenimientoController@savenote');
//     Route::get('/deletemantenimiento/{id}', 'MantenimientoController@delete');
    
    
//     Route::get('editmantenimiento/{id}', 'MantenimientoController@edit');
//     Route::get('actualizarnotemantenimiento', 'MantenimientoController@update');


//     //PDFs



//    


//     /* Usuarios */
//     Route::get('/user', 'UserController@index');
//     Route::post('/newuser', 'UserController@create');
//     Route::get('/showuser/{id}', 'UserController@show');
//     Route::post('/updateuser/{id}', 'UserController@update');
//     Route::post('/deleteuser/{id}', 'UserController@destroy');
//     // DataTables 
//     Route::get('/dt_usuarios', 'UserController@datatablesindex')->name('dt_usuarios');

//   /* Roles */
//     Route::get('/role', 'RoleController@index');
//     Route::get('/showrole/{id}', 'RoleController@show');
//     Route::post('/insertrole', 'RoleController@store');
//     Route::post('/updaterol/{id}', 'RoleController@update');
//     Route::post('/deleterol/{id}', 'RoleController@destroy');
//     // DataTables 
//     Route::get('/dt_role', 'RoleController@datatablesindex')->name('dt_role');