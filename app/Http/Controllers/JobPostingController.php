<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Services\JobService;

class JobPostingController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    # Método essencial para percorrer array em View.
    public function index(){
        $jobs = JobPosting::latest()->get();
        return view('jobs', compact('jobs'));
    }

    # Validação de campos.
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',

            'required_skills' => 'required|array|min:1',
            'required_skills.0' => 'required|string|max:100',
            'required_skills.*' => 'nullable|string|max:100',

            'level' => 'required',
            'city' => 'required',
            'district' => 'required',
        ]);

        # Filtro backend para possiveis campos nulos..
        $data['required_skills'] = array_filter($request->required_skills, function ($value){
            return !is_null($value) && $value !== '';
        });

        $this->jobService->create($data);
        return redirect('/jobs')->with('success', 'Vaga criada');
    }

    # Edit.
    public function edit($id)
    {
        $job = JobPosting::findOrFail($id);

        # Confiabilidade.
        if($job->company_id !== auth()->user()->company->id){
            abort(403);
        }
        return view('jobs-edit', compact('job'));
    }

    # Update.
    public function update(Request $request, $id)
    {
        $job = JobPosting::findOrFail($id);

        if($job->company_id !== auth()->user()->company->id){
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'level' => 'required',
            'city' => 'required',
            'district' => 'required',
        ]);

        $job->title = $request->title;
        $job->description = $request->description;
        $job->city = $request->city;
        $job->district = $request->district;
        $job->required_skills = $request->required_skills;
        $job->save();

        return redirect('/jobs')->with('sucess', 'Vaga removida');
    }

    # Delete.
    public function delete($id)
    {
        $job = JobPosting::findOrFail($id);

        if($job->company_id !== auth()->user()->company->id){
            abort(403);
        }

        $job->delete();
        return redirect('/jobs')->with('sucess', 'Vaga removida');
    }
}

