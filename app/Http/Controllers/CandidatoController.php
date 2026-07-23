<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CandidatoService;

class CandidatoController extends Controller
{
    protected $CandidatoService;

    public function __construct(CandidatoService $CandidatoService)
    {
        $this->CandidatoService = $CandidatoService;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
           'name' => 'required|string',
           'email' => 'required|email|unique:users|unique:candidato',
           'password' =>'required|min:6'
        ]);

        $this->CandidatoService->register($data);
        return redirect('/login')->with('success', 'Conta criada com sucesso!');
    }
}
