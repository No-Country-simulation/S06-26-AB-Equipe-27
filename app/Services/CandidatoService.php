<?php

namespace App\Services;

use App\Models\Candidato;
use Illuminate\Support\Facades\Hash;

class CandidatoService
{
    public function register(array $data)
    {
        return Candidato::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

        $user->sendEmailVerificationNotification();
    }
}
