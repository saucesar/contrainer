<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsoleOut extends Model
{
    protected $fillable = ['containerDockerId', 'command', 'out', 'status'];
}
