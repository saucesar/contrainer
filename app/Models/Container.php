<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'programs', 'command'];
    
    public static $rules = [
        'descricao' => ['required', 'between:20,1024'],
    ];

    public static $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'between'  => 'O campo :attribute deve ter entre 20 e 1024 caracteres.'
    ];

    public function programas()
    {   //Tranforma a string programas em um array
        return explode(',',$this->programas());
    }
}
