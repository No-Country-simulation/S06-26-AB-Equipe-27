<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'company_name' => 'required|string|max:255',
        ]);

    $this->authService->register($data);
        return redirect('/login')->with('success', 'Conta criada com sucesso!');
    }

    # SISTEMA DE LOGIN!

    public function login(Request $request)
    {
        #garante confiabilidade.
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        #tentativa de autenticação.
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect('/dashboard');
        }
        return back()->withErrors([
            'email' => 'Credenciais inválidas',
        ]);
    }

    #LOGOUT - SAIDERA.

    public function logout(Request $request)
    {
        Auth::logout(); #Desautenticação.
        $request->session()->invalidate(); #Invalida sessão antiga.
        $request->session()->regenerateToken(); #Troca chave. :)

        return redirect('/login');

    }

    #Função envia link de reset.
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        Password::sendResetLink($request->only('email'));
        return back()->with('status', 'Email enviado');
    }

    #Função para trocar senha.
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password){
                $user->password = Hash::make($password);
                $user->save();
            });

            if ($status === Password::PASSWORD_RESET){
                return redirect('/login')->with('success', 'Senha redefinida com sucesso!');
            }

            return back()->withErrors([
                'email' => __($status)
            ]);
    }

    #Tela para digitar email.
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    #Exibe tela para digitar nova senha (TOKEN VIA GET).
    public function showResetPasswordForm($token, Request $request)
    {
        return view('reset-password', ['token' => $token, 'email' => $request->email]);
    }
}
