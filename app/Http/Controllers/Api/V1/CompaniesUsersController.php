<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CompaniesUsersController extends Controller
{
    public function storeAndUpdateBatches()
    {
        $companies = [];
        $errors = [];

        foreach (request()->input('companies') as $item) {

            $data = $this->filterData($item);

            $validator = Validator::make($data, [
                'company' => 'required|cnpj|exists:companies,cnpj',
            ], $this->getMessages());

            if ($validator->fails()) {
                $errors[] = [
                    'fields' => $item,
                    'errors' => $validator->errors()
                ];
            }

            if (!count($errors)) {
                $users = [];
                foreach ($data['users'] as $cnpj) {
                    $user = User::where('cnpj', $cnpj)->first();
                    if (!$user) {
                        $errors[] = [
                            'fields' => $item,
                            'errors' => 'Usuário não encontrado: ' . $cnpj,
                        ];
                    } else {
                        $users[] = $user->id;
                    }
                }
                $data['users'] = $users;
            }

            $companies[] = $data;
        }

        if (count($errors)) {
            return response()->json($errors, 422);
        }

        foreach ($companies as $item) {
            $company = Company::where('cnpj', $item['company'])->first();

            if (!count($item['users'])) {
                $company->users()->detach();
            }

            $company->users()->sync($item['users']);
        }

        return response()->json(['result' => 'ok']);
    }

    private function filterData($inputs)
    {
        $data = [];
        $list = array_filter((array) $inputs, 'strlen');

        foreach ($list as $key => $value) {
            $data[$key] = trim(strip_tags($value));
        }

        if (isset($data['company'])) {
            $data['company'] = preg_replace('/[^\d\,]/', '', $data['cnpj']);

            $users = [];
            foreach ($data['users'] as $user) {
                $users[] = preg_replace('/[^\d\,]/', '', $user);
            }
            $data['users'] = $users;
        }

        return $data;
    }
    /*

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
    */
}
