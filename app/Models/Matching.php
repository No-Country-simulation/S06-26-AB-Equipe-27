<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matching extends Model
{
    protected $fillable = [
        'job_posting_id',
        'company_id',
        'skills',
        'seniority',
        'score_match',
        'badge_diversidade',
        'recomendacao',
    ];

    protected $casts = [
        'skills' => 'array',
    ];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
