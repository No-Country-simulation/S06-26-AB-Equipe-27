<?php

use App\Http\Controllers\AiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EsgProgressController;
use App\Http\Controllers\DiversityProgressController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\JobsDashboardController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\CandidateSetupController;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\ReportController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

# --------------------------------------------------------------------------
# 1. Rotas Públicas / Visitantes
# --------------------------------------------------------------------------
Route::get('/', function () {
    return view('home');
})->name('home');

# Restrição 'guest': Apenas utilizadores NÃO autenticados podem aceder
Route::middleware('guest')->group(function () {
    # Cadastro
    Route::get('/register', function () {
        return view('register');
    });
    Route::post('/register', [AuthController::class, 'register']);

    # Login
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    # Recuperação de Senha
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

# --------------------------------------------------------------------------
# 2. Rotas que Exigem Apenas Autenticação Base (Utilizadores Logados)
# --------------------------------------------------------------------------
// Logout route

Route::middleware(['auth'])->group(function () {
    # Notificação de Verificação de Email
    Route::get('/email/verify', function () {
        return view('verify');
    })->name('verification.notice');

    # Reenvio de link de verificação
    Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('resent', true);
    })->middleware(['throttle:6,1'])->name('verification.send');

    # Processamento do Link de Verificação
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        $user = $request->user();
        $loginType = $request->session()->get('login_type', 'empresa');

        if ($loginType === 'empresa') {
            if (!$user->company || !$user->company->setup_completed) {
                return redirect()->route('setup.step1');
            }
        } else {
            if (!$user->candidate || !$user->candidate->setup_completed) {
                return redirect()->route('candidate-setup.step1');
            }
        }

        return redirect()->route('dashboard');
    })->middleware(['signed'])->name('verification.verify');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

# --------------------------------------------------------------------------
# 3. Wizard de Configuração (Exige Auth e Email Verificado)
# --------------------------------------------------------------------------
// Company setup routes
Route::middleware(['auth', 'verified', 'is.company'])->group(function () {
    Route::get('/setup/step1', [SetupController::class, 'step1'])->name('setup.step1');
    Route::post('/setup/step1', [SetupController::class, 'postStep1'])->name('setup.step1.post');

    Route::get('/setup/step2', [SetupController::class, 'step2'])->name('setup.step2');
    Route::post('/setup/step2', [SetupController::class, 'postStep2'])->name('setup.step2.post');

    Route::get('/setup/step3', [SetupController::class, 'step3'])->name('setup.step3');
    Route::post('/setup/step3', [SetupController::class, 'postStep3'])->name('setup.step3.post');

    Route::get('/setup/step4', [SetupController::class, 'step4'])->name('setup.step4');
    Route::post('/setup/step4', [SetupController::class, 'postStep4'])->name('setup.step4.post');

    Route::get('/setup/review', [SetupController::class, 'review'])->name('setup.review');
    Route::post('/setup/finish', [SetupController::class, 'finish'])->name('setup.finish');
});

// Candidate setup routes
Route::middleware(['auth', 'verified', 'is.candidate'])->group(function () {
    Route::get('/candidate-setup/step1', [CandidateSetupController::class, 'step1'])->name('candidate-setup.step1');
    Route::post('/candidate-setup/step1', [CandidateSetupController::class, 'postStep1'])->name('candidate-setup.step1.post');

    Route::get('/candidate-setup/step2', [CandidateSetupController::class, 'step2'])->name('candidate-setup.step2');
    Route::post('/candidate-setup/step2', [CandidateSetupController::class, 'postStep2'])->name('candidate-setup.step2.post');

    Route::get('/candidate-setup/step3', [CandidateSetupController::class, 'step3'])->name('candidate-setup.step3');
    Route::post('/candidate-setup/step3', [CandidateSetupController::class, 'postStep3'])->name('candidate-setup.step3.post');

    Route::get('/candidate-setup/step4', [CandidateSetupController::class, 'step4'])->name('candidate-setup.step4');
    Route::post('/candidate-setup/step4', [CandidateSetupController::class, 'postStep4'])->name('candidate-setup.step4.post');

    Route::get('/candidate-setup/step5', [CandidateSetupController::class, 'step5'])->name('candidate-setup.step5');
    Route::post('/candidate-setup/step5', [CandidateSetupController::class, 'postStep5'])->name('candidate-setup.step5.post');

    Route::get('/candidate-setup/step6', [CandidateSetupController::class, 'step6'])->name('candidate-setup.step6');
    Route::post('/candidate-setup/step6', [CandidateSetupController::class, 'postStep6'])->name('candidate-setup.step6.post');

    Route::get('/candidate-setup/finish', [CandidateSetupController::class, 'finish'])->name('candidate-setup.finish');
});


# --------------------------------------------------------------------------
# 4. Aplicação Principal (Exige Auth, Email Verificado e Setup Concluído)
# --------------------------------------------------------------------------
// Company-only routes
Route::middleware(['auth', 'verified', 'setup.complete', 'is.company'])->group(function () {
    # ESG Progress
    Route::get('/esg-progress', [EsgProgressController::class, 'index'])->name('esg-progress.index');
    Route::put('/esg-progress/{goal}', [EsgProgressController::class, 'update'])->name('esg-progress.update');

    # Diversity Progress
    Route::get('/diversity-progress', [DiversityProgressController::class, 'index'])->name('diversity-progress.index');
    Route::put('/diversity-progress/{goal}', [DiversityProgressController::class, 'update'])->name('diversity-progress.update');

    # CRUD de Vagas (Company features)
    Route::get('/jobs/create', [JobPostingController::class, 'create']);
    Route::get('/jobs', [JobPostingController::class, 'index']);
    Route::post('/jobs', [JobPostingController::class, 'store']);
    Route::get('/jobs/{id}/edit', [JobPostingController::class, 'edit']);
    Route::put('/jobs/{id}/edit', [JobPostingController::class, 'update']);
    Route::delete('/jobs/{id}/delete', [JobPostingController::class, 'delete']);
    Route::get('/jobs/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/jobs/reports/download-pdf', [ReportController::class, 'downloadPdf'])->name('reports.download-pdf');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports-download-pdf', [ReportController::class, 'downloadPdf'])->name('reports.download-pdf');

    Route::get('/mapa-talentos', [MapaController::class, 'index']);
});

// Candidate-only routes
Route::middleware(['auth', 'verified', 'setup.complete', 'is.candidate'])->group(function () {
    Route::get('/candidate-jobs', [JobPostingController::class, 'index'])->name('candidate-jobs.show');
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
});

// Routes accessible by both company and candidate users (jobs index, job details, apply)
Route::middleware(['auth', 'verified'])->group(function () {
    # Dashboards
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    # Jobs
    Route::get('/jobs/{jobPosting}', [JobPostingController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{jobPosting}/apply', [JobPostingController::class, 'apply'])->name('jobs.apply');
});


# ====================================
# Matches (Company-only)
# ====================================
Route::middleware(['auth', 'is.company'])->group(function () {
    Route::get('/match/{jobId}', [MatchController::class, 'show'])->name('match.show');
    Route::post('/match/{jobId}/generate', [MatchController::class, 'generate'])->name('match.generate');
    Route::post('/match/{matching}/select', [App\Http\Controllers\MatchController::class, 'selectCandidate'])->name('match.select');
});

# ====================================
# Test (Route just for tests)
# ====================================

Route::get('/test', function () {
    return view('tests');
});

// Quick test route for candidate setup
Route::get('/candidate-setup', function () {
    return redirect()->route('candidate-setup.step1');
})->middleware('auth');

Route::get('/seed-matchings', function () {
    $company = auth()->user()->company;
    if (!$company) {
        return 'No company found!';
    }

    $jobPosting = \App\Models\JobPosting::firstOrCreate([
        'company_id' => $company->id,
        'title' => 'Desenvolvedor PHP',
        'city' => 'São Paulo'
    ]);

    // Create 15 sample matchings with varying scores
    for ($i = 0; $i < 15; $i++) {
        \App\Models\Matching::create([
            'job_posting_id' => $jobPosting->id,
            'company_id' => $company->id,
            'skills' => ['PHP', 'Laravel', 'MySQL'],
            'seniority' => 'Pleno',
            'score_match' => rand(60, 100),
            'badge_diversidade' => 'Diversidade',
            'recomendacao' => 'Candidato com alta compatibilidade'
        ]);
    }

    return 'Sample matchings created! Now go check the dashboard!';
})->middleware(['auth', 'verified']);
