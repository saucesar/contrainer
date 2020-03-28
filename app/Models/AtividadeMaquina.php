<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtividadeMaquina extends Model
{
    protected $fillable = ['hashcode_maquina', 'dataHoraInicio', 'dataHoraFim'];

    public static $rules = [
        'hashcode_maquina' => ['required'],
        'dataHoraInicio'   => ['required']
    ];

    public static $messages = [
        'required' => 'O campo :attibute é obrigatório.',
    ];
}
