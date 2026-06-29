<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Matching extends Model
{
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matching extends Model
{
    use HasFactory;

>>>>>>> origin/selecao_candidatos
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
<<<<<<< HEAD
        'skills' => 'array',
    ];

    public function jobPosting()
=======
        'skills' =>  'array',
    ];

    public function JobPosting()
>>>>>>> origin/selecao_candidatos
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
