<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;

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
            'resume' => 'required|file|mimes:pdf,docx|max:10240',
        ]);

        $candidate = Auth::user()->candidate ?? Auth::user()->candidate()->create();

        // Store resume file
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $candidate->update(['resume_path' => $path]);
            
            // Simulate AI processing - in a real app, you'd call an AI service here
            // For now, let's store some sample data
            $candidate->update([
                'full_name' => 'Alexandre Silva',
                'phone' => '+55 (11) 99876-5432',
                'city' => 'São Paulo',
                'country' => 'Brasil',
                'linkedin' => 'linkedin.com/in/alexandresilva',
                'portfolio' => 'github.com/alexandresilva',
                'skills' => ['Python', 'Laravel', 'Docker', 'AWS', 'PostgreSQL', 'Git', 'Redis', 'REST APIs'],
                'work_experience' => [
                    [
                        'company' => 'Google',
                        'position' => 'Software Engineer',
                        'start_year' => '2022',
                        'end_year' => 'Present'
                    ],
                    [
                        'company' => 'IBM',
                        'position' => 'Backend Developer',
                        'start_year' => '2019',
                        'end_year' => '2022'
                    ]
                ],
                'education' => [
                    [
                        'degree' => 'Bachelor of Computer Science',
                        'school' => 'University XYZ',
                        'start_year' => '2017',
                        'end_year' => '2021'
                    ]
                ],
                'current_job_title' => 'Senior Backend Developer',
                'years_experience' => 5,
                'professional_summary' => 'Backend Engineer with 5 years of experience building scalable APIs and microservices using modern technologies. Proficient in cloud platforms and database management.',
                'languages' => [
                    ['name' => 'English', 'level' => 'Fluent'],
                    ['name' => 'Spanish', 'level' => 'Intermediate'],
                    ['name' => 'Portuguese', 'level' => 'Native']
                ],
                'desired_position' => 'Backend Developer',
                'employment_type' => ['Full-time'],
                'work_model' => ['Remote'],
                'salary_expectation' => '150000',
                'salary_currency' => 'BRL',
                'availability' => 'Immediately',
            ]);
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
