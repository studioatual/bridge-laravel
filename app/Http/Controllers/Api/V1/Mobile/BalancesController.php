<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Company;

class BalancesController extends Controller
{
    public function index()
    {
        $companies = auth('api')->user()->companies;
        $balances = [];
        foreach ($companies as $company) {
            $data = $company->balances()->selectRaw('description, type, sum(value) as total')->groupBy(['description', 'type'])->get();
            $balances = array_merge($balances, $data->toArray());
        }
        return $balances;
    }

    public function show(Company $company)
    {
        return $company->balances()->selectRaw('description, type, sum(value) as total')->groupBy(['description', 'type'])->get();
    }
}
