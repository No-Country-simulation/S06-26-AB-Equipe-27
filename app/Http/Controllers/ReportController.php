<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matching;
use App\Models\JobPosting;
use App\Services\DiversityScoreService;

class ReportController extends Controller
{
    public function index(DiversityScoreService $diversityScoreService)
    {
        $company = auth()->user()->company;
        $diversityGoals = $company->diversityGoals;
        $esgGoals = $company->esgGoals;
        $diversityScore = $diversityScoreService->calculate($company);

        $highScoreMatchings = Matching::where('company_id', $company->id)
            ->where('score_match', '>=', 80)
            ->count();

        $topRegions = JobPosting::where('company_id', $company->id)
            ->select('city')
            ->selectRaw('COUNT(city) as total')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->take(3)
            ->pluck('city');

        return view('reports', compact('company', 'diversityGoals', 'esgGoals', 'diversityScore', 'highScoreMatchings', 'topRegions'));
    }

    public function downloadPdf(DiversityScoreService $diversityScoreService)
    {
        $company = auth()->user()->company;
        $diversityGoals = $company->diversityGoals;
        $esgGoals = $company->esgGoals;
        $diversityScore = $diversityScoreService->calculate($company);

        $highScoreMatchings = Matching::where('company_id', $company->id)
            ->where('score_match', '>=', 80)
            ->count();

        $topRegions = JobPosting::where('company_id', $company->id)
            ->select('city')
            ->selectRaw('COUNT(city) as total')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->take(3)
            ->pluck('city');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports-pdf', compact('company', 'diversityGoals', 'esgGoals', 'diversityScore', 'highScoreMatchings', 'topRegions'));

        $filename = 'relatorio-diversidade-' . now()->format('Y-m-d') . '.pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Length', strlen($pdf->output()));
    }
}
