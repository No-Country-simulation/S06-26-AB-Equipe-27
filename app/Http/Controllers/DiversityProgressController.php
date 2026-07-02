<?php

namespace App\Http\Controllers;

use App\Models\CompanyDiversityGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiversityProgressController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        $goals = $company->diversityGoals()->get();

        return view('diversity-progress', compact('goals'));
    }

    public function update(Request $request, CompanyDiversityGoal $goal)
    {
        $validated = $request->validate([
            'current_value' => ['nullable', 'numeric', 'gte:0', 'lte:100'],
        ]);

        $goal->update($validated);

        return back()->with('success', 'Meta de diversidade atualizada com sucesso!');
    }
}
