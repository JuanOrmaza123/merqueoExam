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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Api\AuthController@login')->name('login');
    Route::post('signup', 'Api\AuthController@signUp')->name('signup');

    Route::group(['middleware' => ['api']], function () {
        Route::get('logout', 'Api\AuthController@logout')->name('logout');
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'cashFlow', 'middleware' => ['auth:api']], function () {
    Route::post('/create', 'CashFlowController@createBaseCashFlow')
        ->name('cashFlow.create');

    Route::get('/getStatus', 'CashFlowController@getStatusCashFlow')
        ->name('cashFlow.getStatus');

    Route::get('/setEmpty', 'CashFlowController@setEmptyFlowCash')
        ->name('cashFlow.setEmpty');
});

Route::group(['prefix' => 'payment', 'middleware' => ['auth:api']], function () {
    Route::post('/create', 'PaymentController@createPayment')
        ->name('payment.create');
});

Route::group(['prefix' => 'log', 'middleware' => ['auth:api']], function () {
    Route::get('/getLogs', 'LogController@getLogs')
        ->name('log.getLogs');

    Route::post('/getStatusByDate', 'LogController@getStatusByDate')
        ->name('log.getStatusByDate');
});

