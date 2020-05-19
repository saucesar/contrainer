<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsoleOut extends Model
{
    protected $fillable = ['docker_id', 'command', 'out', 'status'];
}