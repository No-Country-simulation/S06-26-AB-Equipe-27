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
            'target_value' => 'nullable|integer|min:0|max:100',
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
                    'target_value' => $validated['target_value'] ?? null,
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
            'goal_keys' => 'array',
            'custom_goals' => 'array',
            'custom_goals.*.title' => 'nullable|string',
            'custom_goals.*.pillar' => 'nullable|in:environmental,social,governance',
            'custom_goals.*.target_value' => 'nullable|integer',
            'custom_goals.*.deadline' => 'nullable|date',
        ]);

        $company = Auth::user()->company;

        // Metas predefinidas
        $predefinedGoals = [
            'environmental' => [
                'ecologic_preservation' => ['title' => 'Preservação ecológica', 'pillar' => 'environmental', 'tracking_type' => 'count'],
                'reduce_emissions' => ['title' => 'Reduzir emissões', 'pillar' => 'environmental', 'tracking_type' => 'percentage'],
                'renewable_energy' => ['title' => 'Adotar energia renovável', 'pillar' => 'environmental', 'tracking_type' => 'count'],
                'other_env' => ['title' => 'Outro', 'pillar' => 'environmental', 'tracking_type' => 'count'],
            ],
            'social' => [
                'hire_underrepresented' => ['title' => 'Contratar talentos sub-representados', 'pillar' => 'social', 'tracking_type' => 'count'],
                'mentorship' => ['title' => 'Programas de mentoria', 'pillar' => 'social', 'tracking_type' => 'count'],
                'accessibility' => ['title' => 'Melhorias de acessibilidade', 'pillar' => 'social', 'tracking_type' => 'percentage'],
                'community' => ['title' => 'Engajamento comunitário', 'pillar' => 'social', 'tracking_type' => 'count'],
                'scholarships' => ['title' => 'Bolsas de estudo', 'pillar' => 'social', 'tracking_type' => 'count'],
            ],
            'governance' => [
                'anti_bias' => ['title' => 'Processo de recrutamento antiviés', 'pillar' => 'governance', 'tracking_type' => 'status'],
                'dei_training' => ['title' => 'Treinamento em DEI', 'pillar' => 'governance', 'tracking_type' => 'status'],
                'anonymous_reporting' => ['title' => 'Canal de denúncia anônimo', 'pillar' => 'governance', 'tracking_type' => 'status'],
                'compliance' => ['title' => 'Auditorias de conformidade', 'pillar' => 'governance', 'tracking_type' => 'status'],
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
                    $trackingType = $request->input("tracking_type_{$goalKey}", $flattenedGoals[$goalKey]['tracking_type']);
                    $targetValue = $request->input("target_value_{$goalKey}");
                    $deadline = $request->input("deadline_{$goalKey}");

                    $company->esgGoals()->create([
                        'title' => $flattenedGoals[$goalKey]['title'],
                        'pillar' => $flattenedGoals[$goalKey]['pillar'],
                        'tracking_type' => $trackingType,
                        'target_value' => $targetValue ?: null,
                        'deadline' => $deadline ?: null,
                        'status' => 'IN_PROGRESS',
                    ]);
                }
            }
        }

        // Criar metas personalizadas
        if (isset($validated['custom_goals'])) {
            foreach ($validated['custom_goals'] as $customGoal) {
                if (!empty($customGoal['title'])) {
                    $deadline = !empty($customGoal['deadline']) ? $customGoal['deadline'] . '-01' : null;
                    $company->esgGoals()->create([
                        'title' => $customGoal['title'],
                        'pillar' => $customGoal['pillar'] ?? 'social',
                        'tracking_type' => 'count',
                        'target_value' => $customGoal['target_value'] ?? null,
                        'deadline' => $deadline,
                        'status' => 'IN_PROGRESS',
                    ]);
                }
            }
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
