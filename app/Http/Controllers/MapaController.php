<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Services\JobService;

class MapaController extends Controller
{
    public function index()
    {
        // 1. Mantém a busca original das vagas (Não mexer aqui)
        $jobs = JobPosting::where('company_id', auth()->user()->company->id)->latest()->get();

        // 2. Adiciona os dados do mapa de calor (Baseado no seu dataset tensor_od.csv)
        // Estrutura: [latitude, longitude, intensidade]
        $heatPoints = [
            [-27.595, -48.556, 0.9], // Centro / Beiramar
            [-27.590, -48.550, 0.8],
            [-27.588, -48.570, 0.7], // Estreito-Capoeiras
            [-27.600, -48.520, 0.6], // Trindade / UFSC
            [-27.675, -48.490, 0.5], // Campeche
            [-27.620, -48.650, 0.3], // Palhoça
            [-27.560, -48.620, 0.4]  // São José
        ];

        // 3. Inclui a nova variável 'heatPoints' no compact()
        return view('mapa', compact('jobs', 'heatPoints'));
    }
}
