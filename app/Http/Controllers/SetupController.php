<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\CompanyDiversityGoal;
use App\Models\EsgGoal;
use App\Models\AiPreference;

class SetupController extends Controller
{
    public function step1()
    {
        $company = Auth::user()->company;

        #dd(Auth::user(), Auth::user()->company);

        if (!$company) {
            abort(500, 'Empresa não encontrada para o usuário.');
        }

        return view('setup.step1', compact('company'));
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'size' => 'required|in:1-10,11-50,51-200,201-1000,1000+',
            'work_model' => 'required|in:remote,hybrid,on-site',
            'inclusion_programs' => 'array',
            'diversity_statement' => 'nullable|string',
        ]);

        $company = Auth::user()->company;
        $company->update($validated);

        return redirect()->route('setup.step2');
    }

    public function step2()
    {
        $company = Auth::user()->company;
        $goals = $company->diversityGoals;
        return view('setup.step2', compact('company', 'goals'));
    }

    public function postStep2(Request $request)
    {
        $validated = $request->validate([
            'groups' => 'array',
            'priorities' => 'array',
            'target_percentage' => 'nullable|integer|min:0|max:100',
            'target_year' => 'nullable|integer',
        ]);

        $company = Auth::user()->company;

        // Deletar metas antigas
        $company->diversityGoals()->delete();

        // Criar novas metas
        if (isset($validated['groups'])) {
            foreach ($validated['groups'] as $group) {
                $company->diversityGoals()->create([
                    'group' => $group,
                    'priority' => $validated['priorities'][$group] ?? 'medium',
                    'target_percentage' => $validated['target_percentage'] ?? null,
                    'target_year' => $validated['target_year'] ?? null,
                ]);
            }
        }

        return redirect()->route('setup.step3');
    }

    public function step3()
    {
        $company = Auth::user()->company;
        $esgGoals = $company->esgGoals;
        return view('setup.step3', compact('company', 'esgGoals'));
    }

    public function postStep3(Request $request)
    {
        $validated = $request->validate([
            'esg_goals' => 'array',
            'custom_title' => 'nullable|string',
            'custom_target' => 'nullable|integer',
            'custom_deadline' => 'nullable|date',
        ]);

        $company = Auth::user()->company;

        // Metas predefinidas
        $predefinedGoals = [
            'environmental' => [
                'reduce_paper' => ['title' => 'Reduzir o uso de papel', 'pillar' => 'environmental'],
                'reduce_emissions' => ['title' => 'Reduce emissions', 'pillar' => 'environmental'],
                'renewable_energy' => ['title' => 'Renewable energy adoption', 'pillar' => 'environmental'],
                'other_env' => ['title' => 'Other', 'pillar' => 'environmental'],
            ],
            'social' => [
                'hire_underrepresented' => ['title' => 'Hire underrepresented talent', 'pillar' => 'social'],
                'mentorship' => ['title' => 'Mentorship programs', 'pillar' => 'social'],
                'accessibility' => ['title' => 'Accessibility improvements', 'pillar' => 'social'],
                'community' => ['title' => 'Community engagement', 'pillar' => 'social'],
                'scholarships' => ['title' => 'Scholarships', 'pillar' => 'social'],
            ],
            'governance' => [
                'anti_bias' => ['title' => 'Anti-bias recruitment process', 'pillar' => 'governance'],
                'dei_training' => ['title' => 'DEI training', 'pillar' => 'governance'],
                'anonymous_reporting' => ['title' => 'Anonymous reporting channel', 'pillar' => 'governance'],
                'compliance' => ['title' => 'Compliance audits', 'pillar' => 'governance'],
            ],
        ];

        // Deletar metas antigas
        $company->esgGoals()->delete();

        // Padronizar metas para uma busca mais fácil
        $flattenedGoals = [];
        foreach ($predefinedGoals as $pillar => $goals) {
            foreach ($goals as $key => $goal) {
                $flattenedGoals[$key] = $goal;
            }
        }

        // Criar metas selecionadas predefinidas
        if (isset($validated['esg_goals'])) {
            foreach ($validated['esg_goals'] as $goalKey) {
                if (isset($flattenedGoals[$goalKey])) {
                    $company->esgGoals()->create([
                        'title' => $flattenedGoals[$goalKey]['title'],
                        'pillar' => $flattenedGoals[$goalKey]['pillar'],
                        'status' => 'IN_PROGRESS',
                    ]);
                }
            }
        }

        // Criar uma personalizada
        if ($validated['custom_title']) {
            $company->esgGoals()->create([
                'title' => $validated['custom_title'],
                'pillar' => 'custom',
                'target_value' => $validated['custom_target'] ?? null,
                'deadline' => $validated['custom_deadline'] ?? null,
                'status' => 'PENDING',
            ]);
        }

        return redirect()->route('setup.step4');
    }

    public function step4()
    {
        $company = Auth::user()->company;
        $preferences = $company->aiPreferences ?? new AiPreference();
        return view('setup.step4', compact('company', 'preferences'));
    }

    public function postStep4(Request $request)
    {
        $validated = $request->validate([
            'matching_priority' => 'array',
            'candidate_radius' => 'required|integer'
        ]);

        $company = Auth::user()->company;

        $company->aiPreferences()->updateOrCreate(
            ['company_id' => $company->id],
            [
                'matching_priority' => $validated['matching_priority'] ?? ['technical_skills', 'diversity_goals', 'location', 'experience', 'education'],
                'candidate_radius' => $validated['candidate_radius'],
                'include_remote' => $request->has('include_remote')
            ]
        );

        return redirect()->route('setup.review');
    }

    public function review()
    {
        $company = Auth::user()->company;
        $goals = $company->diversityGoals;
        $esgGoals = $company->esgGoals;
        $preferences = $company->aiPreferences;
        return view('setup.review', compact('company', 'goals', 'esgGoals', 'preferences'));
    }

    public function finish()
    {
        $company = Auth::user()->company;
        $company->update(['setup_completed' => true]);

        return redirect()->route('dashboard');
    }
}
