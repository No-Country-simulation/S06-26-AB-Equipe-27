<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; #ZARATRUSTA DISSE: CONSISTÊNCIAAAAAAAAAAAAAAA!

class AuthService
{
    public function register(array $data)
    {
        #Cria usuário.
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->sendEmailVerificationNotification();

        #Cria empresa vinculada ao usuário.
        Company::create([
            'user_id' => $user->id,
            'name' => $data['company_name'],
        ]);

        return $user;
    }
}
