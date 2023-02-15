<?php

use App\Http\Controllers\ChargerTaskController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\GanttController;
use App\Http\Controllers\GrafikonController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\ImportFileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/gantt', function () {
    return view('gantt');
});
Route::get('/', [WelcomeController::class, 'index'])->name('welcome-page');

Route::get('/tourSelection', [TaskController::class, 'getTour'])->name('select-tours');
Route::get('/chargerSelection', [ChargerTaskController::class, 'getCharger'])->name('select-chargers');
Route::get('/scheduleSelection', [ScheduleController::class, 'getSchedule'])->name('select-schedules');

Route::post('/ganttTours',[GanttController::class, 'tourGantt'])->name('gantt-tour');
Route::post('/ganttChargers',[GanttController::class, 'chargerGantt'])->name('gantt-charger');
Route::post('/ganttSchedules',[GanttController::class, 'scheduleGantt'])->name('gantt-schedule');

Route::post('/tableTours',[DataTableController::class, 'tourTable'])->name('table-tour');
Route::post('/tableChargers',[DataTableController::class, 'chargerTable'])->name('table-charger');
Route::post('/tableSchedules',[DataTableController::class, 'scheduleTable'])->name('table-schedule');

Route::post('/statsTours',[TaskController::class, 'tourStats'])->name('stats-tour');
Route::post('/statsChargers',[ChargerTaskController::class, 'chargerStats'])->name('stats-charger');
Route::post('/statsSchedules',[ScheduleController::class, 'scheduleStats'])->name('stats-schedule');

Route::get('/dataTableSelection', [DataTableController::class, 'getTableNames'])->name('select-table-view');
Route::get('/taskGrafikon', [GrafikonController::class, 'getTaskGrafikon'])->name('select-task-grafikon');
Route::get('/scheduleGrafikon', [GrafikonController::class, 'getScheduleGrafikon'])->name('select-schedule-grafikon');

Route::get('/dataTableChargerTaskview',[DataTableController::class, 'getChargerTaskDataTable'])->name('page-data-table-chargertask');
Route::get('/dataTableScheduleview',[DataTableController::class, 'getScheduleDataTable'])->name('page-data-table-schedule');
Route::get('/dataTableTaskview',[DataTableController::class, 'getTaskDataTable'])->name('page-data-table-task');


Route::post('/dataTableData',[DataTableController::class, 'getData'])->name('page-data-table');

Route::post('/graphSchedules',[GraphController::class, 'schedulesGraph'])->name('graph-page-schedules');
Route::get('/graphSelectSchedules',[ScheduleController::class, 'schedulesSelectGraph'])->name('select-schedules-graph');

Route::get('/import',[ImportFileController::class, 'index'])->name('import-upload');
Route::post('/import',[ImportFileController::class, 'importData'])->name('import-data');





