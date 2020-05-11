<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    protected $table = 'cashflow';
    protected $fillable = [
        'company_id',
        'amount_payable',
        'amount_receivable',
        'day_balance',
        'accumalated_balance',
        'accumulated_pending',
        'cashflow_date',
    ];
}
