<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Services\JobService;

class DashboardController extends Controller
{
    # Método essencial para percorrer array em View.
        public function index(){
        $jobs = JobPosting::latest()->take(5)->get();
        return view('dashboard', compact('jobs'));
    }
}
