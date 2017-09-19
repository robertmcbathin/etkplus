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

	Route::post('/dashboard/create-partner',[
		'uses' => 'AdminController@postCreatePartner',
		'as' => 'dashboard.create-partner.post'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/partners/list',[
		'uses' => 'AdminController@getPartnerList',
		'as' => 'dashboard.show-partner-list.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/visits/list',[
		'uses' => 'AdminController@getVisitsList',
		'as' => 'dashboard.show-visits-list.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/partner/{partner_id}/show',[
		'uses' => 'AdminController@getPartnerPage',
		'as' => 'dashboard.partner-page.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/delete',[
		'uses' => 'AdminController@postDeletePartner',
		'as' => 'dashboard.delete_partner.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/edit',[
		'uses' => 'AdminController@postEditPartner',
		'as' => 'dashboard.edit_partner.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/edit-logos',[
		'uses' => 'AdminController@postEditPartnerLogos',
		'as' => 'dashboard.edit_partner_logos.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/load-gallery',[
		'uses' => 'AdminController@postLoadGallery',
		'as' => 'dashboard.load-gallery.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/edit-gallery-item',[
		'uses' => 'AdminController@postEditGalleryItem',
		'as' => 'dashboard.edit-gallery-item.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/delete-gallery-item',[
		'uses' => 'AdminController@postDeleteGalleryItem',
		'as' => 'dashboard.delete-gallery-item.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/delete-partner-address',[
		'uses' => 'AdminController@postDeletePartnerAddress',
		'as' => 'dashboard.delete-partner-address.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/add-partner-address',[
		'uses' => 'AdminController@postAddPartnerAddress',
		'as' => 'dashboard.add-partner-address.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/delete-partner-discount',[
		'uses' => 'AdminController@postDeletePartnerDiscount',
		'as' => 'dashboard.delete-partner-discount.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/add-partner-discount',[
		'uses' => 'AdminController@postAddPartnerDiscount',
		'as' => 'dashboard.add-partner-discount.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/delete-partner-bonus',[
		'uses' => 'AdminController@postDeletePartnerBonus',
		'as' => 'dashboard.delete-partner-bonus.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/add-partner-bonus',[
		'uses' => 'AdminController@postAddPartnerBonus',
		'as' => 'dashboard.add-partner-bonus.post'
		])->middleware('can:show-dashboard-admin,App\User');
	/**
	 * ПОКАЗЫВАТЬ ПАНЕЛЬ УПРАВЛЕНИЯ ПАРТНЕРА
	 */	
	Route::get('/dashboard/create-operation',[
		'uses' => 'PartnerController@getCreateOperation',
		'as' => 'dashboard.partner.create-operation.get'	
		])->middleware('can:show-dashboard-partner,App\User');

	Route::get('/dashboard/show-operations',[
		'uses' => 'AdminController@getShowOperations',
		'as' => 'dashboard.partner.show-operations.get'	
		])->middleware('can:show-dashboard-partner,App\User');
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

	/**
	 * AJAX ЗАПРОСЫ
	 */
	Route::post('/ajax/check_card_and_operations', [ 
		'uses' => 'PartnerController@ajaxCheckCardAndOperations',
   		'as' => 'ajax.check_card_and_operations.post'
    ])->middleware('can:show-dashboard-partner,App\User');
});
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
