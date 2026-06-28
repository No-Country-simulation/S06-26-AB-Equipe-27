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
        // Como o middleware 'auth' já rodou antes, Auth::user() é garantido.
        $company = Auth::user()->company;

        // Se não tiver empresa ou o setup não estiver completo, manda pro início do setup.
        if (!$company || !$company->setup_completed) {
            return redirect()->route('setup.step1');
        }

        // Se estiver tudo certo, deixa a requisição seguir para o Dashboard/Vagas.
        return $next($request);
    }
}
