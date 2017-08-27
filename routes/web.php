<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::group(['middleware' => 'web'], function () {
	Route::get('category/{id}',[
		'uses' => 'SiteController@showCategory',
		'as' => 'site.show-category.get'
		]);
	Route::get('categories',[
		'uses' => 'SiteController@showCategories',
		'as' => 'site.show-categories.get'
		]);
	Route::get('partner/{id}',[
		'uses' => 'SiteController@showPartner',
		'as' => 'site.show-partner.get'
		]);
	Route::get('dashboard',[
		'uses' => 'AdminController@showDashboard',
		'as' => 'dashboard.show-dashboard.get'
		]);
	Route::get('profile',[
		'uses' => 'UserController@showProfilePage',
		'as' => 'profile.show-profile-page.get'
		]);
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
