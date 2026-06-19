<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

# Padrão
Route::get('/', function () {
    return view('home');
})->name('home');

# ====================================
# Autenticação (Login e Registro)
# ====================================

# Cadastro
Route::get('/register', function () { return view('register'); });
Route::post('/register', [AuthController::class, 'register']);

# Login
Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);

# Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

# ====================================
# Dashboard e Verificação de Email
# ====================================

# Dashboard unificado (Chama direto o Controller que gerencia as lógicas da tela)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified']);

# Notificação de verificação
Route::get('/email/verify', function () {
    return view('verify');
})->middleware('auth')->name('verification.notice');

# Link de verificação processado
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

# ====================================
# Recuperação de Senha
# ====================================

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

# ====================================
# CRUD de Vagas
# ====================================

Route::get('/jobs', [JobPostingController::class, 'index']);          // Listar
Route::get('/jobs/create', function () { return view('job-posting'); }); // Tela criar
Route::post('/jobs', [JobPostingController::class, 'store']);          // Salvar

Route::get('/jobs/{id}/edit', [JobPostingController::class, 'edit']);   // Tela editar
Route::put('/jobs/{id}/edit', [JobPostingController::class, 'update']); // Salvar edição
Route::delete('/jobs/{id}/delete', [JobPostingController::class, 'delete']); // Excluir
