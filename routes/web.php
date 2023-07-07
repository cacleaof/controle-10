<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserControl;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProjControl;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/index', function () {
    return view('index');
});

Route::get('/teste', function () {
    return view('teste');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/lista', [UserControl::class, 'lista'])->name('admin.cadastro.lista');
    Route::get('/proj/index', [AdminController::class, 'index'])->name('admin.proj.index');
    Route::get('showpj', [ProjControl::class, 'showpj'])->name('proj.showpj');
    Route::get('/diario', [ProjControl::class, 'diario'])->name('admin.proj.diario');
    Route::post('/diario', [ProjControl::class, 'diario'])->name('admin.proj.diario');
    Route::get('task', [ProjControl::class, 'task'])->name('admin.proj.task');
    Route::get('/n_proj', [ProjControl::class, 'n_proj'])->name('admin.proj.n_proj');
    Route::get('n_task', [ProjControl::class, 'n_task'])->name('admin.proj.n_task');
    Route::get('delpj', [ProjControl::class, 'delpj'])->name('proj.delpj');
    Route::get('showtk', [ProjControl::class, 'showtk'])->name('proj.showtk');
    Route::get('deltk', [ProjControl::class, 'deltk'])->name('proj.deltk');
    Route::get('proj/entrada', [ProjControl::class, 'entrada'])->name('proj.entrada');
    Route::post('upd_p', [ProjControl::class, 'upd_p'])->name('proj.upd_p');
    Route::get('m_task', [ProjControl::class, 'm_task'])->name('admin.proj.m_task');
    Route::post('/store_diario', [ProjControl::class, 'store_diario'])->name('admin.proj.store_diario');
    Route::post('upd_t', [ProjControl::class, 'upd_t'])->name('proj.upd_t');
});
Route::group([`middleware` => ['administrador']], function() {
    Route::get('/a_diario', [ProjControl::class, 'a_diario'])->name('admin.proj.a_diario'); 
    Route::get('store_p', [ProjControl::class, 'store_p'])->name('admin.proj.store_p');
    Route::post('store_t', [ProjControl::class, 'store_t'])->name('admin.proj.store_t');
    Route::get('store_tp', [ProjControl::class, 'store_tp'])->name('admin.proj.store_tp');
});

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin',], function(){
       // Route::get('/lista', [UserControl::class, 'lista'])->name('admin.cadastro.lista');
       // Route::get('/index', [AdminController::class, 'index'])->name('admin.proj.index');
    });
Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin',], function(){

    Route::group(['middleware' => ['can:administrador'||'can:coordenador']], function(){

    Route::get('perfil', 'UserControl@perfil')->name('admin.cadastro.perfil');

    Route::get('usuario', 'UserControl@usuario')->name('admin.cadastro.usuario');

    Route::get('editperfil', 'UserControl@editperfil')->name('admin.cadastro.editperfil');

    Route::get('muda_perfil', 'UserControl@muda_perfil')->name('admin.cadastro.muda_perfil');

    Route::post('m_perfil', 'UserControl@m_perfil')->name('admin.cadastro.m_perfil');

    Route::get('n_perfil', 'UserControl@n_perfil')->name('admin.cadastro.n_perfil');

    Route::get('del_perfil', 'UserControl@del_perfil')->name('admin.cadastro.del_perfil');

    Route::post('store/{id}', 'UserControl@store')->name('admin.cadastro.store');

    Route::get('deletar', 'UserControl@deletar')->name('admin.cadastro.deletar');

    Route::get('task', 'ProjControl@task')->name('admin.proj.task');

    Route::get('p_proj', 'ProjControl@p_proj')->name('admin.proj.p_proj');

    Route::get('m_task', 'ProjControl@m_task')->name('admin.proj.m_task');

    Route::get('showdp', 'ProjControl@showdp')->name('proj.showdp');

    Route::post('upd_d', 'ProjControl@upd_d')->name('proj.upd_d');

    

    });	

Route::get('status_proj', 'ProjControl@status_proj')->name('admin.proj.status_proj');

Route::get('status_task', 'ProjControl@status_task')->name('admin.proj.status_task');

Route::get('/proj/cpproj', 'ProjControl@cpproj')->name('admin.proj.cpproj');

Route::get('dep_task', 'ProjControl@dep_task')->name('admin.proj.dep_task');

Route::get('status_diario', 'ProjControl@status_diario')->name('admin.proj.status_diario');

Route::post('store_t', 'ProjControl@store_t')->name('admin.proj.store_t');

Route::get('store_tp', 'ProjControl@store_tp')->name('admin.proj.store_tp');

Route::get('/', 'AdminController@index')->name('admin.consult');

Route::get('sol_atv', 'ProjControl@sol_atv')->name('admin.proj.sol_atv');

Route::get('deld', 'ProjControl@deld')->name('admin.proj.deld');

Route::get('a_diario', 'ProjControl@a_diario')->name('admin.proj.a_diario');

Route::post('sadiario', 'ProjControl@sadiario')->name('admin.proj.sadiario');

Route::any('historic-search', 'BalanceController@searchHistoric')->name('historic.search');

Route::get('historic', 'BalanceController@historic')->name('admin.historic');

Route::post('transfer', 'BalanceController@TransferStore')->name('transfer.store');

Route::post('confirm-transfer', 'BalanceController@confirmTransfer')->name('confirm.transfer');

Route::get('transfer', 'BalanceController@transfer')->name('balance.transfer');

Route::post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');

Route::get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');

Route::post('deposit', 'BalanceController@DepositStore')->name('deposit.store');

Route::get('deposit', 'BalanceController@deposit')->name('balance.deposit');

Route::get('balance', 'BalanceController@index')->name('admin.balance');

Route::get('entrada', 'ConsultController@entrada')->name('consult.entrada');

Route::get('gecad/lista', 'GecadControl@lista')->name('admin.gecad.lista');

// Route::get('/proj', 'ProjControl@index')->name('admin.proj.index');

Route::get('proj/agenda', 'ProjControl@agenda')->name('admin.proj.agenda');

Route::get('task', 'ProjControl@task')->name('admin.proj.task');

Route::get('proj/ganttchart', 'GanttController@ganttchart')->name('admin.proj.ganttchart');

Route::get('proj/ganttmano', 'GanttController@ganttmano')->name('admin.proj.ganttmano');

Route::get('proj/entrada', 'ProjControl@entrada')->name('proj.entrada');

Route::get('download_T', 'ProjControl@download_T')->name('proj.download_T');

Route::get('/saida', 'ConsultController@saida')->name('consult.saida');

Route::post('store', 'ConsultController@store')->name('consult.store');

Route::post('cons_store', 'ConsultController@cons_store')->name('consult.cons_store');

Route::post('storeecg', 'ConsultController@storeecg')->name('consult.storeecg');

Route::get('regular', 'ConsultController@regular')->name('consult.regular');

Route::get('sala', 'ConsultController@sala')->name('consult.sala');

Route::get('consultor', 'ConsultController@consultor')->name('consult.consultor');

Route::get('encaminhar', 'ConsultController@encaminhar')->name('consult.encaminhar');

Route::get('selecresp', 'ConsultController@selecresp')->name('consult.selecresp');

Route::get('resposta', 'ConsultController@resposta')->name('consult.resposta');

Route::get('replica', 'ConsultController@replica')->name('consult.replica');

Route::get('devolver', 'ConsultController@devolver')->name('consult.devolver');

Route::get('dev_cons', 'ConsultController@dev_cons')->name('consult.dev_cons');

Route::post('dev_con_store', 'ConsultController@dev_con_store')->name('consult.dev_con_store');

Route::post('devstore', 'ConsultController@devstore')->name('consult.devstore');

Route::get('show', 'ConsultController@show')->name('consult.show');

Route::get('showS', 'ConsultController@showS')->name('consult.showS');
    
    Route::get('showSA', 'ConsultController@showSA')->name('consult.showSA');

Route::get('modelo', 'ConsultController@modelo')->name('consult.modelo');

Route::post('show_store', 'ConsultController@show_store')->name('consult.show_store');

Route::post('show_replica', 'ConsultController@show_replica')->name('consult.show_replica');

Route::get('download_S', 'ConsultController@download_S')->name('consult.download_S');

Route::get('download_C', 'ConsultController@download_C')->name('consult.download_C');

Route::get('respcons', 'ConsultController@respcons')->name('consult.respcons');

Route::get('respecg', 'ConsultController@respecg')->name('consult.respecg');

Route::post('storecons', 'ConsultController@storecons')->name('consult.storecons');

Route::post('storeconsulta', 'ConsultController@storeconsulta')->name('consult.storeconsulta');

Route::get('wordssearch', 'ConsultController@wordssearch')->name('consult.wordssearch');

Route::get('getcontent', 'ConsultController@getcontent')->name('consult.getcontent');

Route::get('laudo/{id}', 'ConsultController@laudo')->name('laudo');

Route::post('save_usuarios', 'Importar@save_usuarios')->name('importar.save_usuarios');

Route::get('usuarios', 'Importar@usuarios')->name('importar.usuarios');

Route::get('tarefas', 'Importar@tarefas')->name('importar.tarefas');

Route::post('save_tarefas', 'Importar@save_tarefas')->name('importar.save_tarefas');

Route::get('projetos', 'Importar@projetos')->name('importar.projetos');

Route::post('save_projetos', 'Importar@save_projetos')->name('importar.save_projetos');

Route::get('gettask', 'Importar@gettask')->name('importar.gettask');

Route::get('getproj', 'Importar@getproj')->name('importar.getproj');

Route::get('getindex', 'Importar@getindex')->name('importar.getindex');

Route::get('/export_excel', 'ExportExcelController@index');

Route::get('/export_users', 'ExportUserController@index');

Route::get('/export_proj', 'ExportProjController@index');

Route::get('/export_pri', 'ExportPriController@index');

Route::get('/exp_prireg', 'ExpPriRegController@index');

Route::get('/export_task', 'ExportTaskController@index');

Route::get('/export_dep', 'ExportDepController@index');

Route::get('/export_excel/excel', 'ExportExcelController@excel')->name('export_excel.excel');

Route::get('/export_users/excel', 'ExportUserController@excel')->name('export_users.excel');

Route::get('/export_proj/excel', 'ExportProjController@excel')->name('export_proj.excel');

Route::get('/export_pri/excel', 'ExportPriController@excel')->name('export_pri.excel');

Route::get('/exp_prireg/excel', 'ExpPriRegController@excel')->name('exp_prireg.excel');

Route::get('/export_task/excel', 'ExportTaskController@excel')->name('export_task.excel');

Route::get('/export_dep/excel', 'ExportDepController@excel')->name('export_dep.excel');

});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
