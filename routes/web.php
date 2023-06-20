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
    // CON CONTRATO
    Route::get('/nota/contrato/salida', 'NotaController@salidas');
    Route::post('/nota/contrato/salida/search_contrato', 'NotaController@search_contrato');
    Route::post('/nota/contrato/salida/validar_tanqueasignacion', 'NotaController@salida_validar_tanqueasignacion');
    Route::post('/nota/contrato/salida/save_envio/{contrato_id}', 'NotaController@save_envio');
    Route::post('/nota/contrato/salida/save', 'NotaController@salida_save');
    Route::get('/nota/contrato/salida/show/{nota_id}', 'NotaController@salida_show')->name('nota.contrato.salida.show');
    Route::get('/nota/contrato/salida/cancelar/{nota_id}', 'NotaController@salida_cancelar');

    Route::post('/nota/data_contrato/{contrato_id}', 'NotaController@data_contrato'); //url para buscar contrato en nota salida
    Route::get('/nota/data/{contrato_id}', 'NotaController@nota_data');

    Route::get('/nota/contrato/entrada', 'NotaController@entradas');
    Route::get('/nota/contrato/entrada/tanques_pendientes/{contrato_id}', 'NotaController@tanques_pendientes');
    Route::post('/nota/contrato/entrada/adeudos_tanques', 'NotaController@adeudos_tanques');
    Route::post('/nota/contrato/entrada/save', 'NotaController@save_entrada');
    Route::get('/nota/contrato/entrada/show/{nota_id}', 'NotaController@entrada_show')->name('nota.contrato.entrada.show');
    Route::get('/nota/contrato/entrada/cancelar/{nota_id}', 'NotaController@entrada_cancelar');
    
    Route::get('/nota/contrato/listar/index', 'NotaListasController@index');
    Route::get('/nota/contrato/listar/salidas/data', 'NotaListasController@salidas_data');
    Route::get('/nota/contrato/listar/adeudos/data', 'NotaListasController@adeudos_data');
    Route::get('/nota/contrato/listar/entradas/data', 'NotaListasController@entradas_data');
    Route::get('/nota/contrato/listar/asignaciones/data', 'NotaListasController@asignaciones_data');

    // EXPORADICA/MOSTRADOR
    Route::get('/nota/exporadica', 'NotaExporadicaController@index');
    Route::post('/nota/exporadica/save', 'NotaExporadicaController@save');
    Route::get('/nota/exporadica/listar', 'NotaExporadicaController@listar');
    Route::get('/nota/exporadica/data', 'NotaExporadicaController@data');
    Route::get('/nota/exporadica/show/{nota_id}', 'NotaExporadicaController@show')->name('nota.exporadica.show');
    Route::get('/nota/exporadica/cancelar/{nota_id}', 'NotaExporadicaController@salida_cancelar');
    
    //FORANEA
    Route::get('/nota/foranea/index', 'NotaForaneaController@index');
    Route::get('/nota/foranea/create', 'NotaForaneaController@create');
    Route::get('/nota/foranea/data', 'NotaForaneaController@data');
    Route::get('/nota/foranea/edit/{id}', 'NotaForaneaController@edit')->name('nota.foranea.edit');
    Route::post('/nota/foranea/salida/save', 'NotaForaneaController@salida_save');
    Route::post('/nota/foranea/entrada/save/{id}', 'NotaForaneaController@entrada_save');
    Route::post('/nota/foranea/cambiar_estatus/{num_serie}', 'NotaForaneaController@cambiar_estatus');
    Route::post('/nota/foranea/cambiar_estatus_entrada/{num_serie}', 'NotaForaneaController@cambiar_estatus_entrada');
    Route::get('/nota/foranea/delete/{idnota}', 'NotaForaneaController@delete'); 

    // TALON
    Route::get('/nota/talon/index', 'NotaTalonController@index');
    Route::post('/nota/talon/data', 'NotaTalonController@data');
    Route::get('/nota/talon/create', 'NotaTalonController@create');
    Route::post('/nota/talon/create/save', 'NotaTalonController@create_save');
    Route::get('/nota/talon/edit/{id}', 'NotaTalonController@edit')->name('nota.talon.edit');
    Route::post('/nota/talon/edit/save/{id}', 'NotaTalonController@edit_save');
    Route::post('/nota/talon/cambiar_estatus/{num_serie}', 'NotaTalonController@cambiar_estatus');
    Route::get('/nota/talon/delete/{idnota}', 'NotaTalonController@delete'); 

    ///* Pago notas */
    Route::get('/nota/pagos/index/{not_id}', 'NotaPagosController@index')->name('nota.pagos.index');
    Route::post('/nota/pagos/create', 'NotaPagosController@create')->name('nota.pagos.create');

    // RESERVA /nota/reserva/index
    Route::get('/nota/reserva/index', 'NotaReservaController@index');
    Route::get('/nota/reserva/data', 'NotaReservaController@data');
    Route::post('/nota/reserva/create', 'NotaReservaController@create');
    Route::get('/nota/reserva/show/{id}', 'NotaReservaController@show');
    Route::get('/nota/reserva/delete/{id}', 'NotaReservaController@delete');
    Route::get('/nota/reserva/tanques_pendientes', 'NotaReservaController@tanques_pendientes');
    Route::get('/nota/reserva/tanques_data', 'NotaReservaController@tanques_data');
    Route::get('/nota/reserva/show_history/{id}', 'NotaReservaController@show_history');

    // CONCENTRADOR /nota/reserva/index



  /* Clientes */
    Route::get('/client/{cliente_id}', 'clienteController@show')->name('client.show');


    Route::get('/cliente/index', 'clienteController@index');
    Route::get('/cliente/data/{estatus}', 'clienteController@data');
    Route::post('/cliente/create', 'clienteController@create');
    // Route::get('/cliente/show/{id}', 'clienteController@show');
    Route::post('/cliente/update/{id}', 'clienteController@update');
    Route::get('/cliente/delete/{id}', 'clienteController@destroy');

    /* Clientes Sin Contrato*/
    Route::post('/clientes_sc/search', 'ClienteSinContratoController@search');
    Route::get('/clientes_sc/show/{id}', 'ClienteSinContratoController@show');
    Route::post('/clientes_sc/create', 'ClienteSinContratoController@create');
    Route::post('/clientes_sc/update', 'ClienteSinContratoController@update');
  /* Contratos */
    Route::get('/contrato/index/{id}', 'ContratoController@index')->name('contrato.index');
    Route::post('/contrato/create', 'ContratoController@create');
    Route::post('/contrato/update/{id}', 'ContratoController@update');
    Route::get('/contrato/destroy/{id}', 'ContratoController@destroy');
    Route::get('/contrato/show/{contrato_id}', 'ContratoController@show');
    Route::get('/contrato/listar', 'ContratoController@contratos_listar');
    Route::post('/contrato/listar/data', 'ContratoController@listar_data');
    
    Route::get('/contrato/envio/show/{contrato_id}', 'ContratoController@envio_show');

    //agreement
    Route::get('/agreement/{id}', 'agreementController@create')->name('agreement.create');

  /* Tanques */
    Route::get('/tanque/index', 'TanqueController@index');
    Route::get('/tanque/data', 'TanqueController@tanques_data');
    Route::post('/tanque/create', 'TanqueController@create');
    Route::get('/tanque/show/{id}', 'TanqueController@show');
    Route::get('/tanque/show_numserie/{num_serie}', 'TanqueController@show_numserie');
    Route::post('/tanque/update/{id}', 'TanqueController@update');
    Route::get('/tanque/destroy/{id}', 'TanqueController@destroy');
    
    //tanque historial
    Route::get('/tanque/history/{id}', 'TanqueController@history')->name('tanques.history');
    Route::get('/tanque/history/data/{serietanque}', 'TanqueController@history_data');

    //tanque bajas
    Route::get('/tanque/baja/{id}', 'TanqueController@baja_tanque');
    Route::get('/tanque/lista_bajas', 'TanqueController@lista_bajas');
    Route::get('/tanque/lista_bajas/data', 'TanqueController@lista_bajas_data');
    Route::get('/tanque/restablecer/{id}', 'TanqueController@restablecer_tanque');

    //tanques por estatus
    Route::get('/tanque/estatus', 'TanqueController@estatus_index');
    Route::post('/tanque/estatus/data', 'TanqueController@estatus_data');

    //tanques por reportados
    Route::get('/tanque/reportados', 'TanqueController@reportados_index');
    Route::get('/tanque/reportados/data', 'TanqueController@reportados_data');
    Route::get('/tanque/reportados/create', 'TanqueController@reportados_create');
    Route::post('/tanque/reportados/save', 'TanqueController@reportados_save');
    Route::get('/tanque/reportados/eliminar/{id}', 'TanqueController@reportados_eliminar');

    //tanques por reportados
    Route::get('/tanque/validar_ph/{ph}', 'TanqueController@validar_ph');
    Route::get('/tanque/validar_talon/{numserie}', 'TanqueController@validar_talon');

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
    Route::get('/pdf/asignacion_tanque/{idasignacion}', 'PDFController@asignacion_tanques')->name('pdf.nota.asignacion');; 
    Route::get('/pdf/nota/{idnota}', 'PDFController@pdf_nota')->name('pdf.nota_salida'); 
    Route::get('/pdf/generar_contrato/{idcontrato}', 'PDFController@generar_contrato')->name('pdf.contrato'); 
    Route::get('/pdf/nota/exporadica/{idnota}', 'PDFController@pdf_nota_exporadica')->name('pdf.nota_exporadica'); 
    Route::get('/pdf/nota/foranea/{idnota}', 'PDFController@pdf_nota_foranea')->name('pdf.nota_foranea'); 
    Route::get('/pdf/nota/talon/{idnota}', 'PDFController@pdf_nota_talon')->name('pdf.nota_talon'); 
    Route::get('/pdf/infra/nota/{idnota}', 'PDFController@infra_nota')->name('pdf.infra_nota'); 
    Route::get('/pdf/mantenimiento/nota/{idnota}', 'PDFController@mantenimiento_nota')->name('pdf.mantenimiento_nota');


  //INFRA
    Route::get('/infra/index', 'InfraController@index');
    Route::get('/infra/data', 'InfraController@data');
    Route::get('/infra/show/{id}', 'InfraController@show');
    Route::get('/infra/entrada/{id}', 'InfraController@entrada')->name('infra.entrada');
    Route::get('/infra/salida', 'InfraController@salida');
    Route::post('/infra/salida_save', 'InfraController@salida_save');
    Route::post('/infra/entrada_save', 'InfraController@entrada_save');


  //MANTENIMIENTO
    Route::get('/mantenimiento/index', 'MantenimientoController@index');
    Route::get('/mantenimiento/data', 'MantenimientoController@data');
    Route::get('/mantenimiento/show/{id}', 'MantenimientoController@show');
    Route::get('/mantenimiento/entrada/{id}', 'MantenimientoController@entrada')->name('mantenimiento.entrada');
    Route::get('/mantenimiento/salida', 'MantenimientoController@salida');
    Route::post('/mantenimiento/registro_entrada', 'MantenimientoController@registro_entrada');
    Route::post('/mantenimiento/registro_salida', 'MantenimientoController@registro_salida');

     //Driver
     Route::resource('drivers', 'DriversController');
     Route::get('/drivers/table/data', 'DriversController@data');

     //COncentrator
     Route::resource('concentrators', 'ConcentratorController');
     Route::get('/concentrators/table/data', 'ConcentratorController@data');
     Route::get('/concentrators/show_serial/{serial_number}', 'ConcentratorController@show_serial');
    //COncentrator nota
     Route::get('/nota/concentrators', 'ConcentratorsNoteController@index');
     // Route::get('/nota/concentrators/data', 'ConcentratorsNoteController@data');
     // Route::post('/nota/concentrators/create', 'ConcentratorsNoteController@create');
    //  Route::get('/nota/concentrators/show/{serial_number}', 'ConcentratorsNoteController@show');
     // Route::get('/nota/concentrators/delete/{id}', 'ConcentratorsNoteController@delete');
     // Route::get('/nota/concentrators/tanques_pendientes', 'ConcentratorsNoteController@tanques_pendientes');
     // Route::get('/nota/concentrators/tanques_data', 'ConcentratorsNoteController@tanques_data');
     // Route::get('/nota/concentrators/show_history/{id}', 'ConcentratorsNoteController@show_history');

  /* Usuarios */
    Route::get('/user/index', 'UserController@index');
    Route::post('/user/create', 'UserController@create');
    Route::get('/user/show/{id}', 'UserController@show');
    Route::post('/user/update/{id}', 'UserController@update');
    Route::post('/user/delete/{id}', 'UserController@destroy');
    Route::get('/user/data', 'UserController@data')->name('usuarios_data');

//   /* Roles */
    Route::get('/rol/index', 'RoleController@index');
    Route::get('/rol/show/{id}', 'RoleController@show');
    Route::post('/rol/create', 'RoleController@store');
    Route::post('/rol/update/{id}', 'RoleController@update');
    Route::post('/rol/delete/{id}', 'RoleController@destroy');
    // DataTables 
    Route::get('/rol/data', 'RoleController@data')->name('rol_data');

    /* Config */
    Route::get('/config/empresa/index', 'ConfigSystemController@empresa_index');
    Route::get('/config/empresa/save', 'ConfigSystemController@empresa_save');

    /* perfil */
    Route::get('/perfil/index', 'PerfilController@index');
    Route::post('/perfil/cambio_password', 'PerfilController@cambio_password');
    Route::post('/perfil/cambio_email', 'PerfilController@cambio_email');
    Route::post('/perfil/mis_datos', 'PerfilController@mis_datos');

         //PDF TIKET 
      // Route::get('/pdf/asignacion_tanque/{idasignacion}', 'TiketsController@asignacion_tanques'); 
    // Route::get('/tiket/nota/{idnota}', 'TiketsController@cotrato_nota_salida')->name('tiket.cotrato_nota_salida'); 
      // Route::get('/pdf/generar_contrato/{idcontrato}', 'TiketsController@generar_contrato')->name('pdf.contrato'); 
      // Route::get('/pdf/nota/exporadica/{idnota}', 'TiketsController@pdf_nota_exporadica')->name('pdf.nota_exporadica'); 
      // Route::get('/pdf/nota/foranea/{idnota}', 'TiketsController@pdf_nota_foranea')->name('pdf.nota_foranea'); 
      // Route::get('/pdf/nota/talon/{idnota}', 'TiketsController@pdf_nota_talon')->name('pdf.nota_talon'); 
      // Route::get('/pdf/infra/nota/{idnota}', 'TiketsController@infra_nota')->name('pdf.infra_nota'); 
      // Route::get('/pdf/mantenimiento/nota/{idnota}', 'TiketsController@mantenimiento_nota')->name('pdf.mantenimiento_nota');