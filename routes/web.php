<?php

include 'agency.php';
include 'scheduler.php';

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Panels\Admin\AdminPageController; 

Route::get('/', function () {
    return view('welcome');
});
 
Route::get('/admin/dashboard', [AdminPageController::class, 'dashboard'])->name('Panels.Admin.PageLayout.dashboard');
Route::get('/admin/agency', [AdminPageController::class, 'agency'])->name('Panels.Admin.PageLayout.agency');
Route::get('/admin/manager_schedule', [AdminPageController::class, 'manager_schedule'])->name('Panels.Admin.PageLayout.manager_schedule');
Route::get('/admin/requests', [AdminPageController::class, 'requests'])->name('Panels.Admin.PageLayout.requests');
