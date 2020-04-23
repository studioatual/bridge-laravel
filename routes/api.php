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

Route::get('/users', 'UserController@index');
Route::resource('customers', 'CustomerController');
Route::get('/products', 'ProductController@index');
Route::get('/orders', 'OrderController@index');
Route::put('/controls/{control}', 'ControlController@update');

Route::prefix('v1/standard')->group(function () {
    Route::resources([
        'groups' => 'Api\V1\Standard\GroupsController'
    ]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
