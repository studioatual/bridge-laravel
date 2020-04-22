<?php

namespace App\Models\Standard;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'standard_groups';
    protected $fillable = [
        'name',
        'code',
        'cnpj',
        'active',
    ];
}
