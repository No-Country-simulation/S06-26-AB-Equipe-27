<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'industry',
        'size',
        'country',
        'website',
        'work_model',
        'inclusion_programs',
        'diversity_statement',
        'setup_completed',
    ];

    protected $casts = [
        'inclusion_programs' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function diversityGoals(): HasMany
    {
        return $this->hasMany(CompanyDiversityGoal::class);
    }

    public function esgGoals(): HasMany
    {
        return $this->hasMany(EsgGoal::class);
    }

    public function aiPreferences(): HasOne
    {
        return $this->hasOne(AiPreference::class);
    }
}
