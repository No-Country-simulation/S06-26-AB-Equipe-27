<?php

use App\Http\Controllers\AiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\JobsDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;

# Padrão
Route::get('/', function () {
    return view('home');
})->name('home');

# ====================================
# Autenticação (Login e Registro)
# ====================================

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

# Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

# ====================================
# Dashboard e Verificação de Email
# ====================================

# Dashboard unificado (Chama direto o Controller que gerencia as lógicas da tela)

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/dashboard/jobs', [JobsDashboardController::class, 'index'])->middleware(['auth', 'verified']);

# Notificação de verificação
Route::get('/email/verify', function () {
    return view('verify');
})->middleware('auth')->name('verification.notice');

# Link de verificação processado
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('setup.step1');
})->middleware(['auth', 'signed'])->name('verification.verify');

# ====================================
# Recuperação de Senha
# ====================================

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

# Setup Wizard
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

# ====================================
# CRUD de Vagas
# ====================================

Route::get('/jobs', [JobPostingController::class, 'index']);          // Listar
Route::get('/jobs/create', function () {
    return view('job-posting');
}); // Tela criar
Route::post('/jobs', [JobPostingController::class, 'store']);          // Salvar

Route::get('/jobs/{id}/edit', [JobPostingController::class, 'edit']);   // Tela editar
Route::put('/jobs/{id}/edit', [JobPostingController::class, 'update']); // Salvar edição
Route::delete('/jobs/{id}/delete', [JobPostingController::class, 'delete']); // Excluir

# ====================================
# Matches
# ====================================

Route::middleware(['auth'])->group(function () {
    Route::get('/match/{jobId}', [MatchController::class, 'show'])->name('match.show');
    Route::post('/match/{jobId}/generate', [MatchController::class, 'generate'])->name('match.generate');
});

# Test Email Test Route
Route::get('/test-email', function () {
    Mail::raw('Test email from SkillFocus!', function ($message) {
        $message->to('test@example.com')->subject('Test Email');
    });
    return 'Email sent! Check storage/logs/laravel.log (if using log driver) or Mailpit UI at http://localhost:8025!';
});
