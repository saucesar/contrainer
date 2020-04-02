<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Maquina extends Model
{
    use SoftDeletes;

    protected $fillable = ['cpu_utilizavel', 'ram_utilizavel', 'hashcode', 'user_id', 'disponivel'];

    public function user():User
    {
        return User::firstWhere('id', $this->user_id);
    }
}
