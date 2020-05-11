<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingClient extends Model
{
    protected $table = "ranking_clients";
    protected $fillable = [
        'company_id',
        'client',
        'name',
        'total'
    ];
}
