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

        $diversityScore = $diversityScoreService->calculate($company);

        // Get AI recommendation data
        $highScoreMatchings = Matching::where('company_id', $company->id)
            ->where('score_match', '>=', 80)
            ->count();

        $topRegions = $highScoreMatchings = Matching::where('company_id', $company->id)
            ->where('score_match', '>=', 80)
            ->count();


        return view('reports', compact('company', 'diversityGoals', 'esgGoals', 'diversityScore', 'highScoreMatchings', 'topRegions'));
    }

    public function downloadPdf(DiversityScoreService $diversityScoreService)
    {
        $company = auth()->user()->company;
        $diversityGoals = $company->diversityGoals;
        $esgGoals = $company->esgGoals;

        $diversityScore = $diversityScoreService->calculate($company);

        // Get AI recommendation data
        $highScoreMatchings = Matching::where('company_id', $company->id)
            ->where('score_match', '>=', 80)
            ->count();

        $topRegions = $highScoreMatchings = Matching::where('company_id', $company->id)
            ->where('score_match', '>=', 80)
            ->count();

        // Return PDF (will work once barryvdh/laravel-dompdf is installed)
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports-pdf', compact('company', 'diversityGoals', 'esgGoals', 'diversityScore', 'highScoreMatchings', 'topRegions'));
        return $pdf->download('relatorio-diversidade-' . now()->format('Y-m-d') . '.pdf');
    }
}
