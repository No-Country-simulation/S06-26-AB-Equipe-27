<?php

namespace App\Http\Controllers;

use App\Models\EsgGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EsgProgressController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        $goals = $company->esgGoals()->get();

        // If no goals exist, create sample goals
        if ($goals->isEmpty()) {
            $this->createSampleGoals($company->id);
            $goals = $company->esgGoals()->get();
        }

        return view('esg-progress', compact('goals'));
    }

    public function update(Request $request, EsgGoal $goal)
    {
        $validated = $request->validate([
            'current_value' => ['nullable', 'integer'],
            'notes' => ['nullable', 'string'],
            'status' => ['nullable', 'in:NOT_STARTED,IN_PROGRESS,COMPLETED,PENDING,ACHIEVED,CANCELLED'],
        ]);

        // Additional validation based on tracking type
        if ($goal->tracking_type === 'count') {
            if (isset($validated['current_value']) && $goal->target_value) {
                $request->validate([
                    'current_value' => ['lte:' . $goal->target_value]
                ]);
            }
        } elseif ($goal->tracking_type === 'percentage') {
            if (isset($validated['current_value'])) {
                $request->validate([
                    'current_value' => ['gte:0', 'lte:100']
                ]);
            }
        }

        $goal->update($validated);

        return back()->with('success', 'Meta atualizada com sucesso!');
    }

    private function createSampleGoals($companyId)
    {
        $sampleGoals = [
            [
                'title' => 'Hire underrepresented talent',
                'description' => 'Quarterly hiring update',
                'tracking_type' => 'count',
                'target_value' => 30,
                'current_value' => 15,
                'unit' => null,
                'pillar' => 'social',
                'status' => 'IN_PROGRESS',
                'notes' => 'Quarterly hiring update',
            ],
            [
                'title' => 'Mentorship Program',
                'description' => null,
                'tracking_type' => 'count',
                'target_value' => 10,
                'current_value' => 3,
                'unit' => null,
                'pillar' => 'social',
                'status' => 'IN_PROGRESS',
                'notes' => null,
            ],
            [
                'title' => 'Accessibility Improvements',
                'description' => null,
                'tracking_type' => 'percentage',
                'target_value' => 100,
                'current_value' => 60,
                'unit' => '%',
                'pillar' => 'social',
                'status' => 'IN_PROGRESS',
                'notes' => null,
            ],
            [
                'title' => 'DEI Training',
                'description' => null,
                'tracking_type' => 'status',
                'target_value' => 100,
                'current_value' => 100,
                'unit' => '%',
                'pillar' => 'social',
                'status' => 'COMPLETED',
                'notes' => null,
            ],
        ];

        foreach ($sampleGoals as $goalData) {
            $goalData['company_id'] = $companyId;
            EsgGoal::create($goalData);
        }
    }
}
