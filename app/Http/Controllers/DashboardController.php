<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Models\Matching;
use App\Services\JobService;
use App\Services\DiversityScoreService;

class DashboardController extends Controller
{
    # Método essencial para percorrer array em View e plotar o mapa de calor
    public function index(DiversityScoreService $diversityScoreService)
    {
        // 1. Mantém a busca original das vagas (Não mexer aqui)
        $jobs = JobPosting::where('company_id', auth()->user()->company->id)->latest()->get();
        // Calculate diversity score
        $company = auth()->user()->company;

        $diversityGoals = $company->diversityGoals;
        $esgGoals = $company->esgGoals;

        $totalWeightedScore = 0;
        $maxPossibleScore = 0;

        $priorityWeights = [
            'low' => 1,
            'medium' => 2,
            'high' => 3,
        ];

        foreach ($diversityGoals as $goal) {
            $weight = $priorityWeights[$goal->priority] ?? 1;
            $progress = $goal->current_value ?? 0;

            $totalWeightedScore += $weight * $progress;
            $maxPossibleScore += $weight * 100;
        }

        $diversityScore = $maxPossibleScore > 0 ? round(($totalWeightedScore / $maxPossibleScore) * 100) : 0;

        $diversityScore = $diversityScoreService->calculate($company);

        // Get AI recommendation data
        $highScoreMatchings = Matching::where('company_id', $company->id)
            ->where('score_match', '>=', 80)
            ->count();

        // Get top 3 regions (we'll mock for now but structure is there)
        $topRegions = JobPosting::where('company_id', $company->id)
            ->select('city')
            ->selectRaw('COUNT(city) as total') // Define um alias para o contador
            ->groupBy('city')
            ->orderBy('total', 'desc')        // Ordena utilizando o alias definido
            ->take(3)
            ->get();

        // 3. Inclui a nova variável 'heatPoints' no compact()
        return view('dashboard', compact('jobs', 'diversityScore', 'esgGoals', 'diversityGoals', 'company', 'highScoreMatchings', 'topRegions'));
    }
}
