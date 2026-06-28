<?php

use App\Http\Controllers\AiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\JobsDashboardController;
use App\Http\Controllers\SetupController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth'])->group(function () {

    # Logout (Fora de outras restrições para permitir sair a qualquer momento)
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    # Notificação de Verificação de Email
    Route::get('/email/verify', function () {
        return view('verify');
    })->name('verification.notice');

    # Processamento do Link de Verificação
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        $user = $request->user();
        $company = $user->company;

        if (!$company || !$company->setup_completed) {
            return redirect()->route('setup.step1');
        }

        return redirect()->route('dashboard');
    })->name('verification.verify');
});

# --------------------------------------------------------------------------
# 3. Wizard de Configuração (Exige Auth e Email Verificado)
# --------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
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


# --------------------------------------------------------------------------
# 4. Aplicação Principal (Exige Auth, Email Verificado e Setup Concluído)
# --------------------------------------------------------------------------
Route::middleware(['auth', 'verified', 'setup.complete'])->group(function () {

    # Dashboards
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/jobs', [JobsDashboardController::class, 'index']);

    # CRUD de Vagas (Mantendo os URLs originais para compatibilidade com as tuas Views)
    Route::get('/jobs', [JobPostingController::class, 'index']);
    Route::get('/jobs/create', function () {
        return view('job-posting');
    });
    Route::post('/jobs', [JobPostingController::class, 'store']);
    Route::get('/jobs/{id}/edit', [JobPostingController::class, 'edit']);
    Route::put('/jobs/{id}/edit', [JobPostingController::class, 'update']);
    Route::delete('/jobs/{id}/delete', [JobPostingController::class, 'delete']);
});

# ====================================
# Matches
# ====================================

Route::middleware(['auth'])->group(function () {
    Route::get('/match/{jobId}', [MatchController::class, 'show'])->name('match.show');
    Route::post('/match/{jobId}/generate', [MatchController::class, 'generate'])->name('match.generate');
});

# ====================================
# Test (Route just for tests)
# ====================================

Route::get('/test', function () {
    return view('tests');
});
