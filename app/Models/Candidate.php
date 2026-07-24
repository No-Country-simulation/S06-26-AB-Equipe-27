<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'city',
        'country',
        'linkedin',
        'portfolio',
        'resume_path',
        'current_job_title',
        'current_company',
        'years_experience',
        'professional_summary',
        'skills',
        'languages',
        'work_experience',
        'education',
        'desired_position',
        'employment_type',
        'work_model',
        'salary_expectation',
        'salary_currency',
        'availability',
        'setup_completed',
    ];

    protected $casts = [
        'skills' => 'array',
        'languages' => 'array',
        'work_experience' => 'array',
        'education' => 'array',
        'employment_type' => 'array',
        'work_model' => 'array',
        'setup_completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function matchings()
    {
        return $this->hasMany(Matching::class);
    }

    public function profileProgressFields(): array
    {
        return [
            'resume' => filled($this->resume_path),
            'languages' => ! empty($this->languages),
            'portfolio' => filled($this->portfolio),
            'salary' => filled($this->salary_expectation),
            'setup' => (bool) $this->setup_completed,
        ];
    }

    public function profileProgressPercentage(): int
    {
        $fields = $this->profileProgressFields();

        return (int) round((count(array_filter($fields)) / count($fields)) * 100);
    }
}
