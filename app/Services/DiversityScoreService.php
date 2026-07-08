<?php

namespace App\Services;

use App\Models\Company;

class DiversityScoreService
{
    public function calculate(Company $company): int
    {
        $totalScore = 0;
        $maxPossibleScore = 0;

        // Part 1: Diversity goals scoring (up to 60 points)
        $priorityWeights = [
            'low' => 1,
            'medium' => 2,
            'high' => 3,
        ];

        $diversityGoals = $company->diversityGoals;
        $totalGoalWeight = 0;
        $totalGoalScore = 0;

        foreach ($diversityGoals as $goal) {
            $weight = $priorityWeights[$goal->priority] ?? 1;
            $progress = $goal->current_value ?? 0;

            $totalGoalWeight += $weight;
            $totalGoalScore += $weight * $progress;
        }

        // Part 2: ESG goals scoring (up to 60 points)
        $priorityWeights = [
            'low' => 1,
            'medium' => 2,
            'high' => 3,
        ];

        $esgGoals = $company->esgGoals;
        $totalGoalWeight = 0;
        $totalGoalScore = 0;

        foreach ($esgGoals as $goal) {
            $weight = $priorityWeights[$goal->priority] ?? 1;
            $progress = $goal->current_value ?? 0;

            $totalGoalWeight += $weight;
            $totalGoalScore += $weight * $progress;
        }

        // Normalize goal score to 0-60
        $maxGoalScore = $totalGoalWeight * 100;
        $goalContribution = $maxGoalScore > 0 ? ($totalGoalScore / $maxGoalScore) * 60 : 0;
        $totalScore += $goalContribution;
        $maxPossibleScore += 60;

        // Part 3: Inclusion programs (up to 15 points)
        $inclusionPrograms = $company->inclusion_programs ?? [];
        $programCount = count($inclusionPrograms);
        $programContribution = min($programCount * 3, 15); // 3 points per program, max 15
        $totalScore += $programContribution;
        $maxPossibleScore += 15;

        // Part 4: Diversity statement (up to 10 points)
        if (!empty(trim($company->diversity_statement ?? ''))) {
            $totalScore += 10;
        }
        $maxPossibleScore += 10;

        // Part 5: Work model (up to 10 points)
        $workModelScores = [
            'remote' => 10,
            'hybrid' => 8,
            'on-site' => 5,
        ];
        $workModelScore = $workModelScores[$company->work_model] ?? 5;

        $totalScore += $workModelScore;
        $maxPossibleScore += 10;

        // Part 6: Number of diversity goals (up to 5 points)
        $goalCount = $diversityGoals->count();
        $goalCountScore = min($goalCount, 5); // 1 point per goal, max 5
        $totalScore += $goalCountScore;
        $maxPossibleScore += 5;

        // Calculate final score 0-100
        $diversityScore = $maxPossibleScore > 0 ? round(($totalScore / $maxPossibleScore) * 100) : 0;
        return min($diversityScore, 100); // Ensure it's not over 100
    }
}
