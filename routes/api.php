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

    Route::prefix('mobile')->group(function () {
        Route::post('/auth', 'Api\V1\Mobile\AuthController@login');
        Route::post('/authmail', 'Api\V1\Mobile\AuthController@sendMail');

        Route::group(['middleware' => 'jwt.verify'], function () {
            Route::get('/auth', 'Api\V1\Mobile\AuthController@user');
            Route::get('/balances', 'Api\V1\Mobile\BalancesController@index');
            Route::get('/balances/{company}', 'Api\V1\Mobile\BalancesController@show');
        });
    });

    Route::post('/auth', 'Api\V1\AuthController@login');

    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::get('/auth', 'Api\V1\AuthController@user');

        Route::post('/groups/batches', 'Api\V1\GroupsController@storeBatches');
        Route::put('/groups/batches', 'Api\V1\GroupsController@updateBatches');
        Route::delete('/groups/batches', 'Api\V1\GroupsController@destroyBatches');

        Route::post('/users/batches', 'Api\V1\UsersController@storeBatches');
        Route::put('/users/batches', 'Api\V1\UsersController@updateBatches');
        Route::delete('/users/batches', 'Api\V1\UsersController@destroyBatches');

        Route::post('/companies/batches', 'Api\V1\CompaniesController@storeBatches');
        Route::put('/companies/batches', 'Api\V1\CompaniesController@updateBatches');
        Route::delete('/companies/batches', 'Api\V1\CompaniesController@destroyBatches');

        Route::post('/balances/batches', 'Api\V1\BalancesController@storeBatches');
        Route::put('/balances/batches', 'Api\V1\BalancesController@updateBatches');
        Route::delete('/balances/batches', 'Api\V1\BalancesController@destroyBatches');

        Route::post('/permissions/batches', 'Api\V1\PermissionsController@storeBatches');
        Route::put('/permissions/batches', 'Api\V1\PermissionsController@updateBatches');
        Route::delete('/permissions/batches', 'Api\V1\PermissionsController@destroyBatches');

        Route::get('/companies_users', 'Api\V1\CompaniesUsersController@index');

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
