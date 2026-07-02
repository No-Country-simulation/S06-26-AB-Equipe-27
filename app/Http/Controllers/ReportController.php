<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matching;
use App\Services\DiversityScoreService;

class ReportController extends Controller
{
    public function index(DiversityScoreService $diversityScoreService)
    {
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

        $topRegions = JobPosting::where('company_id', $company->id)
            ->select('city')
            ->selectRaw('COUNT(city) as total')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->take(3)
            ->pluck('city'); // Extracts just the city column value into a collection


        return view('reports', compact('company', 'diversityGoals', 'esgGoals', 'diversityScore', 'highScoreMatchings', 'topRegions'));
    }

    public function downloadPdf(DiversityScoreService $diversityScoreService)
    {
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

        $topRegions = JobPosting::where('company_id', $company->id)
            ->select('city')
            ->selectRaw('COUNT(city) as total')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->take(3)
            ->pluck('city'); // Extracts just the city column value into a collection

        echo $topRegions;

        // Return PDF (will work once barryvdh/laravel-dompdf is installed)
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports-pdf', compact('company', 'diversityGoals', 'esgGoals', 'diversityScore', 'highScoreMatchings', 'topRegions'));
        return $pdf->download('relatorio-diversidade-' . now()->format('Y-m-d') . '.pdf');
    }
}
