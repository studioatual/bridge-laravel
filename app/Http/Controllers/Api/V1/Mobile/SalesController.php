<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    protected $table;

    public function __construct()
    {
        $this->table = DB::table('sales');
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

        return $this->table->selectRaw('description, sum(total) as vtotal')
                    ->groupBy('description')
                    ->get();
    }

    public function show(Company $company)
    {
        return $this->table->where('company_id', $company->id)
                    ->selectRaw('description, sum(total) as vtotal')
                    ->groupBy('description')
                    ->get();
    }
}
