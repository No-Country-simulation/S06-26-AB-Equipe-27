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

        if ($user->company()->exists()) {
            if (!$user->company->setup_completed) {
                return redirect()->route('setup.step1');
            }
        } elseif ($user->candidate()->exists()) {
            if (!$user->candidate->setup_completed) {
                return redirect()->route('candidate-setup.step1');
            }
        } else {
            return redirect()->route('setup.step1');
        }

        return $next($request);
    }
}
