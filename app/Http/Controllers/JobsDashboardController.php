<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Services\JobService;

class JobsDashboardController extends Controller
{
    # MÃ©todo essencial para percorrer array em View.
    public function index()
    {
        $jobs = JobPosting::where('company_id', auth()->user()->company->id)->latest()->get();
        return view('dashboard/jobs', compact('jobs'));
    }
}
