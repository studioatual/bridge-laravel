<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balances';
    protected $fillable = [
        'company_id',
        'description',
        'type',
        'value',
        'created_at',
        'updated_at'
    ];
}
