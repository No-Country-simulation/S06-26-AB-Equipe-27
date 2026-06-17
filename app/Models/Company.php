<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
