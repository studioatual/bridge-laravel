<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function login()
    {
        $email = request()->input('email');
        $password = request()->input('password');
        if ($email != 'willian.souza@fbssistemas.com.br' || $password != '123456') {
            return response()->json(['message' => 'E-mail ou Senha Inválido!'], 400);
        }
        return response()->json(['token' => 'PwdTnhZFwLWFjA6HRL/J7oMl0WmybNbfcOSZZ0OfR80=']);
    }
}
