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

    public function generate($jobId, Request $request, PythonService $pythonService)
    {
        $job = JobPosting::findOrFail($jobId);
        $company = Auth::user()->company;

        // 🔒 BLOQUEIO: já gerou?
        if ($job->matches_generated) {
            return redirect()->route('match.show', $jobId)
                ->with('error', 'Matches já foram gerados para esta vaga.');
        }

        // payload simples
        $payload = [
            'vaga' => [
                'skills_obrigatorias' => $job->required_skills,
            ]
        ];

        $result = $pythonService->execute($payload);

        if ($result['success']) {

            foreach ($result['shortlist'] as $candidate) {

                Matching::create([
                    'job_posting_id' => $jobId,
                    'company_id' => $company->id,

                    // identidade estável do candidato
                    'external_id' => $candidate['external_id'],

                    'skills' => $candidate['skills'],
                    'seniority' => $candidate['seniority'],
                    'score_match' => $candidate['score_match'],
                    'badge_diversidade' => $candidate['badge_diversidade'],
                    'recomendacao' => $candidate['recomendacao'],
                ]);
            }

            // 🔒 TRAVA FINAL
            $job->matches_generated = true;
            $job->save();
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
