<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingProduct extends Model
{
    protected $table = "ranking_products";
    protected $fillable = [
        'company_id',
        'code',
        'description',
        'type',
        'total'
    ];
}
