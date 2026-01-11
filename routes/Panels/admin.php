<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Panels\Admin\AdminPageController; 

 
Route::get('/admin/dashboard', [AdminPageController::class, 'dashboard'])->name('Panels.Admin.PageLayout.dashboard');
Route::get('/admin/agency', [AdminPageController::class, 'agency'])->name('Panels.Admin.PageLayout.agency');
Route::get('/admin/manager_schedule', [AdminPageController::class, 'manager_schedule'])->name('Panels.Admin.PageLayout.manager_schedule');
Route::get('/admin/requests', [AdminPageController::class, 'requests'])->name('Panels.Admin.PageLayout.requests');
Route::get('/admin/crew', [AdminPageController::class, 'crew'])->name('Panels.Admin.PageLayout.crew');
Route::get('/admin/managers', [AdminPageController::class, 'manager'])->name('Panels.Admin.PageLayout.manager');

Route::get('/admin/login', [AdminPageController::class, 'admin_login'])->name('Panels.Admin.Auth.login');
