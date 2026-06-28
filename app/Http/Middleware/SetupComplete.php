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
        if (Auth::check()) {
            $user = Auth::user();
            $company = $user->company;
            
            // If user has no company OR company hasn't completed setup, redirect to setup step 1
            if (!$company || !$company->setup_completed) {
                // Don't redirect if we're already on a setup route
                $setupRoutes = ['setup.step1', 'setup.step1.post', 'setup.step2', 'setup.step2.post', 'setup.step3', 'setup.step3.post', 'setup.step4', 'setup.step4.post', 'setup.review', 'setup.finish'];
                if (!in_array($request->route()->getName(), $setupRoutes)) {
                    return redirect()->route('setup.step1');
                }
            }
        }

        return $next($request);
    }
}
