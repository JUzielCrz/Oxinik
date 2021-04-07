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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('/home', 'HomeController@index')->name('home');

  /* Usuarios */
    Route::get('/user', 'UserController@index');
    Route::post('/newuser', 'UserController@create');
    Route::get('/showuser/{id}', 'UserController@show');
    Route::post('/updateuser/{id}', 'UserController@update');
    Route::post('/deleteuser/{id}', 'UserController@destroy');
    // DataTables 
    Route::get('/dt_usuarios', 'UserController@datatablesindex')->name('dt_usuarios');

  /* Roles */
    Route::get('/role', 'RoleController@index');
    Route::get('/showrole/{id}', 'RoleController@show');
    Route::post('/insertrole', 'RoleController@store');
    Route::post('/updaterol/{id}', 'RoleController@update');
    Route::post('/deleterol/{id}', 'RoleController@destroy');
    // DataTables 
    Route::get('/dt_role', 'RoleController@datatablesindex')->name('dt_role');

  /* Clientes */
    Route::get('/cliente', 'clienteController@index');
    Route::post('/newcliente', 'clienteController@create');
    Route::get('/showcliente/{id}', 'clienteController@show');
    Route::post('/updatecliente/{id}', 'clienteController@update');
    Route::post('/deletecliente/{id}', 'clienteController@destroy');
    // DataTables 
    Route::get('/dt_cliente', 'clienteController@datatablesindex')->name('dt_cliente');

  

  /* Tanques */
    Route::get('/tanque', 'TanqueController@index');
    Route::post('/newtanque', 'TanqueController@create');
    Route::get('/showtanque/{id}', 'TanqueController@show');
    Route::post('/inserttanque', 'TanqueController@store');
    Route::post('/updatetanque/{id}', 'TanqueController@update');
    Route::post('/deletetanque/{id}', 'TanqueController@destroy');
    // DataTables 
    Route::get('/dt_tanque', 'TanqueController@datatablesindex')->name('dt_tanque');
    // DataTables 
    Route::get('/historytanque/{id}', 'TanqueController@historyindex')->name('tanques.history');
    Route::get('/dt_tanque_history/{serietanque}', 'TanqueController@datatableshistoryindex')->name('tanque.dt.history');

  /* Contratos */
    Route::get('/contrato/{id}', 'ContratoController@index')->name('contrato.index');
    Route::post('/newcontrato', 'ContratoController@create');
    Route::post('/insertcontrato', 'ContratoController@store');
    Route::post('/contrato/updatecontrato/{id}', 'ContratoController@update');
    Route::get('/contrato/deletecontrato/{id}', 'ContratoController@destroy');

    Route::get('/showcontrato/{contrato_id}', 'ContratoController@show');

    //Asignaciones
    Route::get('/showasignaciones/{contrato_id}', 'AsignacionController@show');
    Route::post('/asignacion/AUMENTO/{contrato_id}', 'AsignacionController@asignacion_plus');
    Route::post('/asignacion/DISMINUCION/{contrato_id}', 'AsignacionController@asignacion_minus');

    // Route::get('/inserttablacontrato/{numcontrato}', 'ContratoController@inserttabla');

    // General
    Route::post('/updatecontrato/{id}', 'ContratoController@update');
    Route::get('/deletecontrato/{id}', 'ContratoController@destroy');

  /* PENDIENTES */
    Route::get('/pendientes', 'PendienteController@indexgeneral')->name('pendientes');
    Route::get('/pendientepago', 'PendienteController@pendientepago');
    Route::get('/pendientetanques', 'PendienteController@pendientetanques');

  /* Notas */

    //CAMBIO NUEVOS LINKS
    Route::post('/datacontrato/{num_contrato}', 'NotaController@datacontrato'); //url para buscar contrato en nota salida
    Route::get('/notasalida', 'NotaController@notasalida');
    Route::post('/notasalida/searchcontrato', 'NotaController@searchcontrato');
    Route::post('/notasalida/save_edit_envio/{num_contrato}', 'NotaController@saveeditenvio');
    Route::post('/save_notasalida', 'NotaController@save_notasalida');

    //nota entrada
    Route::get('/notaentrada', 'NotaController@notaentrada');
    Route::post('/notasalida/searchcliente', 'NotaController@searchcliente');

    



    
    








    // Route::get('/nota/{id}', 'NotaController@index')->name('nota.index');
    Route::get('contrato/newnota/{idContrato}', 'NotaController@newnota')->name('nueva.nota');
    Route::get('/shownota/{folioNota}', 'NotaController@show');
    Route::post('/nota/deletenota/{id}', 'NotaController@destroy');
    Route::post('/updatenota/{idNota}', 'NotaController@update');
    Route::get('/editnota/{folionota}', 'NotaController@editnota');
    Route::get('/devolucionnota/{folionota}', 'NotaController@devolucionnota');
    Route::post('/savedevolucionnota/{idNota}', 'NotaController@savedevolucionnota');

    // DataTables 
    Route::get('/dt_nota/{contrato_id}', 'NotaController@datatablesindex')->name('dt_nota');
    Route::post('/insertfila/{numserietanque}', 'NotaController@insertfila');

  /* Reportes */
    Route::get('/reportes', 'ReportesController@index');
    Route::get('/dt_reportelisttanques/{estatus}', 'ReportesController@dt_listtanques')->name('dt_reportelisttanques');


  /* ventas */
    Route::get('/ventas', 'VentaController@index');
    Route::get('/newventa', 'VentaController@newventa');
    Route::post('/insertventas', 'VentaController@create');

    // DataTables 
    Route::get('/dt_ventas', 'VentaController@datatablesindex')->name('dt_ventas');
    //Validar estatus tanque
    Route::post('/validventasalida/{numserie}', 'VentaController@validventasalida');
  
  //INFRA
  Route::get('infra', 'InfraController@index');
  Route::get('dt_infra', 'InfraController@datatables')->name('dt_infra');
  Route::get('createinfra', 'InfraController@create');
  Route::post('buscartanqueinfra/{serie}', 'InfraController@buscartanque');
  Route::post('savenoteinfra', 'InfraController@savenote');
  Route::get('/deleteinfra/{id}', 'InfraController@delete');
  
  
  Route::get('editinfra/{id}', 'InfraController@edit');
  Route::get('actualizarnoteinfra', 'InfraController@update');

    //Mantenimiento
    Route::get('mantenimiento', 'MantenimientoController@index');
    Route::get('dt_mantenimiento', 'MantenimientoController@datatables')->name('dt_mantenimiento');
    Route::get('createmantenimiento', 'MantenimientoController@create');
    Route::post('buscartanquemantenimiento/{serie}', 'MantenimientoController@buscartanque');
    Route::post('savenotemantenimiento', 'MantenimientoController@savenote');
    Route::get('/deletemantenimiento/{id}', 'MantenimientoController@delete');
    
    
    Route::get('editmantenimiento/{id}', 'MantenimientoController@edit');
    Route::get('actualizarnotemantenimiento', 'MantenimientoController@update');


    //PDFs

    Route::get('/pdf/nota/{idnota}', 'PDFController@pdf_nota'); 
    Route::get('/pdf/asignacion_tanque/{idasignacion}', 'PDFController@asignacion_tanques'); 

    //CATALOGO GASES
    Route::get('/catalogo_gases', 'UsoGeneralController@catalogo_gases');