<?php

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
    Route::get('/showcontrato/{id}', 'ContratoController@show');
    Route::post('/insertcontrato', 'ContratoController@store');
    Route::post('/contrato/updatecontrato/{id}', 'ContratoController@update');
    Route::get('/contrato/deletecontrato/{id}', 'ContratoController@destroy');
    // General
    Route::get('/contratogeneral', 'ContratoController@indexgeneral')->name('contrato.general');
    Route::post('/updatecontrato/{id}', 'ContratoController@update');
    Route::get('/deletecontrato/{id}', 'ContratoController@destroy');
    // DataTables 
    Route::get('/dt_contrato/{id}', 'ContratoController@datatablesindex')->name('dt_contrato');
    Route::get('/dt_contratogeneral/{id}', 'ContratoController@datatablesindexgeneral')->name('dt_contratogeneral');
    
    

  /* Notas */
    Route::get('/nota/{id}', 'NotaController@index')->name('nota.index');
    Route::get('/newnota/{idContrato}', 'NotaController@newnota');
    Route::post('/createnota', 'NotaController@create');
    Route::get('/shownota/{id}', 'NotaController@show');
    Route::post('/nota/deletenota/{id}', 'NotaController@destroy');
    Route::post('/updatenota/{idNota}', 'NotaController@update');
    Route::get('/editnota/{folionota}', 'NotaController@editnota');

    // DataTables 
    Route::get('/dt_nota/{numContrato}', 'NotaController@datatablesindex')->name('dt_nota');

    Route::post('/insertfila/{numserietanque}', 'NotaController@insertfila');

  /* Reportes */
    Route::get('/reportes', 'ReportesController@index');
    // Route::get('/showreportes/{id}', 'ReportesController@show');
    // Route::post('/insertreportes', 'ReportesController@store');
    // Route::post('/updaterol/{id}', 'ReportesController@update');
    // Route::post('/deleterol/{id}', 'ReportesController@destroy');
    // DataTables 
    // Route::get('/dt_reportes', 'ReportesController@datatablesindex')->name('dt_reportes');


  /* ventas */
    Route::get('/ventas', 'VentaController@index');
    Route::get('/newventa', 'VentaController@newventa');
    Route::post('/insertventas', 'VentaController@create');
    // Route::get('/showventas/{id}', 'VentaController@show');
    // Route::post('/updaterol/{id}', 'VentaController@update');
    // Route::post('/deleterol/{id}', 'VentaController@destroy');

    // DataTables 
    Route::get('/dt_ventas', 'VentaController@datatablesindex')->name('dt_ventas');
    //Validar estatus tanque
    Route::post('/validventasalida/{numserie}', 'VentaController@validventasalida');