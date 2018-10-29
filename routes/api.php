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
Route::post('/', function(){
  return 'API POST'. str_plural('status');
});
Route::get('/', function(){
  $r = ["test" => null];
  echo gettype("");
  return 'API GET';
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/create', 'UserController@create');
Route::get('/user/retrieve', 'UserController@retrieve');
Route::patch('/user/update', 'UserController@update');
Route::patch('/user/change-password', 'UserController@changePassword');

Route::post('/user/create', 'UserController@create');

Route::post('/client-account/change-status', 'ClientAccountController@changeStatus');
Route::post('/client-account/create', 'ClientAccountController@create');
Route::get('/client-account/retrieve', 'ClientAccountController@retrieve');
Route::patch('/client-account/update', 'ClientAccountController@update');
Route::delete('/client-account/delete', 'ClientAccountController@delete');

Route::post('/user-bank-account/change', 'UserBankAccountController@change');
Route::post('/user-bank-account/create', 'UserBankAccountController@create');
Route::get('/user-bank-account/retrieve', 'UserBankAccountController@retrieve');
Route::patch('/user-bank-account/update', 'UserBankAccountController@update');
Route::delete('/user-bank-account/delete', 'UserBankAccountController@delete');

Route::post('/client-account-diary/create', 'ClientAccountDiaryController@create');
Route::get('/client-account-diary/retrieve', 'ClientAccountDiaryController@retrieve');
Route::patch('/client-account-diary/update', 'ClientAccountDiaryController@update');
Route::delete('/client-account-diary/delete', 'ClientAccountDiaryController@delete');

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