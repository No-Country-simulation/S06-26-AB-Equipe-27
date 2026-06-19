<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyDiversityGoal extends Model
{
    protected $fillable = [
        'company_id',
        'group',
        'target_percentage',
        'target_year',
        'priority',
    ];

    protected $casts = [
        'target_percentage' => 'decimal:2',
        'target_year' => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
