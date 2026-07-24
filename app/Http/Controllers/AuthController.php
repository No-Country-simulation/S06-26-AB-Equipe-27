<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'profile_type' => 'required|in:empresa,candidato',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'company_name' => 'nullable|required_if:profile_type,empresa|string|max:255',
            'current_company' => 'nullable|string|max:255',
        ]);

        if ($data['profile_type'] === 'empresa') {
            $this->authService->register($data);
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->candidate()->create([
                'current_company' => $data['current_company'] ?? null,
            ]);
            $user->sendEmailVerificationNotification();
        }

        return redirect('/login')->with('success', 'Conta criada com sucesso!');
    }

    # Sistema de login.
    public function login(Request $request)
    {
        #garante confiabilidade.
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'login_type' => 'required|in:empresa,candidato',
        ]);

        $credentials = $request->only('email', 'password');
        $loginType = $request->input('login_type');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('login_type', $loginType);

            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            // Redirect based on login type, ignoring profile existence
            if ($loginType === 'empresa') {
                if (!$user->company || !$user->company->setup_completed) {
                    return redirect()->route('setup.step1');
                }
                return redirect()->route('dashboard');
            } else {
                // candidato
                if (!$user->candidate || !$user->candidate->setup_completed) {
                    return redirect()->route('candidate-setup.step1');
                }
                return redirect()->route('dashboard'); // DashboardController will handle showing candidate view
            }
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
            'email' => ($status)
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
