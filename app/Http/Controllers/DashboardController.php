<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Services\JobService;

class DashboardController extends Controller
{
    # Método essencial para percorrer array em View e plotar o mapa de calor
    public function index()
    {
        // 1. Mantém a busca original das vagas (Não mexer aqui)
        $jobs = JobPosting::where('company_id', auth()->user()->company->id)->latest()->get();
        // 3. Inclui a nova variável 'heatPoints' no compact()
        return view('dashboard', compact('jobs'));
    }
}
