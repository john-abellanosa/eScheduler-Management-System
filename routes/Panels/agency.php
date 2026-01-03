<?php

use Illuminate\Support\Facades\Route;
 
use App\Http\Controllers\Panels\Agency\AgencyPageController; 

// AGENCY PANEL 
Route::get('/agency/dashboard', [AgencyPageController::class, 'dashboard'])->name('Panels.Agency.PageLayout.dashboard');
Route::get('/agency/crew_management', [AgencyPageController::class, 'crew_management'])->name('Panels.Agency.PageLayout.crew_management');
Route::get('/agency/deployment', [AgencyPageController::class, 'deployment'])->name('Panels.Agency.PageLayout.deployment');
