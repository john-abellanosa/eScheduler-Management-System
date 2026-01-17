<?php 

use Illuminate\Support\Facades\Route;
 
use App\Http\Controllers\Panels\Scheduler\SchedulerPageController;


Route::get('/scheduler/dashboard', [SchedulerPageController::class, 'dashboard'])->name('Panels.Scheduler.Pages.Dashboard.dashboard');
Route::get('/scheduler/announcement', [SchedulerPageController::class, 'announcement'])->name('Panels.Scheduler.Pages.Dashboard.announcement');
Route::get('/scheduler/crew_schedule', [SchedulerPageController::class, 'crew_schedule'])->name('Panels.Scheduler.Pages.crew_schedule');
Route::get('/scheduler/crew_availability', [SchedulerPageController::class, 'crew_availability'])->name('Panels.Scheduler.Pages.crew_availability');
Route::get('/scheduler/requests', [SchedulerPageController::class, 'requests'])->name('Panels.Scheduler.Pages.requests');
Route::get('/scheduler/shift_history', [SchedulerPageController::class, 'shift_history'])->name('Panels.Scheduler.Pages.shift_history');
Route::get('/scheduler/settings', [SchedulerPageController::class, 'settings'])->name('Panels.Scheduler.Pages.settings');

Route::get('/scheduler/login', [SchedulerPageController::class, 'scheduler_login'])->name('Panels.Scheduler.Auth.login');

