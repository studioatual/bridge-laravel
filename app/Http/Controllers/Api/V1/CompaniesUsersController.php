<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CompaniesUsersController extends Controller
{
    public function index()
    {
        $data = $this->filterData();
    }

    private function filterData()
    {
        $data = [];

        foreach (array_filter(request()->all()) as $key => $value) {
            $data[$key] = trim(strip_tags($value));
        }

        return $data;
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
