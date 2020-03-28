<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Maquina extends Model
{
    use SoftDeletes;

    protected $fillable = ['cpu_utilizavel', 'ram_utilizavel'];

    public static $rules = [
        'cpu_utilizavel' => ['required', 'numeric', 'between:1,100',],
        'ram_utilizavel' => ['required', 'numeric', 'min:128',],
    ];

    public static $messages = [
        'required' => 'O campo :attribute é obrigatório',
        'numeric'  => 'O campor :attribute é numérico',
        'min'      => 'Quantidade de :attribute informada está abaixo do permitido.'
    ];

    public function user():User
    {
        return User::firstWhere('id', $this->user_id);
    }
}
