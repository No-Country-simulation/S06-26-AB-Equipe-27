<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('home');
})->name('home');


#Rotas de cadastro.
Route::get('/register', function (){
    return view('register');
});
Route::post('/register', [AuthController ::class, 'register']);

#Rotas de login/logout.
Route::get('/login', function (){
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function(){
    return view('dashboard');
})->middleware('auth', 'verified');

#Verifica Email.
Route::get('/email/verify', function (){
    return view('verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

#Esqueci senha.
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');

/* Route::get('/reset-password/{token}', function ($token){
    return view('reset-password', ['token' => $token]);
}); */

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
