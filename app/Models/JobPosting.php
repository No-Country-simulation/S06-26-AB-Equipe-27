<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobPosting extends Model
{
    protected $fillable = [
        'company_id',
        'title',
        'description',
        'required_skills',
        'level',
        'city',
        'district',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'nice_to_have' => 'array',
    ];

    public function matchings()
    {
        return $this->hasMany(Matching::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
