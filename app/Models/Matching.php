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
        'skills',
        'seniority',
        'score_match',
        'badge_diversidade',
        'recomendacao',
    ];

    protected $casts = [
        'skills' =>  'array',
    ];

    public function JobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
