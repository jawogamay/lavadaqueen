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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['customers' => 'API\CustomerController']);
Route::get('updateUser' , 'API\CustomerController@editUser');
Route::apiResources(['posts' => 'PostController']);
Route::get('viewpost','PostController@viewPost');
Route::get('countCustomer','CountController@countCustomer');
Route::get('countPost','CountController@countPost');
Route::get('countTransaction','CountController@countTransaction');
Route::any('statuschange/{transaction}','TransactionController@editStatus');
Route::get('getstatus','StatusController@getStatus');
Route::get('mytransaction','TransactionController@getCustomerTransaction');
Route::apiResources(['transactions' => 'TransactionController']);
Route::apiResources(['services'  => 'ServiceController']);
Route::post('rating','RateController@setrating')->name('setrating');
Route::get('getrate','RateController@getrate')->name('getrate');
