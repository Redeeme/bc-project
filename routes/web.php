<?php

use App\Http\Controllers\ChargerTaskController;
use App\Http\Controllers\GanttController;
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
Route::post('/ganttTours',[GanttController::class, 'toursGantt'])->name('gantt-page-tours');
Route::post('/ganttChargers',[GanttController::class, 'chargersGantt'])->name('gantt-page-chargers');
Route::post('/ganttSchedules',[GanttController::class, 'schedulesGantt'])->name('gantt-page-schedules');

