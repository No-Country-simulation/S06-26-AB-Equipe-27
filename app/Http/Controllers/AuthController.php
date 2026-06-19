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

    # Sistema de login.
    public function login(Request $request)
    {
        #garante confiabilidade.
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        #tentativa de autenticação.
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if setup is needed
            $user = Auth::user();
            $company = $user->company;

            if (!$company || !$company->setup_completed) {
                return redirect()->route('setup.step1');
            }

            return redirect('/dashboard');
        }
        return back()->withErrors([
            'email' => 'Credenciais inválidas',
        ]);
    }

    # Logout.
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    # Link de reset.
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        Password::sendResetLink($request->only('email'));
        return back()->with('status', 'Email enviado');
    }

    # Trocar senha.
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect('/login')->with('success', 'Senha redefinida com sucesso!');
        }

        return back()->withErrors([
            'email' => __($status)
        ]);
    }

    # View digitar dados.
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    # View para nova senha, token recebido via GET.
    public function showResetPasswordForm($token, Request $request)
    {
        return view('reset-password', ['token' => $token, 'email' => $request->email]);
    }
}
