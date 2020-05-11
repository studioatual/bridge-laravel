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

        Route::get('/groups', 'Api\V1\GroupsController@index');
        Route::post('/groups/batches', 'Api\V1\GroupsController@storeBatches');
        Route::delete('/groups/destroy', 'Api\V1\GroupsController@destroyAll');

        Route::get('/users', 'Api\V1\UsersController@index');
        Route::post('/users/batches', 'Api\V1\UsersController@storeBatches');
        Route::delete('/users/destroy', 'Api\V1\UsersController@destroyAll');

        Route::get('/companies', 'Api\V1\CompaniesController@index');
        Route::post('/companies/batches', 'Api\V1\CompaniesController@storeBatches');
        Route::delete('/companies/destroy', 'Api\V1\CompaniesController@destroyAll');

        Route::get('/balances', 'Api\V1\BalancesController@index');
        Route::post('/balances/batches', 'Api\V1\BalancesController@storeBatches');
        Route::delete('/balances/destroy', 'Api\V1\BalancesController@destroyAll');

        Route::get('/permissions', 'Api\V1\PermissionsController@index');
        Route::post('/permissions/batches', 'Api\V1\PermissionsController@storeBatches');
        Route::delete('/permissions/destroy', 'Api\V1\PermissionsController@destroyAll');

        Route::post('/companies_users_permissions/batches', 'Api\V1\CompaniesUsersPermissionsController@storeBatches');
        Route::delete('/companies_users_permissions/destroy', 'Api\V1\CompaniesUsersPermissionsController@destroyAll');

        Route::get('/cashflow', 'Api\V1\CashflowController@index');
        Route::post('/cashflow/batches', 'Api\V1\CashflowController@storeBatches');
        Route::delete('/cashflow/destroy', 'Api\V1\CashflowController@destroyAll');

        Route::get('/ranking_products', 'Api\V1\RankingProductsController@index');
        Route::post('/ranking_products/batches', 'Api\V1\RankingProductsController@storeBatches');
        Route::delete('/ranking_products/destroy', 'Api\V1\RankingProductsController@destroyAll');

        Route::get('/ranking_clients', 'Api\V1\RankingClientsController@index');
        Route::post('/ranking_clients/batches', 'Api\V1\RankingClientsController@storeBatches');
        Route::delete('/ranking_clients/destroy', 'Api\V1\RankingClientsController@destroyAll');
    });
});
