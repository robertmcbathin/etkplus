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
Route::post('/mobile/partner/login',[
	'uses' => 'APIController@postLogin',
	'as' => 'api.login.post'
]);
Route::post('/mobile/partner/get-card',[
	'uses' => 'APIController@postGetCard',
	'as' => 'api.get-card.post'
]);
Route::post('/mobile/partner/create-operation',[
	'uses' => 'APIController@postCreateOperation',
	'as' => 'api.create-operation.post'
]);
Route::post('/mobile/partner/create-operation-1c',[
	'uses' => 'APIController@postCreateOperation1C',
	'as' => 'api.create-operation-1c.post'
]);
