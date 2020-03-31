<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Telefone;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','tipo_usuario'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    public static $rules = [
        'name'         => ['required', 'min:3'],
        'email'        => ['required', 'unique:users'],
        'password'     => ['required', 'min:8']
    ];

    public static $messages = [
        'required'=> 'O campo :attribute é obrigatório.',
        'unique'  => 'O :attribute informado já possui cadastro.',
        'min'     => 'Quantidade menor que o permitido no campo :attribute.'
    ];

    public function telefone()
    {
        return $this->hasOne(Telefone::class);
    }

    public function maquinas()
    {
        return $this->hasMany(Maquina::class);
    }
}
