<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersCompaniesController extends Controller
{
    public function listAllBalances()
    {
        $companies = auth('api')->user()->companies;
        $balances = [];
        foreach ($companies as $company) {
            $data = $company->balances()->selectRaw('description, type, sum(value) as total')->groupBy(['description', 'type'])->get();
            $balances = array_merge($balances, $data->toArray());
        }
        return $balances;
    }

    public function listBalances(Company $company)
    {
        return $company->balances()->selectRaw('description, type, sum(value) as total')->groupBy(['description', 'type'])->get();
    }

    public function listCompanies(User $user)
    {
        return $user->companies;
    }

    public function storeCompanies(User $user)
    {
        $companies = [];
        foreach (request()->input('companies') as $cnpj) {
            $cnpj = preg_replace('/\D/', '', $cnpj);
            $company = Company::where([
                ['group_id', $user->group_id],
                ['cnpj', $cnpj],
            ])->first();

            if ($company) {
                $companies[] = $company->id;
            }
        }

        if (!count($companies)) {
            $user->companies()->detach();
        }

        $user->companies()->sync($companies);
        return $user->companies;
    }

    public function listUsers(Company $company)
    {
        return $company->users;
    }

    public function storeUsers(Company $company)
    {
        $users = [];
        foreach (request()->input('users') as $cpfCnpj) {
            $cpfCnpj = preg_replace('/\D/', '', $cpfCnpj);
            $user = User::where([
                ['group_id', $company->group_id],
                ['cpf_cnpj', $cpfCnpj],
            ])->first();

            if ($user) {
                $users[] = $user->id;
            }
        }

        if (!count($users)) {
            $company->users()->detach();
        }

        $company->users()->sync($users);
        return $company->users;
    }
}
