<?php

use Illuminate\Http\Request;

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
Route::get('/', function(){
  return 'API POST'. str_plural('status');
});
Route::post('/', function(){
  $r = ["test" => null];
  echo gettype("");
  return 'API GET';
});
Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/create', 'UserController@create');
Route::post('/user/retrieve', 'UserController@retrieve');
Route::post('/user/update', 'UserController@update');
Route::post('/user/change-password', 'UserController@changePassword');

Route::post('/user/create', 'UserController@create');

Route::post('/client-account/change-status', 'ClientAccountController@changeStatus');
Route::post('/client-account/create', 'ClientAccountController@create');
Route::post('/client-account/retrieve', 'ClientAccountController@retrieve');
Route::post('/client-account/update', 'ClientAccountController@update');
Route::post('/client-account/delete', 'ClientAccountController@delete');

Route::post('/user-bank-account/change', 'UserBankAccountController@change');
Route::post('/user-bank-account/create', 'UserBankAccountController@create');
Route::post('/user-bank-account/retrieve', 'UserBankAccountController@retrieve');
Route::post('/user-bank-account/update', 'UserBankAccountController@update');
Route::post('/user-bank-account/delete', 'UserBankAccountController@delete');

Route::post('/client-account-diary/create', 'ClientAccountDiaryController@create');
Route::post('/client-account-diary/retrieve', 'ClientAccountDiaryController@retrieve');
Route::post('/client-account-diary/update', 'ClientAccountDiaryController@update');
Route::post('/client-account-diary/delete', 'ClientAccountDiaryController@delete');

Route::post('/client-account-status/create', 'ClientAccountStatusController@create');
Route::post('/client-account-status/retrieve', 'ClientAccountStatusController@retrieve');
Route::post('/client-account-status/update', 'ClientAccountStatusController@update');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/', function(){
      return 'tae';
    });
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('user', 'AuthController@user');

});