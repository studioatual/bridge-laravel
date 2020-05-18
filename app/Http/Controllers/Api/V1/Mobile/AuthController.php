<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthController extends Controller
{
    public function login()
    {
        $credentials = $this->filterData();
        $validator = Validator::make($credentials, $this->getRules(), $this->getMessages());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'E-mail ou Senha Inválido!'], 422);
        }

        $user = auth()->user();
        $companies = $user
            ->companies()
            ->select('id', 'company', 'name', 'cnpj', 'ie')
            ->distinct()
            ->get();

        foreach ($companies as $company) {
            unset($company->pivot);
        }

        return response()->json([
            'token' => $token,
            "user" => $user,
            "companies" => $companies,
            'permissions' => $this->getPermissions()
        ]);
    }

    private function getPermissions()
    {
        $user = auth()->user();
        $permissions = $user
            ->permissions()
            ->select('id', 'name', 'description')
            ->distinct('id')
            ->get();

        $result = [];
        foreach ($permissions as $permission) {
            $result[] = [
                'name' => $permission->name,
                'companies' => $this->getCompanies($permission->id)
            ];
        }

        return $result;
    }

    private function getCompanies($id)
    {
        $user = auth()->user();
        $companies = $user->companies()
            ->where('permission_id', $id)
            ->select('id')
            ->distinct()
            ->get();
        $result = [];
        foreach ($companies as $company) {
            $result[] = $company->id;
        }
        return $result;
    }

    public function getBalances()
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

        return $this->table->selectRaw('company_id, description, type, sum(value) as total')
                    ->groupBy(['company_id', 'description', 'type'])
                    ->orderBy('company_id')
                    ->orderBy('description')
                    ->get();
    }

    public function sendMail()
    {
        $credentials = $this->filterData();
        $validator = Validator::make($credentials, $this->getRules(true), $this->getMessages());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', request()->input('email'))->first();

        if (!$user) {
            return response()->json(['error' => 'E-mail não encontrado!'], 422);
        }

        return response()->json([
            'result' => 'ok'
        ]);
    }

    public function user()
    {
        $token = JWTAuth::fromUser(auth()->user());

        $user = auth()->user();
        $companies = $user
            ->companies()
            ->select('id', 'company', 'name', 'cnpj', 'ie')
            ->distinct()
            ->get();

        foreach ($companies as $company) {
            unset($company->pivot);
        }

        return response()->json([
            'token' => $token,
            "user" => $user,
            "companies" => $companies,
            'permissions' => $this->getPermissions()
        ]);
    }

    private function filterData()
    {
        $data = [];

        foreach (array_filter(request()->all()) as $key => $value) {
            $data[$key] = trim(strip_tags($value));
        }

        return $data;
    }

    public function getRules($mail = false)
    {
        if ($mail) {
            return [
                'email' => 'required|email',
            ];
        }
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function getMessages()
    {
        return [
            'required' => 'O campo é obrigatório!',
            'email' => 'E-mail inválido!'
        ];
    }
}
