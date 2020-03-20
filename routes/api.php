<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('consumos.api.cercafe', 'API\ApiDataCercafeController@showConsumosHembra');
Route::get('celos.api.cercafe', 'API\ApiDataCercafeController@ShowCelosHembra');

Route::middleware('cors')->group(function () {
    Route::post('login', 'API\UserController@login')->name('login');
    Route::post('register', 'API\RegisterController@register');
    Route::get('UserByArea/{area}', 'API\UserController@getByArea');
    Route::middleware('auth:api')->group( function () {
        Route::resource('products', 'API\ProductController');
        Route::resource('areas', 'API\AreasController');
        Route::resource('concentrados', 'API\ConcentradosController');
        Route::resource('causas', 'API\CausasController');
        Route::resource('cargos', 'API\CargosController');
        Route::resource('preguntas', 'API\PreguntasController');
        Route::resource('sedes', 'API\SedesController');
        Route::resource('roles', 'API\RolesController');
        Route::post('details', 'API\UserController@details');
        Route::resource('emails', 'API\EmailController');
        Route::get('logout', 'API\UserController@logout');
        Route::resource('granjas', 'API\GranjasController');
        Route::resource('calificacionGranja', 'API\CalificacionGranjaController');
        Route::resource('granjasAsociadas', 'API\GranjasAsociadasController');
        Route::resource('informeAuditoria', 'API\InformeAuditoriaController');

        Route::get('AllUsers', 'API\UserController@getAllUsers');
        Route::get('infoUser/{id}', 'API\UserController@showInfoUser');
        Route::get('AllGranjasAsociadas', 'API\GranjasAsociadasController@getAllGranjasAsociadas');
        Route::resource('updatePassword', 'API\UserController');
        Route::patch('updateUser/{id}', 'API\UserController@UpdateUser');

        Route::post('calificacionAuditoria', 'API\InformeAuditoriaController@showCalificaciones');
        Route::post('categoriasAuditoria', 'API\InformeAuditoriaController@showCategorias');
        Route::post('respuestasSubProceso', 'API\InformeAuditoriaController@respuestasSubProceso');

        Route::resource('AllInfo', 'API\OfflineController');

        Route::resource('informeMedicamentos', 'API\InformeMedicamentosController');
        Route::resource('informeDesposte', 'API\InformeDesposteController');
        Route::resource('informeMt', 'API\InformeMateriaPrimaController');
        Route::resource('informePt', 'API\InformePtController');

        Route::resource('inventarios', 'API\InventariosController');
        Route::resource('inventarios/mant', 'API\InventariosMantController');
        Route::resource('inventarios/calidad', 'API\InventariosCalidadController');
        Route::resource('inventariosMt', 'API\InventariosMtController');
        Route::resource('inventarios/dotacion', 'API\InventariosDotacionController');
        Route::resource('inventariosDesposte', 'API\InventariosDesposteController');
        Route::resource('inventariosPt', 'API\SaldosPTController');

        Route::resource('linkForms', 'API\LinkFormsController');
        Route::get('linkForms/Answers/{type}', 'API\LinkFormsController@AnswersByType');
        Route::resource('count/forms', 'API\CountFormsController');
        Route::resource('count/conteos', 'API\CountConteosController');
        Route::resource('filterMedicamentos', 'API\FilterMedicamentosController');
        Route::resource('referencias', 'API\ReferenciasMedicamentosController');
        Route::resource('calendario', 'API\CalendarioController');
        Route::resource('productos/calidad', 'API\ProductosCalidadController');
        Route::resource('informeCalidad', 'API\InformeCalidadController');
        Route::resource('fechas/calidad', 'API\FechasSaldosCalidadController');
        Route::resource('fechas/desposte', 'API\FechasSaldosDesposteController');

        Route::resource('suministroAgua', 'API\SuministroAguaController');
        Route::resource('informeVisitasTec', 'API\InformeVisitasTecnicaController');
        Route::resource('filterVisitas', 'API\FilterVisitasTecnicasController');
        Route::resource('fuenteAgua', 'API\FuenteAguaController');
        Route::resource('sendPdfTecnica', 'API\PdfInformeTecnicaController');
        Route::resource('filter/calidad', 'API\FilterCalidadController');
        Route::resource('referenciasMantenimiento', 'API\ReferenciasMantController');
        Route::resource('informeMantenimiento', 'API\InformeMantController');
        Route::resource('fechas/dotacion', 'API\FechasSaldosDotacionController');
        Route::resource('saldos/dotacion', 'API\SaldosDotacionController');
        Route::resource('informeDotacion', 'API\InformeDotacionController');
        Route::resource('referenciasDotacion', 'API\ReferenciasDotacionController');

        Route::resource('fechas/mt', 'API\FechasSaldosMtController');
        Route::resource('fechas/mant', 'API\FechasSaldosInvMantController');
        Route::resource('filterMant', 'API\FilterMantController');
        Route::resource('fechas/pt', 'API\FechasSaldosPTController');

        Route::resource('filterDotacion', 'API\FilterDotacionController');
        Route::resource('filterDesposte', 'API\FilterDesposteController');
        Route::resource('filterMt', 'API\FilterMtController');
        Route::resource('filterPt', 'API\FilterPtController');

        Route::resource('registroCerda', 'API\HembrasController');
        Route::post('searchHembra', 'API\HembrasController@searchHembra');
        Route::resource('genetica', 'API\LineasGeneticaController');

        Route::resource('registroPesos', 'API\RegistroPesoController');
        Route::post('registroPesos/delete', 'API\RegistroPesoController@destroy');
        Route::get('searchApellido/{idCerda}', 'API\RegistroPesoController@searchApellido');
        Route::get('verificaApellido/{sobrenombre}/{cod_Hembra}', 'API\RegistroPesoController@VerificarApellido');

        Route::resource('celosCerda', 'API\CeloController');

        Route::resource('PesoCerda', 'API\PesoCerdaController');
        Route::post('PesoCerdaUpdate', 'API\PesoCerdaController@update');
        Route::resource('ConsumoCerda', 'API\ConsumoCerdaController');
        Route::post('ConsumoCerdaUpdate', 'API\ConsumoCerdaController@update');

        Route::resource('descarte', 'API\DescarteController');
        Route::resource('descarte_hembras', 'API\HembrasDescarteController');
        Route::resource('corral', 'API\CorralController');
        Route::get('corralByUser/{id}', 'API\CorralController@ShowCorralesByUser');
        Route::resource('lote', 'API\LoteController');
        Route::get('getInfoLote/{id}', 'API\LoteController@getDataLote');
        Route::resource('HembraCorral', 'API\HembrasController');
        Route::post('updateHembrasCorral', 'API\HembraCorralController@update_corral_hembras');
        Route::post('showHembras', 'API\HembraCorralController@showHembras');
        Route::get('getSemanas', 'API\CalendarioController@showSemanas');

        Route::resource('aperturaLotes', 'API\AperturaLoteController');
        Route::resource('eventosLote', 'API\EventosLoteController');
        Route::post('ShowEventsInDay', 'API\EventosLoteController@showEventsByDay');
        Route::post('paintedCells', 'API\EventosLoteController@paintedCells');
        Route::get('statsLote/{id}', 'API\EventosLoteController@showStatsLote');
        Route::resource('Despachos', 'API\DespachosController');
        
        Route::resource('duracionPreceboCeba', 'API\DuracionPreceboCebaController');
        Route::resource('ordenes_produccion', 'API\OrdenesProduccionController');
        Route::get('ordenes_produccion/DietaOP/{id}', 'API\OrdenesProduccionController@DietaOP');

        Route::resource('ensaques_planta', 'API\EnsaquesPlantaController');

        /* Bodegas Granjas */
        Route::resource('bodegas_granjas', 'API\BodegasGranjasController');
        /* Route::resource('bodegasGranjas', 'API\BodegasGranjasController');
        Route::get('BodegasByUser/{id}', 'API\BodegasGranjasController@showBodegasByUser'); */

        Route::resource('aperturaLote', 'API\AperturaLoteController');
        Route::resource('ReporteCalidad', 'API\ReporteCalidadController');
        Route::resource('materiasPrimas', 'API\MateriasPrimasController');
        Route::resource('proveedores', 'API\ProveedoresController');
        Route::resource('registroMateriasPrimas', 'API\MateriasPrimasRegistroController');

        Route::resource('BodegaDietas', 'API\BodegaDietasController');
        Route::resource('Ensaque', 'API\EnsaqueController');
        Route::get('Despachos/search/{id}', 'API\DespachosController@GetDietaByGranja');
        Route::get('Despachos/searchOP/{id}', 'API\DespachosController@GetDietaByOP');
        Route::resource('peso_ensaque', 'API\PesoEnsaqueController');
        Route::resource('macros_micros', 'API\MacrosMicrosController');
        Route::resource('consecutivos_concentrados', 'API\ConsecutivosConcentradosController');
        Route::resource('pedido_concentrados', 'API\PedidoConcentradosController');
        Route::resource('conductores', 'API\ConductoresController');
        Route::resource('vehiculos_despacho', 'API\VehiculosDespachoController');

        Route::get('export/medicamentos/{fecha}/{fecha2?}', 'API\InformeMedicamentosController@downloadExcel');
        Route::get('export/mantenimiento/{fecha}/{fecha2?}', 'API\InformeMantController@downloadExcel');
        Route::get('export/calidad/{fecha}/{fecha2?}', 'API\InformeCalidadController@downloadExcel');
        Route::get('export/producto_terminado/{fecha}/{fecha2?}', 'API\InformePtController@downloadExcel');
        Route::get('export/materia_prima/{fecha}/{fecha2?}', 'API\InformeMateriaPrimaController@downloadExcel');
        Route::get('export/dotacion/{fecha}/{fecha2?}', 'API\InformeDotacionController@downloadExcel');
        Route::get('export/desposte/{fecha}/{fecha2?}', 'API\InformeDesposteController@downloadExcel');

        /* pendiente */
        Route::resource('informe_pedido_concentrados', 'API\InformePedidoConcentradosController');
        Route::get('informe_pedido_concentrados/generarExcel/{id}', 'API\InformePedidoConcentradosController@downloadExcel');

        Route::post('getAllInventario', 'API\ConcentradosController@getAllInventario');

        Route::resource('tolvas_planta', 'API\TolvasPlantaController');
        Route::resource('tolvas_acciones', 'API\TolvasAccionesController');
        Route::post('SearchAcciones', 'API\TolvasAccionesController@search');

        /* Pedidos Semen */
        Route::resource('consecutivos_productos_cia', 'API\ConsecutivosProductosCiaController');
        Route::resource('pedido_cia', 'API\PedidoCiaController');
        Route::resource('productos_cia', 'API\ProductosCiaController');

        /* Pedidos Medicamentos e Insumos */
        Route::resource('consecutivos_medicamentos', 'API\ConsecutivosMedicamentosController');
        Route::resource('pedido_medicamentos', 'API\PedidoMedicamentosController');
        Route::resource('medicamentos', 'API\MedicamentosController');
        Route::resource('insumos_servicios', 'API\InsumosServiciosController');
        Route::resource('pedido_insumos_servicios', 'API\PedidoInsumosServiciosController');

        
    });
});