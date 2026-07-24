<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCandidateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $loginType = $request->session()->get('login_type');

        // Only allow access if login_type is explicitly 'candidato'
        if ($loginType !== 'candidato') {
            abort(403, 'Acesso não autorizado.');
        }

        if (!auth()->user()) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
