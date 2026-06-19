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

    protected $cast = [
        'required_skills' => 'array',
    ];
}
