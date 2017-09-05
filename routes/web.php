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

Route::group(['middleware' => 'web'], function () {
	Route::get('/',[
		'uses' => 'SiteController@showIndex',
		'as' => 'site.show-index.get'
		]);
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
	Route::get('profile/{id}',[
		'uses' => 'SiteController@showProfilePage',
		'as' => 'site.show-user-profile-page.get'
		]);
	Route::get('partner/{id}/reviews',[
		'uses' => 'SiteController@showPartnerReviewsPage',
		'as' => 'site.show-partner-reviews-page.get'
		]);
});
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
	/**
	 * ПОКАЗЫВАТЬ ПАНЕЛЬ УПРАВЛЕНИЯ
	 */
	Route::get('/dashboard',[
		'uses' => 'AdminController@showDashboard',
		'as' => 'dashboard.show-dashboard.get'
		])->middleware('can:show-dashboard,App\User');
	Route::get('/dashboard/create-partner',[
		'uses' => 'AdminController@showCreatePartnerPage',
		'as' => 'dashboard.create-partner.get'	
		])->middleware('can:show-dashboard-admin,App\User');
	/**
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * 
	 */
	/**
	 * ПОКАЗЫВАТЬ ЛИЧНЫЙ КАБИНЕТ
	 */
	Route::get('profile',[
		'uses' => 'UserController@showProfilePage',
		'as' => 'profile.show-profile-page.get'
		]);
	Route::post('profile/leave-review',[
		'uses' =>'UserController@leaveReview',
		'as' => 'profile.leave-review.post'
		]);
});
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
