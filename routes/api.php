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
    Route::post('/authmail', 'Api\V1\AuthController@sendMail');

    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::get('/auth', 'Api\V1\AuthController@user');

        Route::post('/groups/batches', 'Api\V1\GroupsController@storeBaches');
        Route::put('/groups/batches', 'Api\V1\GroupsController@updateBaches');
        Route::delete('/groups/batches', 'Api\V1\GroupsController@destroyBaches');

        Route::post('/users/batches', 'Api\V1\UsersController@storeBaches');
        Route::put('/users/batches', 'Api\V1\UsersController@updateBaches');
        Route::delete('/users/batches', 'Api\V1\UsersController@destroyBaches');

        Route::post('/companies/batches', 'Api\V1\CompaniesController@storeBaches');
        Route::put('/companies/batches', 'Api\V1\CompaniesController@updateBaches');
        Route::delete('/companies/batches', 'Api\V1\CompaniesController@destroyBaches');

        Route::post('/balances/batches', 'Api\V1\BalancesController@storeBaches');
        Route::put('/balances/batches', 'Api\V1\BalancesController@updateBaches');
        Route::delete('/balances/batches', 'Api\V1\BalancesController@destroyBaches');

        Route::post('/permissions/batches', 'Api\V1\PermissionsController@storeBaches');
        Route::put('/permissions/batches', 'Api\V1\PermissionsController@updateBaches');
        Route::delete('/permissions/batches', 'Api\V1\PermissionsController@destroyBaches');

        Route::resources([
            'groups' => 'Api\V1\GroupsController',
            'users' => 'Api\V1\UsersController',
            'companies' => 'Api\V1\CompaniesController',
            'balances' => 'Api\V1\BalancesController',
            'permissions' => 'Api\V1\PermissionsController',
        ]);

        /*
        Route::get('/companies/balances', 'Api\V1\UsersCompaniesController@listAllBalances');
        Route::get('/users/{user}/companies', 'Api\V1\UsersCompaniesController@listCompanies');
        Route::post('/users/{user}/companies', 'Api\V1\UsersCompaniesController@storeCompanies');
        Route::get('/companies/{company}/balances', 'Api\V1\UsersCompaniesController@listBalances');
        Route::get('/companies/{company}/users', 'Api\V1\UsersCompaniesController@listUsers');
        Route::post('/companies/{company}/users', 'Api\V1\UsersCompaniesController@storeUsers');
        */
    });
});
