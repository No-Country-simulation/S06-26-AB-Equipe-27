<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matching extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_posting_id',
        'company_id',
        'candidate_id',
        'skills',
        'seniority',
        'score_match',
        'badge_diversidade',
        'recomendacao',
        'status',
    ];

    protected $casts = [
        'skills' =>  'array',
    ];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
