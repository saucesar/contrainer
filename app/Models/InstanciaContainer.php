<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstanciaContainer extends Model
{
    use SoftDeletes;

    protected $fillable = ['hashcode_maquina', 'container_id', 'dataHora_instanciado', 'dataHora_finalizado'];

    public static $rules = [
        'hashcode_maquina'     => ['required'],
        'container_id'         => ['required', 'numeric'],
        'dataHora_instanciado' => ['required', 'date', 'after:yesterday'],
        'dataHora_finalizado'  => ['nullable', 'date', 'after:yesterday'],
    ];
}
