<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCompanyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $loginType = $request->session()->get('login_type');

        if ($loginType !== 'empresa') {
            abort(403, 'Acesso não autorizado.');
        }

        $user = auth()->user();
        if (!$user) {
            abort(403, 'Acesso não autorizado.');
        }

        if (!$user->isEmpresa()) {
            abort(403, 'Acesso não autorizado para este tipo de conta.');
        }

        return $next($request);
    }
}
