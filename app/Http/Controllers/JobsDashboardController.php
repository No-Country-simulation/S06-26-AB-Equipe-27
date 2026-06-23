<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Services\JobService;

class JobsDashboardController extends Controller
{
    # Método essencial para percorrer array em View.
    public function index()
    {
        $jobs = JobPosting::latest()->take(5)->get();
        return view('dashboard/jobs', compact('jobs'));
    }
}
