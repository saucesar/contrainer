<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'programs', 'command_pull', 'command_run'];

    public function programas()
    {   //Tranforma a string programas em um array
        return explode(',',$this->programs);
    }
}
