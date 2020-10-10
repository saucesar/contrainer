<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCategory extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'ram_limit', 'storage_limit'];
}
