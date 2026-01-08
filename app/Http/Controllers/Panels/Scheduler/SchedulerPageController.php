<?php

namespace App\Http\Controllers\Panels\Scheduler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchedulerPageController extends Controller
{
    public function dashboard(){
        return view('Panels.Scheduler.Pages.dashboard');
    }

    public function crew_schedule(){
        return view('Panels.Scheduler.Pages.crew_schedule');
    }
    
    public function crew_availability(){
        return view('Panels.Scheduler.Pages.crew_availability');
    }

    public function requests(){
        return view('Panels.Scheduler.Pages.requests');
    }
}
