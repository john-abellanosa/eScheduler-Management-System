<?php

namespace App\Http\Controllers\Panels\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgencyPageController extends Controller
{
    public function dashboard (){
        return view('Panels.Agency.Pages.dashboard');
    }

    public function applicant_management (){
        return view('Panels.Agency.Pages.applicant_management');
    }

    public function deployment (){
        return view('Panels.Agency.Pages.deployment');
    }
}
