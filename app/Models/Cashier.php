<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    protected $table = 'cashiers';
    protected $fillable = [
        'company_id',
        'type',
        'method',
        'total',
        'cashier_date'
    ];
}
