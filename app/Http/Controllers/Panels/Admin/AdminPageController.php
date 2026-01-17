<?php

namespace App\Http\Controllers\Panels\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function admin_login () {
        return view ('Panels.Admin.Auth.login');
    }

    public function dashboard () {
        return view('Panels.Admin.Pages.Dashboard.dashboard');
    }

    public function announcement () {
        return view('Panels.Admin.Pages.Dashboard.announcement');
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
        return view('Panels.Admin.Pages.Employee_Management.crew');
    }

    public function manager () {
        return view('Panels.Admin.Pages.Employee_Management.manager');
    }

    public function crew_shift_history () {
        return view ('Panels.Admin.Pages.Shift_History.crew');
    }

    public function manager_shift_history () {
        return view ('Panels.Admin.Pages.Shift_History.manager');
    }

    public function max_crew_management () {
        return view ('Panels.Admin.Pages.max_crew_management');
    }

    public function schedule_overview () {
        return view ('Panels.Admin.Pages.schedule_overview');
    }

    public function position_setup () {
        return view ('Panels.Admin.Pages.units&position_setup');
    }
}
