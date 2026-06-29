<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiPreference extends Model
{
    protected $fillable = [
        'company_id',
        'matching_priority',
        'candidate_radius',
        'include_remote'
    ];

    protected $casts = [
        'matching_priority' => 'array',
        'include_remote' => 'boolean',
        'candidate_radius' => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
