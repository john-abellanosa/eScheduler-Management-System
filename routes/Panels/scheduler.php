<?php 

use Illuminate\Support\Facades\Route;
 
use App\Http\Controllers\Panels\Scheduler\SchedulerPageController;


Route::get('/scheduler/dashboard', [SchedulerPageController::class, 'dashboard'])->name('Panels.Scheduler.PageLayout.dashboard');
Route::get('/scheduler/crew_schedule', [SchedulerPageController::class, 'crew_schedule'])->name('Panels.Scheduler.PageLayout.crew_schedule');
Route::get('/scheduler/requests', [SchedulerPageController::class, 'requests'])->name('Panels.Scheduler.PageLayout.requests');

