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
Route::get('/tourSelection', [TaskController::class, 'getTours'])->name('select-tours');
Route::get('/chargerSelection', [ChargerTaskController::class, 'getChargers'])->name('select-chargers');
Route::get('/scheduleSelection', [ScheduleController::class, 'getFilteredSchedules'])->name('select-schedules');
Route::get('/dataTableSelection', [DataTableController::class, 'getTableNames'])->name('select-table-view');

Route::get('/taskGrafikon', [GrafikonController::class, 'getTaskGrafikon'])->name('select-task-grafikon');
Route::get('/scheduleGrafikon', [GrafikonController::class, 'getScheduleGrafikon'])->name('select-schedule-grafikon');

Route::get('/dataTableChargerTaskview',[DataTableController::class, 'getChargerTaskDataTable'])->name('page-data-table-chargertask');
Route::get('/dataTableScheduleview',[DataTableController::class, 'getScheduleDataTable'])->name('page-data-table-schedule');
Route::get('/dataTableTaskview',[DataTableController::class, 'getTaskDataTable'])->name('page-data-table-task');

Route::post('/ganttTours',[GanttController::class, 'toursGantt'])->name('gantt-page-tours');
Route::post('/ganttChargers',[GanttController::class, 'chargersGantt'])->name('gantt-page-chargers');
Route::post('/ganttSchedules',[GanttController::class, 'schedulesGantt'])->name('gantt-page-schedules');
Route::post('/dataTableData',[DataTableController::class, 'getData'])->name('page-data-table');

Route::post('/graphSchedules',[GraphController::class, 'schedulesGraph'])->name('graph-page-schedules');
Route::get('/graphSelectSchedules',[ScheduleController::class, 'schedulesSelectGraph'])->name('select-schedules-graph');

Route::get('/import',[ImportFileController::class, 'index'])->name('import-upload');
Route::post('/import',[ImportFileController::class, 'importData'])->name('import-data');





