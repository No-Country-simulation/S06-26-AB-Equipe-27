<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $profileType = $request->input('profile_type');

        $data = $request->validate([
            'profile_type' => 'required|in:empresa,candidato',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->where(fn ($q) => $q->where('account_type', $profileType)),
            ],
            'password' => 'required|min:6',
            'company_name' => [
                Rule::requiredIf($profileType === 'empresa'),
                'exclude_if:profile_type,candidato',
                'string',
                'max:255',
            ],
            'current_company' => [
                'exclude_if:profile_type,empresa',
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        if ($data['profile_type'] === 'empresa') {
            $this->authService->register($data);
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'account_type' => 'candidato',
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

        $loginType = $request->input('login_type');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)
            ->where('account_type', $loginType)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, (bool) $request->filled('remember'));
            $request->session()->regenerate();
            $request->session()->put('login_type', $loginType);

            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            if ($loginType === 'empresa') {
                if (!$user->company || !$user->company->setup_completed) {
                    return redirect()->route('setup.step1');
                }
                return redirect()->route('dashboard');
            } else {
                if (!$user->candidate || !$user->candidate->setup_completed) {
                    return redirect()->route('candidate-setup.step1');
                }
                return redirect()->route('dashboard');
            }
        }

        $anotherTypeExists = User::where('email', $email)->exists();

        return back()->withErrors([
            'email' => $anotherTypeExists && !$user
                ? 'Credenciais inválidas para o perfil selecionado. Verifique se escolheu Empresa ou Candidato corretamente.'
                : 'Credenciais inválidas',
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
