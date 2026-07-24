<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SetupComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
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

        return $next($request);
    }
}
