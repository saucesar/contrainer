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

    public function totalTimeActivity($round = 0)
    {
        $activities = AtividadeMaquina::where('hashcode_maquina', $this->hashcode)->get();
        $time = 0;

        foreach($activities as $act) {
            if($act->dataHoraFim) {
                $time += strtotime($act->dataHoraFim) - strtotime($act->dataHoraInicio);
            } else {
                $time += strtotime(now()) - strtotime($act->dataHoraInicio);
            }
        }
        return ($round ? round($time/3600, $round) : $time/3600);
    }
}
