<?php

namespace App\Services;

use App\Models\User;
use App\Models\JobPosting;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class JobService
{
    /* Depois de campos validados no controller,
    são recebidos pelo service que gera novos campos no banco de dados. */

    public function create(array $data){
        $company = auth()->user()->company;

        $job = JobPosting::create([
            'company_id' => $company->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'required_skills' => $data['required_skills'],
            'level' => $data['level'],
            'city' => $data['city'],
            'district' => $data['district'],
        ]);

        return $job;
    }
}
