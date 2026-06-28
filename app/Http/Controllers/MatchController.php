<?php

namespace App\Http\Controllers;

use App\Models\Matching;
use App\Models\JobPosting;
use App\Services\PythonService;
use App\Services\MatchService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function show($jobId)
    {
        $job = JobPosting::findOrFail($jobId);
        $matches = Matching::where('job_posting_id', $jobId)->get();
        return view('match', compact('job', 'matches'));
    }

    public function generate($jobId, Request $request, PythonService $pythonService, MatchService $matchService)
    {
        $job = JobPosting::findOrFail($jobId);
        $company = Auth::user()->company;

        Matching::where('job_posting_id', $jobId)->delete();

        $job->skills_obrigatorias = $job->required_skills;
        $payload = [
            'vaga' => $job->toArray(),
            'candidatos' => $request->input('candidatos', [])
        ];

        $result = $pythonService->execute($payload);

        if ($result['success']) {
            foreach ($result['shortlist'] as $candidate) {
                $matchService->updateOrCreate([
                    'job_posting_id' => $jobId,
                    'company_id' => $company->id,
                    'skills' => $candidate['skills'],
                    'seniority' => $candidate['seniority'],
                    'score_match' => $candidate['score_match'],
                    'badge_diversidade' => $candidate['badge_diversidade'],
                    'recomendacao' => $candidate['recomendacao'],
                ]);
            }
        }

        return redirect()->route('match.show', $jobId);
    }

    public function selectCandidate($matchingId)
    {
        // Busca o match específico no banco
        $match = \App\Models\Matching::findOrFail($matchingId);

        // Atualiza o status para mostrar que o recrutador gostou
        $match->status = 'selecionado';
        $match->save();

        // Retorna para a mesma tela com um aviso de sucesso
        return back()->with('success', 'Interesse registrado! O candidato foi notificado e a plataforma fará a ponte entre vocês em breve.');
    }
}
