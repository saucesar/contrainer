<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $fillable = ['ddi', 'ddd', 'numero'];

    public static $rules = [
        'ddi'    => ['required', 'numeric', 'max:4'],
        'ddd'    => ['required', 'numeric', 'max:2'],
        'numero' => ['required', 'numeric', 'min:8','max:9']
    ];

    public static $messages = [
        'required'=> 'O campo :attribute é obrigatório.',
        'numeric' => 'Insira apenas números no campo :attribute.',
        'min'     => ':attribute com no mínimo 8 dígitos.',
        'max'     => 'Quantidade maior que o permitido no campo :attribute.'
    ];

    public function user():User
    {
        return User::firstWhere('id', $this->user_id);
    }
}
