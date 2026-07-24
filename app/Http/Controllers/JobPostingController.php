<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Services\JobService;
use App\Models\Matching;

class JobPostingController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $isCompanyUser = session('login_type') === 'empresa';
        
        if ($isCompanyUser) {
            $jobs = JobPosting::where('company_id', $user->company->id)->latest()->get();

            return view('jobs', compact('jobs', 'isCompanyUser'));
        }

        $candidate = $user->candidate;
        $query = JobPosting::with('company')->latest();

        // Check if we need to filter only applied jobs
        if ($request->input('filter') === 'applied' && $candidate) {
            $appliedJobIds = Matching::where('candidate_id', $candidate->id)->pluck('job_posting_id')->all();
            $query->whereIn('id', $appliedJobIds);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('location')) {
            $query->where('city', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('level')) {
            $levels = (array) $request->level;
            $query->where(function ($q) use ($levels) {
                foreach ($levels as $level) {
                    $q->orWhere('level', 'like', '%' . $level . '%');
                }
            });
        }

        if ($request->filled('area')) {
            $query->whereHas('company', fn($q) => $q->where('industry', 'like', '%' . $request->area . '%'));
        }

        $jobs = $query->paginate(10)->withQueryString();

        $appliedJobIds = $candidate
            ? Matching::where('candidate_id', $candidate->id)->pluck('job_posting_id')->all()
            : [];

        $allCount = JobPosting::count();
        $todayCount = JobPosting::whereDate('created_at', today())->count();

        $compatibleCount = JobPosting::all()->filter(function ($job) use ($candidate) {
            return $this->calculateMatchScore($job, $candidate) >= 70;
        })->count();

        return view('candidate-jobs', [
            'jobs' => $jobs,
            'candidate' => $candidate,
            'appliedJobIds' => $appliedJobIds,
            'allCount' => $allCount,
            'todayCount' => $todayCount,
            'compatibleCount' => $compatibleCount,
            'filters' => $request->only(['keyword', 'location', 'level', 'area', 'work_type', 'salary_min', 'salary_max', 'tab', 'sort', 'filter']),
            'isFilterApplied' => $request->input('filter') === 'applied',
        ]);
    }

    public function show(JobPosting $jobPosting)
    {
        $user = auth()->user();
        $isCompanyUser = session('login_type') === 'empresa';

        if ($isCompanyUser) {
            abort(404);
        }

        $jobPosting->load('company');
        $candidate = $user->candidate;

        $matchScore = $this->calculateMatchScore($jobPosting, $candidate);
        $matchMeta = $this->resolveMatchMeta($matchScore);
        $salary = $this->estimateSalaryRange($jobPosting);
        $workType = $this->resolveWorkType($jobPosting);
        $company = $jobPosting->company;
        $companyMeta = $this->resolveCompanyMeta($company, $jobPosting);

        $alreadyApplied = $candidate
            ? Matching::where('job_posting_id', $jobPosting->id)
            ->where('candidate_id', $candidate->id)
            ->exists()
            : false;

        $similarJobs = JobPosting::with('company')
            ->where('id', '!=', $jobPosting->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function (JobPosting $job) use ($candidate) {
                $score = $this->calculateMatchScore($job, $candidate);

                return [
                    'job' => $job,
                    'matchScore' => $score,
                    'matchMeta' => $this->resolveMatchMeta($score),
                    'companyMeta' => $this->resolveCompanyMeta($job->company, $job),
                    'workType' => $this->resolveWorkType($job),
                ];
            });

        $responsibilities = $this->buildResponsibilities($jobPosting);
        $requirements = $jobPosting->required_skills ?? [];
        $niceToHave = $jobPosting->nice_to_have ?? ['Docker', 'Kubernetes', 'Inglês avançado'];
        $benefits = [
            'Vale-refeição e vale-alimentação',
            'Plano de saúde e odontológico',
            'Auxílio home office',
            'Horário flexível',
            'Programa de desenvolvimento contínuo',
            'Day off no aniversário',
        ];

        return view('candidate-job-details', [
            'job' => $jobPosting,
            'candidate' => $candidate,
            'company' => $company,
            'matchScore' => $matchScore,
            'matchMeta' => $matchMeta,
            'salary' => $salary,
            'workType' => $workType,
            'companyMeta' => $companyMeta,
            'alreadyApplied' => $alreadyApplied,
            'similarJobs' => $similarJobs,
            'responsibilities' => $responsibilities,
            'requirements' => $requirements,
            'niceToHave' => $niceToHave,
            'benefits' => $benefits,
            'isFeatured' => $jobPosting->id % 4 === 0,
            'postedAgo' => $jobPosting->created_at->diffForHumans(null, true),
            'applicationDeadline' => $jobPosting->created_at->copy()->addDays(30)->format('d/m/Y'),
        ]);
    }

    private function resolveMatchMeta(int $score): array
    {
        if ($score >= 85) {
            return ['class' => 'excellent', 'label' => 'Excelente match'];
        }

        if ($score >= 70) {
            return ['class' => 'great', 'label' => 'Ótimo match'];
        }

        return ['class' => 'regular', 'label' => 'Regular match'];
    }

    private function estimateSalaryRange(JobPosting $job): array
    {
        $base = match (true) {
            str_contains(strtolower($job->level), 'senior') || str_contains(strtolower($job->level), 'sênior') => 12000,
            str_contains(strtolower($job->level), 'pleno') => 9000,
            str_contains(strtolower($job->level), 'junior') || str_contains(strtolower($job->level), 'júnior') => 6000,
            default => 7500,
        };

        return [
            'min' => $base,
            'max' => $base + 4000,
            'label' => 'R$ ' . number_format($base, 0, ',', '.') . ' - R$ ' . number_format($base + 4000, 0, ',', '.'),
        ];
    }

    private function resolveWorkType(JobPosting $job): string
    {
        $types = ['Remoto', 'Híbrido', 'Presencial'];

        return $types[$job->id % 3];
    }

    private function resolveCompanyMeta($company, JobPosting $job): array
    {
        $companyName = $company->name ?? 'Empresa';
        $initials = collect(explode(' ', $companyName))
            ->take(2)
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->join('');
        $logoColors = ['#7C3AED', '#2563EB', '#0D9488', '#D97706', '#DB2777'];

        return [
            'name' => $companyName,
            'initials' => $initials ?: 'SF',
            'logoColor' => $logoColors[$job->id % count($logoColors)],
            'industry' => $company->industry ?? 'Tecnologia & Software',
            'size' => $company->size ?? '51-200 colaboradores',
            'website' => $company->website ?? 'www.empresa.com.br',
            'about' => $company->diversity_statement
                ?? 'Empresa focada em inovação, diversidade e desenvolvimento de talentos. Oferecemos um ambiente colaborativo com oportunidades reais de crescimento.',
        ];
    }

    private function buildResponsibilities(JobPosting $job): array
    {
        $skills = $job->required_skills ?? [];

        return [
            'Desenvolver e manter APIs e serviços backend escaláveis',
            'Colaborar com times de produto, design e QA na entrega de funcionalidades',
            'Garantir qualidade de código, testes e boas práticas de arquitetura',
            'Participar de code reviews e evolução técnica do time',
            count($skills) > 0
                ? 'Trabalhar com ' . implode(', ', array_slice($skills, 0, 3)) . ' e demais tecnologias do stack'
                : 'Contribuir com melhorias contínuas de performance e observabilidade',
        ];
    }

    private function calculateMatchScore(JobPosting $job, $candidate): int
    {
        if (!$candidate) {
            return rand(55, 75);
        }

        $jobSkills = $job->required_skills ?? [];
        $candidateSkills = $candidate->skills ?? [];

        if (empty($jobSkills)) {
            return 60;
        }

        $matchingSkills = array_intersect(
            array_map('strtolower', $jobSkills),
            array_map('strtolower', $candidateSkills)
        );

        return (int) round((count($matchingSkills) / count($jobSkills)) * 100);
    }

    public function create()
    {
        return view('job-posting');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->company()->exists()) {
            abort(403);
        }

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

        $data['required_skills'] = array_filter($request->required_skills, function ($value) {
            return !is_null($value) && $value !== '';
        });

        $this->jobService->create($data);

        return redirect('/jobs')->with('success', 'Vaga criada');
    }

    public function edit($id)
    {
        $user = auth()->user();
        if (!$user->company()->exists()) {
            abort(403);
        }

        $job = JobPosting::findOrFail($id);

        if ($job->company_id !== $user->company->id) {
            abort(403);
        }

        return view('jobs-edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->company()->exists()) {
            abort(403);
        }

        $job = JobPosting::findOrFail($id);

        if ($job->company_id !== $user->company->id) {
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
        $job->level = $request->level;
        $job->city = $request->city;
        $job->district = $request->district;
        $job->required_skills = $request->required_skills;
        $job->save();

        return redirect('/jobs')->with('sucess', 'Vaga removida');
    }

    public function delete($id)
    {
        $user = auth()->user();
        if (!$user->company()->exists()) {
            abort(403);
        }

        $job = JobPosting::findOrFail($id);

        if ($job->company_id !== $user->company->id) {
            abort(403);
        }

        $job->delete();

        return redirect('/jobs')->with('sucess', 'Vaga removida');
    }

    public function apply(JobPosting $jobPosting)
    {
        $user = auth()->user();
        $candidate = $user->candidate;

        if (!$candidate) {
            return redirect()->route('candidate-setup.step1')->with('error', 'Please complete your candidate profile first!');
        }

        $existingApplication = Matching::where('job_posting_id', $jobPosting->id)
            ->where('candidate_id', $candidate->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('jobs.show', $jobPosting)->with('error', 'You have already applied to this job!');
        }

        $jobSkills = $jobPosting->required_skills ?? [];
        $candidateSkills = $candidate->skills ?? [];
        $matchingSkills = array_intersect($jobSkills, $candidateSkills);
        $scoreMatch = !empty($jobSkills) ? round((count($matchingSkills) / count($jobSkills)) * 100) : 50;

        Matching::create([
            'job_posting_id' => $jobPosting->id,
            'company_id' => $jobPosting->company_id,
            'candidate_id' => $candidate->id,
            'skills' => $candidate->skills,
            'seniority' => $candidate->years_experience ? ($candidate->years_experience < 2 ? 'Junior' : ($candidate->years_experience < 5 ? 'Pleno' : 'Senior')) : 'Junior',
            'score_match' => $scoreMatch,
            'badge_diversidade' => 'Diversidade',
            'recomendacao' => 'Candidate with ' . $candidate->years_experience . ' years of experience.',
            'status' => 'pendente',
        ]);

        return redirect()->route('jobs.show', $jobPosting)->with('success', 'Candidatura enviada com sucesso!');
    }
}
