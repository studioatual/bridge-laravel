<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Permission;
use App\Models\User;

class CompaniesUsersPermissionsController extends Controller
{
    public function storeBatches()
    {
        $data = request()->all();

        if (!isset($data['companies'])) {
            return response()->json(['message' => 'É necessário enviar as empresas.'], 422);
        }

        $errors = [];
        $persistData = [];
        foreach ($data['companies'] as $row) {
            $company = Company::where('cnpj', preg_replace('/\D/', '', $row['company']))->first();
            $user = User::where('cpf_cnpj', preg_replace('/\D/', '', $row['user']))->first();
            $permission = Permission::where('name', trim($row['permission']))->first();

            if ($company && $user && $permission) {
                $persistData[] = [
                    'company' => $company,
                    'user_id' => $user->id,
                    'permission_id' => $permission->id
                ];
            } else {
                $errors[] = [
                    'fields' => $data,
                    'errors' => $row
                ];
            }
        }

        if (count($errors)) {
            return response()->json($errors, 422);
        }

        foreach ($persistData as $row) {
            $company = $row['company'];
            $company->users()->attach($row['user_id'], ['permission_id' => $row['permission_id']]);
        }

        return response()->json(['result' => 'ok']);
    }

    public function destroyAll()
    {
        $data = request()->all();

        if (!isset($data['companies'])) {
            return response()->json(['message' => 'É necessário enviar as empresas.'], 422);
        }

        foreach ($data['companies'] as $cnpj) {
            $company = Company::where('cnpj', preg_replace('/\D/', '', $cnpj))->first();
            if ($company) {
                $company->users()->detach();
            }
        }

        return response()->json(['result' => 'ok']);
    }
}
