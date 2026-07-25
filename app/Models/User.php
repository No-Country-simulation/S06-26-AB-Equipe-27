<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Company;
use App\Models\Candidate;


#[Fillable(['name', 'email', 'password', 'account_type'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isEmpresa(): bool
    {
        return ($this->account_type ?? 'empresa') === 'empresa';
    }

    public function isCandidato(): bool
    {
        return ($this->account_type ?? 'empresa') === 'candidato';
    }

    public function company()
    {
        return $this->hasOne(\App\Models\Company::class);
    }

    public function candidate()
    {
        return $this->hasOne(\App\Models\Candidate::class);
    }
}
