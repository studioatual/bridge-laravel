<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $fillable = [
        'company_id',
        'description',
        'total',
        'created_at',
        'updated_at'
    ];
}
