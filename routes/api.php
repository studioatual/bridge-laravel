<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('/auth', 'Api\V1\AuthController@login');
    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::get('/auth', 'Api\V1\AuthController@user');
        Route::resources([
            'groups' => 'Api\V1\GroupsController',
            'users' => 'Api\V1\UsersController',
            'companies' => 'Api\V1\CompaniesController'
        ]);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
