<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Maquina;

class AtividadeMaquina extends Model
{
    protected $fillable = ['hashcode_maquina', 'dataHoraInicio', 'dataHoraFim', 'last_notification'];

    public static $rules = [
        'hashcode_maquina' => ['required'],
        'dataHoraInicio'   => ['required']
    ];

    public static $messages = [
        'required' => 'O campo :attibute é obrigatório.',
    ];

    public function machine():Maquina
    {
        return Maquina::firstWhere('hashcode', $this->hashcode_maquina);
    }

    public function user():User
    {
        return $this->machine()->user();
    }

    public function activityTime($round = 0)
    {
        if($this->dataHoraFim) {
            $time = strtotime($this->dataHoraFim) - strtotime($this->dataHoraInicio);
        } else {
            $time = strtotime(now()) - strtotime($this->dataHoraInicio);
        }
        return ($round ? round($time/3600, $round) : $time/3600);
    }
}
