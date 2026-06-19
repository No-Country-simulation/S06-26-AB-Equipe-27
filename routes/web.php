<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('home');
})->name('home');

#Rotas de cadastro.
Route::get('/register', function () {
    return view('register');
});
Route::post('/register', [AuthController::class, 'register']);

#Rotas de login/logout.
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth', 'verified')->name('dashboard');

#Verifica Email.
Route::get('/email/verify', function () {
    return view('verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('setup.step1');
})->middleware(['auth', 'signed'])->name('verification.verify');

#Esqueci senha.
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
