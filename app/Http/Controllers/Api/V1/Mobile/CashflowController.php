<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CashflowController extends Controller
{
    protected $table;

    public function __construct()
    {
        $this->table = DB::table('cashflow');
    }

    public function index()
    {
        $user = auth()->user();
        $companies = $user->companies()->select('id')->distinct()->get();

        $i = 0;
        foreach($companies as $company) {
            if ($i === 0) {
                $this->table->where('company_id', $company->id);
            } else {
                $this->table->orWhere('company_id', $company->id);
            }
            $i++;
        }

        return $this->table->selectRaw('sum(amount_payable) as total_payable,sum(amount_receivable) as total_receivable,sum(day_balance) as total_balance,sum(accumulated_balance) as total_accumulated,sum(accumulated_pending) as total_pending,cashflow_date')
                    ->groupBy('cashflow_date')
                    ->orderBy('cashflow_date', 'desc')
                    ->get();
    }

    public function show(Company $company)
    {
        return $this->table->where('company_id', $company->id)
                    ->selectRaw('sum(amount_payable) as total_payable,sum(amount_receivable) as total_receivable,sum(day_balance) as total_balance,sum(accumulated_balance) as total_accumulated,sum(accumulated_pending) as total_pending,cashflow_date')
                    ->groupBy('cashflow_date')
                    ->orderBy('cashflow_date', 'desc')
                    ->get();
    }
}
