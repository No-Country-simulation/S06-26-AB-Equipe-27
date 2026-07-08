<?php

namespace App\Services;

use App\Models\Matching;

class MatchService
{
    public function updateOrCreate(array $data)
    {
        return Matching::updateOrCreate([
            'job_posting_id' => $data['job_posting_id'],
            'company_id' => $data['company_id'],
            'skills' => $data['skills'],
            'seniority' => $data['seniority'],
            'score_match' => $data['score_match'],
            'badge_diversidade' => $data['badge_diversidade'],
            'recomendacao' => $data['recomendacao'],
        ]);
    }
}
