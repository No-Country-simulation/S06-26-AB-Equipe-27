<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

# Método importado acima (DB) é importante para garantir consistência entre usuário e empresa.

# Depois de campos validados no controller,
# são recebidos pelo service que gera novos campos no banco de dados.

class AuthService
{
    public function register(array $data)
    {
        return DB::transaction(function () use ($data){
        # Cria usuário.
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->sendEmailVerificationNotification();

        # Cria empresa vinculada ao usuário.
        Company::create([
            'user_id' => $user->id,
            'name' => $data['company_name'],
        ]);

        return $user;
        });
    }
}
