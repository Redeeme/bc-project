<?php

use App\DataTables\ChargerTaskDataTableUnit;
use App\DataTables\SchedulesDataTableUnit;
use App\DataTables\TaskDataTableUnit;
use App\Http\Controllers\ChargerTaskController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\GanttController;
use App\Http\Controllers\GrafikonController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ImportFileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StatController;
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

Route::get('/datasetsSelection', [HelpController::class, 'getDatasets'])->name('get-datasets');
Route::post('/datasetSelect', [HelpController::class, 'getDataset'])->name('get-dataset');

Route::get('/tourSelection/{dataset}', [TaskController::class, 'getTour'])->name('select-tours');
Route::get('/chargerSelection/{dataset}', [ChargerTaskController::class, 'getCharger'])->name('select-chargers');
Route::get('/scheduleSelection/{dataset}', [ScheduleController::class, 'getSchedule'])->name('select-schedules');

Route::post('/ganttTours', [GanttController::class, 'tourGantt'])->name('gantt-tour');
Route::post('/ganttChargers', [GanttController::class, 'chargerGantt'])->name('gantt-charger');
Route::post('/ganttSchedules', [GanttController::class, 'scheduleGantt'])->name('gantt-schedule');

Route::post('/tableTours', [DataTableController::class, 'tourTable'])->name('table-tour');
Route::post('/tableChargers', [DataTableController::class, 'chargerTable'])->name('table-charger');
Route::post('/tableSchedules', [DataTableController::class, 'scheduleTable'])->name('table-schedule');

Route::post('/statsTours', [TaskController::class, 'tourStats'])->name('stats-tour');
Route::post('/statsChargers', [ChargerTaskController::class, 'chargerStats'])->name('stats-charger');
Route::post('/statsSchedules', [ScheduleController::class, 'scheduleStats'])->name('stats-schedule');

Route::get('/dataTableSelection', [DataTableController::class, 'getTableNames'])->name('select-table-view');
Route::get('/scheduleGrafikon', [GrafikonController::class, 'getScheduleGrafikon'])->name('select-schedule-grafikon');
Route::get('/scheduleStationsGrafikon', [GrafikonController::class, 'getScheduleStationsGrafikon'])->name('select-schedule-stations-grafikon');

Route::get('/dataTableChargerTaskview', [DataTableController::class, 'getChargerTaskDataTable'])->name('page-data-table-charger-task');
Route::get('/dataTableScheduleview', [DataTableController::class, 'getScheduleDataTable'])->name('page-data-table-schedule');
Route::get('/dataTableTaskview', [DataTableController::class, 'getTaskDataTable'])->name('page-data-table-task');
Route::post('/dataTableData', [DataTableController::class, 'getData'])->name('page-data-table');

Route::post('/graphSchedules', [GraphController::class, 'schedulesGraph'])->name('graph-page-schedules');

Route::get('/graphSelectSchedulesDatasets', [HelpController::class, 'getSchedulesDatasets'])->name('select-schedules-graph-datasets');
Route::post('/graphSelectSchedulesDataset', [HelpController::class, 'getSchedulesDataset'])->name('select-schedules-graph-dataset');
Route::get('/graphSelectSchedules/{dataset}', [ScheduleController::class, 'schedulesSelectGraph'])->name('select-schedules-graph');

Route::get('/import', [ImportFileController::class, 'index'])->name('import-upload');
Route::post('/import', [ImportFileController::class, 'importData'])->name('import-data');

Route::get('datatableUnitschedule/{id}/{dataset}/{name}/{type}', function (SchedulesDataTableUnit $dataTable, $id, $dataset, $name, $type) {
    return $dataTable->with('dataset', $dataset)->with('id', $id)->with('type', $type)
        ->render('dataTableViewUnit', $data = ['dataset' => $dataset, 'scheduleFlag' => $id, 'type' => $type, 'name' => $name]);
})->name('page-data-table-schedule-unit');

Route::get('datatableUnitcharger/{id}/{dataset}/{name}', function (ChargerTaskDataTableUnit $dataTable, $id, $dataset, $name) {
    return $dataTable->with('dataset', $dataset)->with('id', $id)
        ->render('dataTableViewUnit', $data = ['dataset' => $dataset, 'chargerFlag' => $id, 'name' => $name]);
})->name('page-data-table-charger-task-unit');

Route::get('datatableUnittour/{id}/{dataset}/{name}', function (TaskDataTableUnit $dataTable, $id, $dataset, $name) {
    return $dataTable->with('dataset', $dataset)->with('id', $id)
        ->render('dataTableViewUnit', $data = ['dataset' => $dataset, 'tourFlag' => $id, 'name' => $name]);
})->name('page-data-table-task-unit');

//stats
Route::get('/statsSelection', [StatController::class, 'indexSelection'])->name('get-stats');

Route::get('stats/{table}/{type}', [StatController::class, 'indexDatasetSelection'])->name('get-stat-dataset');

Route::post('stats/dataset/{table}/{type}', [StatController::class, 'getStat'])->name('get-stat');

Route::get('stats/chargers-stat-utilization/{table}/{type}/{dataset}', [StatController::class, 'chargersStatUtil'])->name('chargers-stat-utilization');
Route::get('stats/schedules-stat-clip/{table}/{type}/{dataset}', [StatController::class, 'schedulesStatClip'])->name('schedules-stat-clip');
Route::get('stats/schedules-stat-charging/{table}/{type}/{dataset}', [StatController::class, 'schedulesStatCharging'])->name('schedules-stat-charging');
Route::get('stats/schedules-stat-utilization/{table}/{type}/{dataset}', [StatController::class, 'schedulesStatUtil'])->name('schedules-stat-utilization');
Route::get('stats/schedules-stat-trips/{table}/{type}/{dataset}', [StatController::class, 'schedulesStatTrips'])->name('schedules-stat-trips');

Route::post('stats/chargers-stat-interval-length/{table}/{type}/{dataset}', [StatController::class, 'chargersStatIntLength'])->name('chargers-stat-interval-length');
Route::get('stats/chargers-stat-interval-length-Selection/{table}/{type}/{dataset}', [StatController::class, 'chargersStatIntLengthSelection'])->name('chargers-stat-interval-length-Selection');
Route::post('stats/chargers-stat-interval-count/{table}/{type}/{dataset}', [StatController::class, 'chargersStatIntCount'])->name('chargers-stat-interval-count');
Route::get('stats/chargers-stat-interval-count-Selection/{table}/{type}/{dataset}', [StatController::class, 'chargersStatIntCountSelection'])->name('chargers-stat-interval-count-Selection');

//stats
Route::get('/datasets', [HelpController::class, 'indexDataset'])->name('datasets');
Route::delete('/datasets/{id}/{table}', [HelpController::class, 'deleteDataset'])->name('delete-dataset');
Route::get('/datasets/refresh', [HelpController::class, 'refreshDatasets'])->name('refresh');

