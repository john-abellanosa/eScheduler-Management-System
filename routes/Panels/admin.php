<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Panels\Admin\AdminPageController; 

 
Route::get('/admin/dashboard', [AdminPageController::class, 'dashboard'])->name('Panels.Admin.Pages.dashboard');
Route::get('/admin/agency', [AdminPageController::class, 'agency'])->name('Panels.Admin.Pages.agency');
Route::get('/admin/manager_schedule', [AdminPageController::class, 'manager_schedule'])->name('Panels.Admin.Pages.manager_schedule');
Route::get('/admin/requests', [AdminPageController::class, 'requests'])->name('Panels.Admin.Pages.requests');
Route::get('/admin/employee_management/crew', [AdminPageController::class, 'crew'])->name('Panels.Admin.Pages.Employee_Management.crew');
Route::get('/admin/employee_management/managers', [AdminPageController::class, 'manager'])->name('Panels.Admin.Pages.Employee_Management.manager');
Route::get('/admin/shift_history/crew', [AdminPageController::class, 'crew_shift_history'])->name('Panels.Admin.Pages.Shift_History.crew');
Route::get('/admin/shift_history/managers', [AdminPageController::class, 'manager_shift_history'])->name('Panels.Admin.Pages.Shift_History.manager');
Route::get('/admin/max_crew_management', [AdminPageController::class, 'max_crew_management'])->name('Panels.Admin.Pages.max_crew_management');
Route::get('/admin/schedule_overview', [AdminPageController::class, 'schedule_overview'])->name('Panels.Admin.Pages.schedule_overview');

Route::get('/admin/login', [AdminPageController::class, 'admin_login'])->name('Panels.Admin.Auth.login');
