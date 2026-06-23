<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EsgGoal extends Model
{
    protected $fillable = [
        'company_id',
        'pillar',
        'title',
        'description',
        'target_value',
        'unit',
        'current_value',
        'deadline',
        'status',
    ];

    protected $casts = [
        'target_value' => 'integer',
        'current_value' => 'integer',
        'deadline' => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
