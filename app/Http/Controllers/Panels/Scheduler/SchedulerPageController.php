<?php

namespace App\Http\Controllers\Panels\Scheduler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchedulerPageController extends Controller
{
    public function scheduler_login () {
        return view('Panels.Scheduler.Auth.login');
    }

    public function dashboard () {
        return view('Panels.Scheduler.Pages.Dashboard.dashboard');
    }

    public function announcement () {
        return view('Panels.Scheduler.Pages.Dashboard.announcement');
    }

    public function crew_schedule () {
        return view('Panels.Scheduler.Pages.crew_schedule');
    }
    
    public function crew_availability () {
        return view('Panels.Scheduler.Pages.crew_availability');
    }

    public function requests () {
        return view('Panels.Scheduler.Pages.requests');
    }

    public function shift_history () {
        return view('Panels.Scheduler.Pages.shift_history');
    }

    public function settings () {
        return view('Panels.Scheduler.Pages.settings');
    }
}
