<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $table = 'controls';
    protected $fillable = [
        'type',
        'count',
    ];
}
