<?php

namespace App\Http\Controllers\Api\V1;

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

        return response()->json([
            'token' => $token
        ]);
    }

    public function user()
    {
        $token = JWTAuth::fromUser(auth()->user());

        return response()->json([
            'token' => $token
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
