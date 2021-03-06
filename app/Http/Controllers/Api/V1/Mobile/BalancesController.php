<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Balance;
use Illuminate\Support\Facades\DB;

class BalancesController extends Controller
{
    protected $table;

    public function __construct()
    {
        $this->table = DB::table('balances');
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

        return $this->table->selectRaw('description, type, sum(value) as total')
                    ->groupBy(['description', 'type'])
                    ->orderBy('description')
                    ->get();
    }

    public function show(Company $company)
    {
        return $this->table->where('company_id', $company->id)
                    ->selectRaw('description, type, sum(value) as total')
                    ->groupBy(['description', 'type'])
                    ->orderBy('description')
                    ->get();
    }
}
