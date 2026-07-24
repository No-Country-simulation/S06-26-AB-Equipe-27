<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Candidate;
use App\Services\PythonService;

class CandidateSetupController extends Controller
{
    public function step1()
    {
        // Get or create candidate for the user
        $candidate = Auth::user()->candidate ?? Auth::user()->candidate()->create();
        return view('candidate-setup.step1', compact('candidate'));
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'resume' => 'required|file|mimes:pdf|max:10240',
        ]);

        $candidate = Auth::user()->candidate ?? Auth::user()->candidate()->create();

        // Store resume file
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $candidate->update(['resume_path' => $path]);

            $pdfContent = file_get_contents(Storage::disk('public')->path($path));
            $pdfBase64 = base64_encode($pdfContent);

            try {
                $pythonService = app(PythonService::class);
                $result = $pythonService->processResume([
                    'action' => 'extract',
                    'pdf_base64' => $pdfBase64,
                ]);

                if ($result['success']) {
                    $dados = $result['dados_candidato'];

                    $candidateData = [
                        'full_name' => $dados['nome'] ?? '',
                        'phone' => $dados['telefone'] ?? '',
                        'city' => $dados['cidade'] ?? '',
                        'country' => $dados['estado'] ?? '',
                        'skills' => $dados['skills'] ?? [],
                        'education' => collect($dados['formacao'] ?? [])->map(function ($degree, $index) use ($dados) {
                            return [
                                'degree' => $degree,
                                'school' => $dados['instituicao'][$index] ?? '',
                            ];
                        })->filter(fn($item) => filled($item['degree']))->values()->all(),
                    ];

                    $candidate->update($candidateData);
                }
            } catch (\Exception $e) {
                // If AI processing fails, we just store the resume path and move on
            }
        }

        return redirect()->route('candidate-setup.step2');
    }

    public function step2()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step2', compact('candidate'));
    }

    public function postStep2(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'portfolio' => 'nullable|string|max:255',
        ]);

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.step3');
    }

    public function step3()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step3', compact('candidate'));
    }

    public function postStep3(Request $request)
    {
        $validated = $request->validate([
            'current_job_title' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer',
            'professional_summary' => 'nullable|string',
            'skills' => 'nullable|array',
            'languages' => 'nullable|array',
            'languages.*.name' => 'nullable|string|max:255',
            'languages.*.level' => 'nullable|string|max:255',
        ]);

        $validated['languages'] = collect($validated['languages'] ?? [])
            ->filter(fn ($language) => filled($language['name'] ?? null))
            ->values()
            ->all();

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.step4');
    }

    public function step4()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step4', compact('candidate'));
    }

    public function postStep4(Request $request)
    {
        $validated = $request->validate([
            'work_experience' => 'nullable|array',
        ]);

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.step5');
    }

    public function step5()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step5', compact('candidate'));
    }

    public function postStep5(Request $request)
    {
        $validated = $request->validate([
            'education' => 'nullable|array',
        ]);

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.step6');
    }

    public function step6()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step6', compact('candidate'));
    }

    public function postStep6(Request $request)
    {
        $validated = $request->validate([
            'desired_position' => 'nullable|string|max:255',
            'employment_type' => 'nullable|array',
            'work_model' => 'nullable|array',
            'salary_expectation' => 'nullable|string|max:255',
            'salary_currency' => 'nullable|string|max:10',
            'availability' => 'nullable|string|max:255',
        ]);

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.finish');
    }

    public function finish()
    {
        $candidate = Auth::user()->candidate;
        $candidate->update(['setup_completed' => true]);

        return redirect()->route('dashboard');
    }
}
