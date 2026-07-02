<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyDiversityGoal extends Model
{
    protected $fillable = [
        'company_id',
        'group',
        'target_value',
        'target_year',
        'priority',
        'current_value',
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'target_year' => 'integer',
        'current_value' => 'decimal:2',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
