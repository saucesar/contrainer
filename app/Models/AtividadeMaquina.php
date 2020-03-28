<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Maquina;

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

    public function maquina():Maquina
    {
        return Maquina::firstWhere('hashcode', $this->hashcode_maquina);
    }

    public function user():User
    {
        return $this->maquina()->user();
    }
}
