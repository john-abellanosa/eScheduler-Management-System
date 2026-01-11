<?php

namespace App\Http\Controllers\Panels\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function dashboard () {
        return view('Panels.Admin.Pages.dashboard');
    }

    public function agency () {
        return view('Panels.Admin.Pages.agency');
    }

    public function manager_schedule () {
        return view('Panels.Admin.Pages.manager_schedule');
    }

    public function requests () {
        return view('Panels.Admin.Pages.requests');
    }

    public function crew () {
        return view('Panels.Admin.Pages.crew');
    }

    public function manager () {
        return view('Panels.Admin.Pages.manager');
    }

    public function admin_login () {
        return view ('Panels.Admin.Auth.login');
    }
}
