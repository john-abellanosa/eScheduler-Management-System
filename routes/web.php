<?php

include 'Panels/agency.php';
include 'Panels/scheduler.php';
include 'Panels/admin.php';

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Panels.Scheduler.Auth.login');
});
