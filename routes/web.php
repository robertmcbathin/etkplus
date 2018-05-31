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
	Route::get('/about',[
		'uses' => 'SiteController@showAbout',
		'as' => 'site.show-about.get'
		]);	
	Route::get('/partnership',[
		'uses' => 'SiteController@showPartnership',
		'as' => 'site.show-partnership.get'
		]);	
	Route::get('/partnership/loyalty',[
		'uses' => 'SiteController@showPartnershipLoyalty',
		'as' => 'site.show-partnership-loyalty.get'
		]);	
	Route::get('category/{id}',[
		'uses' => 'SiteController@showCategory',
		'as' => 'site.show-category.get'
		]);
	Route::get('categories',[
		'uses' => 'SiteController@showCategories',
		'as' => 'site.show-categories.get'
		]);
	Route::get('rules',[
		'uses' => 'SiteController@showRules',
		'as' => 'site.show-rules.get'
		]);
	Route::get('offer',[
		'uses' => 'SiteController@showOffer',
		'as' => 'site.show-offer.get'
		]);
	Route::get('contacts',[
		'uses' => 'SiteController@showContacts',
		'as' => 'site.show-contacts.get'
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
	Route::post('create-invoice',[
		'uses' => 'SiteController@postCreateInvoice',
		'as' => 'site.create-invoice.post'
		]);
});
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
	/**
	 * ПОКАЗЫВАТЬ ПАНЕЛЬ УПРАВЛЕНИЯ АДМИНА
	 */
	Route::get('/dashboard',[
		'uses' => 'AdminController@showDashboard',
		'as' => 'dashboard.show-dashboard.get'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/create-partner',[
		'uses' => 'AdminController@showCreatePartnerPage',
		'as' => 'dashboard.create-partner.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/create-partner',[
		'uses' => 'AdminController@postCreatePartner',
		'as' => 'dashboard.create-partner.post'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/approve-review',[
		'uses' => 'AdminController@postApproveReview',
		'as' => 'dashboard.approve-review.post'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/disapprove-review',[
		'uses' => 'AdminController@postDisapproveReview',
		'as' => 'dashboard.disapprove-review.post'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/operations',[
		'uses' => 'AdminController@showOperationsPage',
		'as' => 'dashboard.show-operations.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/card/{card_number}/show',[
		'uses' => 'AdminController@getCard',
		'as' => 'dashboard.card.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/users/list',[
		'uses' => 'AdminController@showUserListPage',
		'as' => 'dashboard.show-user-list.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/reviews/list',[
		'uses' => 'AdminController@showReviewListPage',
		'as' => 'dashboard.show-review-list.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/categories/list',[
		'uses' => 'AdminController@showCategoryListPage',
		'as' => 'dashboard.show-category-list.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/tariffs/list',[
		'uses' => 'AdminController@showTariffListPage',
		'as' => 'dashboard.show-tariff-list.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/billing',[
		'uses' => 'AdminController@showBillingPage',
		'as' => 'dashboard.show-billing-page.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/salary',[
		'uses' => 'AdminController@showSalaryPage',
		'as' => 'dashboard.show-salary-page.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/emails',[
		'uses' => 'AdminController@showEmailsPage',
		'as' => 'dashboard.show-emails-distribution.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/emails/send/test',[
		'uses' => 'AdminController@sendTestEmailDistribution',
		'as' => 'dashboard.send-email-distribution.post.test'
	]);

	Route::post('/dashboard/emails/send',[
		'uses' => 'AdminController@sendEmailDistribution',
		'as' => 'dashboard.send-email-distribution.post'
	]);

	Route::get('/dashboard/log',[
		'uses' => 'AdminController@showLogPage',
		'as' => 'dashboard.show-log.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/log/{type?}',[
		'uses' => 'AdminController@showLogPage',
		'as' => 'dashboard.show-log.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/chat/{partner_id?}',[
		'uses' => 'AdminController@showChatPage',
		'as' => 'dashboard.show-chat.get'	
		])->middleware('can:show-dashboard-admin,App\User');
/**
 *
 *
 *
 * 
 * ETKTRADE
 *
 *
 *
 *
 * 
 */

	Route::get('/dashboard/shop/categories/{level}',[
		'uses' => 'AdminController@showShopCategoriesPage',
		'as' => 'dashboard.shop.show-categories.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/category/add',[
		'uses' => 'AdminController@postAddShopCategory',
		'as' => 'dashboard.shop.add-category.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/category/edit',[
		'uses' => 'AdminController@postEditShopCategory',
		'as' => 'dashboard.shop.edit-category.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/category/delete',[
		'uses' => 'AdminController@postDeleteShopCategory',
		'as' => 'dashboard.shop.delete-category.post'
	])->middleware('can:show-dashboard-admin,App\User');




	Route::post('/dashboard/shop/category/attribute/add',[
		'uses' => 'AdminController@postAddCategoryAttribute',
		'as' => 'dashboard.shop.add-category-attribute.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/category/attribute/edit',[
		'uses' => 'AdminController@postEditCategoryAttribute',
		'as' => 'dashboard.shop.edit-category-attribute.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/category/attribute/delete',[
		'uses' => 'AdminController@postDeleteCategoryAttribute',
		'as' => 'dashboard.shop.delete-category-attribute.post'
	])->middleware('can:show-dashboard-admin,App\User');




	Route::get('/dashboard/shop/shops',[
		'uses' => 'AdminController@showShopShopsPage',
		'as' => 'dashboard.shop.show-shops.get'	
		])->middleware('can:show-dashboard-admin,App\User');	

	Route::post('/dashboard/shop/shop/add',[
		'uses' => 'AdminController@postAddShopShop',
		'as' => 'dashboard.shop.add-shop.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/shop/edit',[
		'uses' => 'AdminController@postEditShopShop',
		'as' => 'dashboard.shop.edit-shop.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/shop/delete',[
		'uses' => 'AdminController@postDeleteShopShop',
		'as' => 'dashboard.shop.delete-shop.post'
	])->middleware('can:show-dashboard-admin,App\User');


	Route::get('/dashboard/shop/goods',[
		'uses' => 'AdminController@showShopGoodsPage',
		'as' => 'dashboard.shop.show-goods.get'	
		])->middleware('can:show-dashboard-admin,App\User');	

	Route::get('/dashboard/shop/product/add',[
		'uses' => 'AdminController@getAddShopProduct',
		'as' => 'dashboard.shop.add-product.get'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/product/add',[
		'uses' => 'AdminController@postAddShopProduct',
		'as' => 'dashboard.shop.add-product.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/good/csv/add',[
		'uses' => 'AdminController@postAddShopGoodsCsv',
		'as' => 'dashboard.shop.add-goods-csv.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/good/edit',[
		'uses' => 'AdminController@postEditShopGood',
		'as' => 'dashboard.shop.edit-good.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/good/delete',[
		'uses' => 'AdminController@postDeleteShopGood',
		'as' => 'dashboard.shop.delete-good.post'
	])->middleware('can:show-dashboard-admin,App\User');


	Route::get('/dashboard/shop/brands',[
		'uses' => 'AdminController@showShopBrandsPage',
		'as' => 'dashboard.shop.show-brands.get'	
		])->middleware('can:show-dashboard-admin,App\User');		

	Route::post('/dashboard/shop/brand/add',[
		'uses' => 'AdminController@postAddShopBrand',
		'as' => 'dashboard.shop.add-brand.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/brand/edit',[
		'uses' => 'AdminController@postEditShopBrand',
		'as' => 'dashboard.shop.edit-brand.post'
	])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/shop/brand/delete',[
		'uses' => 'AdminController@postDeleteShopBrand',
		'as' => 'dashboard.shop.delete-brand.post'
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
 *
 * 
 */
	Route::get('/dashboard/partners/list',[
		'uses' => 'AdminController@getPartnerList',
		'as' => 'dashboard.show-partner-list.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/companies/list',[
		'uses' => 'AdminController@getCompaniesList',
		'as' => 'dashboard.show-companies-list.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/companies/add',[
		'uses' => 'AdminController@postCreateCompany',
		'as' => 'dashboard.add-company.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/companies/edit',[
		'uses' => 'AdminController@postEditCompany',
		'as' => 'dashboard.edit-company.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/companies/delete',[
		'uses' => 'AdminController@postDeleteCompany',
		'as' => 'dashboard.delete-company.post'
		])->middleware('can:show-dashboard-admin,App\User');


	Route::get('/dashboard/visits/list',[
		'uses' => 'AdminController@getVisitsList',
		'as' => 'dashboard.show-visits-list.get'	
		])->middleware('can:show-dashboard-admin,App\User');

	Route::get('/dashboard/visits/{sort_param}/list',[
		'uses' => 'AdminController@getVisitsListByParam',
		'as' => 'dashboard.show-visits-list-by-param.get'	
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

	Route::post('/dashboard/partner/edit-logo',[
		'uses' => 'AdminController@postEditPartnerLogo',
		'as' => 'dashboard.edit_partner_logo.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/edit-limit',[
		'uses' => 'AdminController@postEditPartnerLimit',
		'as' => 'dashboard.edit_partner_limit.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/partner/edit-background',[
		'uses' => 'AdminController@postEditPartnerBackground',
		'as' => 'dashboard.edit_partner_background.post'
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

	Route::post('/dashboard/user/add',[
		'uses' => 'AdminController@postAddUser',
		'as' => 'dashboard.add-user.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/category/add',[
		'uses' => 'AdminController@postAddCategory',
		'as' => 'dashboard.add-category.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/tariff/add',[
		'uses' => 'AdminController@postAddTariff',
		'as' => 'dashboard.add-tariff.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/tariff/change',[
		'uses' => 'AdminController@postChangeTariff',
		'as' => 'dashboard.change-partner-tariff.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/salary/pay',[
		'uses' => 'AdminController@postPaySalary',
		'as' => 'dashboard.pay-salary.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/tariff/edit',[
		'uses' => 'AdminController@postEditTariff',
		'as' => 'dashboard.edit-tariff.post'
		])->middleware('can:show-dashboard-admin,App\User');

	Route::post('/dashboard/account/increase',[
		'uses' => 'AdminController@postIncreaseAccount',
		'as' => 'dashboard.increase-account.post'
		])->middleware('can:show-dashboard-admin,App\User');
	/**
	 * ПОКАЗЫВАТЬ ПАНЕЛЬ УПРАВЛЕНИЯ АГЕНТА
	 */	
	Route::get('/agent/dashboard',[
		'uses' => 'AgentController@showDashboard',
		'as' => 'dashboard.agent.show-dashboard.get'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::get('/agent/dashboard/operations',[
		'uses' => 'AgentController@showOperations',
		'as' => 'dashboard.agent.show-operations.get'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::get('/agent/dashboard/partners/list',[
		'uses' => 'AgentController@getPartnerList',
		'as' => 'dashboard.agent.show-partner-list.get'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::get('/agent/dashboard/billing',[
		'uses' => 'AgentController@getBillingPage',
		'as' => 'dashboard.agent.billing.get'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::get('/agent/dashboard/create-partner',[
		'uses' => 'AgentController@showCreatePartnerPage',
		'as' => 'dashboard.agent.create-partner.get'	
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/create-partner',[
		'uses' => 'AgentController@postCreatePartner',
		'as' => 'dashboard.agent.create-partner.post'	
		])->middleware('can:show-dashboard-agent,App\User');

	Route::get('/agent/dashboard/partner/{partner_id}/show',[
		'uses' => 'AgentController@getPartnerPage',
		'as' => 'dashboard.agent.partner-page.get'	
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/delete',[
		'uses' => 'AgentController@postDeletePartner',
		'as' => 'dashboard.agent.delete_partner.post'
		])->middleware('can:show-dashboard-agent,App\User');

Route::post('/agent/dashboard/partner/edit',[
		'uses' => 'AgentController@postEditPartner',
		'as' => 'dashboard.agent.edit_partner.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/edit-logo',[
		'uses' => 'AgentController@postEditPartnerLogo',
		'as' => 'dashboard.agent.edit_partner_logo.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/edit-limit',[
		'uses' => 'AgentController@postEditPartnerLimit',
		'as' => 'dashboard.agent.edit_partner_limit.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/edit-background',[
		'uses' => 'AgentController@postEditPartnerBackground',
		'as' => 'dashboard.agent.edit_partner_background.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/load-gallery',[
		'uses' => 'AgentController@postLoadGallery',
		'as' => 'dashboard.agent.load-gallery.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/edit-gallery-item',[
		'uses' => 'AgentController@postEditGalleryItem',
		'as' => 'dashboard.agent.edit-gallery-item.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/delete-gallery-item',[
		'uses' => 'AgentController@postDeleteGalleryItem',
		'as' => 'dashboard.agent.delete-gallery-item.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/delete-partner-address',[
		'uses' => 'AgentController@postDeletePartnerAddress',
		'as' => 'dashboard.agent.delete-partner-address.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/add-partner-address',[
		'uses' => 'AgentController@postAddPartnerAddress',
		'as' => 'dashboard.agent.add-partner-address.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/delete-partner-discount',[
		'uses' => 'AgentController@postDeletePartnerDiscount',
		'as' => 'dashboard.agent.delete-partner-discount.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/add-partner-discount',[
		'uses' => 'AgentController@postAddPartnerDiscount',
		'as' => 'dashboard.agent.add-partner-discount.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/delete-partner-bonus',[
		'uses' => 'AgentController@postDeletePartnerBonus',
		'as' => 'dashboard.agent.delete-partner-bonus.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/partner/add-partner-bonus',[
		'uses' => 'AgentController@postAddPartnerBonus',
		'as' => 'dashboard.agent.add-partner-bonus.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/tariff/change',[
		'uses' => 'AgentController@postChangeTariff',
		'as' => 'dashboard.agent.change-partner-tariff.post'
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/create-connection-invoice',[
		'uses' => 'AgentController@postCreateConnectionInvoice',
		'as' => 'dashboard.agent.create-connection-invoice.post'
		]);

	Route::post('/agent/dashboard/create-service-invoice',[
		'uses' => 'AgentController@postCreateServiceInvoice',
		'as' => 'dashboard.agent.create-service-invoice.post'
		]);

	Route::get('/agent/dashboard/billing',[
		'uses' => 'AgentController@showBillingPage',
		'as' => 'dashboard.agent.billing.get'	
		])->middleware('can:show-dashboard-agent,App\User');

	Route::get('/agent/dashboard/salary',[
		'uses' => 'AgentController@showSalaryPage',
		'as' => 'dashboard.agent.salary.get'	
		])->middleware('can:show-dashboard-agent,App\User');

	Route::get('/agent/dashboard/operations',[
		'uses' => 'AgentController@showOperationsPage',
		'as' => 'dashboard.agent.show-operations.get'	
		])->middleware('can:show-dashboard-agent,App\User');
    /**
     * AGENT REVIEWS
     */
	Route::get('/agent/dashboard/show-reviews',[
		'uses' => 'AgentController@getShowReviews',
		'as' => 'dashboard.agent.show-reviews.get'	
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/approve-review',[
		'uses' => 'AgentController@postApproveReview',
		'as' => 'dashboard.agent.approve-review.post'	
		])->middleware('can:show-dashboard-agent,App\User');

	Route::post('/agent/dashboard/disapprove-review',[
		'uses' => 'AgentController@postDisapproveReview',
		'as' => 'dashboard.agent.disapprove-review.post'	
		])->middleware('can:show-dashboard-agent,App\User');
	/**
	 * ПОКАЗЫВАТЬ ПАНЕЛЬ УПРАВЛЕНИЯ БУХГАЛТЕРА
	 */	
		Route::get('/dashboard/accountant',[
		'uses' => 'AccountantController@showDashboard',
		'as' => 'dashboard.accountant.show-dashboard.get'
		])->middleware('can:show-dashboard-accountant,App\User');
	/**
	 * ПОКАЗЫВАТЬ ПАНЕЛЬ УПРАВЛЕНИЯ ПАРТНЕРА
	 */	
	Route::get('/control-panel',[
		'uses' => 'PartnerController@showDashboard',
		'as' => 'dashboard.partner.show-dashboard.get'
		])->middleware('can:show-dashboard-partner,App\User');

	Route::get('/control-panel/create-operation',[
		'uses' => 'PartnerController@getCreateOperation',
		'as' => 'dashboard.partner.create-operation.get'	
		])->middleware('can:show-dashboard-partner,App\User');

	Route::get('/control-panel/show-operations',[
		'uses' => 'PartnerController@getShowOperations',
		'as' => 'dashboard.partner.show-operations.get'	
		])->middleware('can:show-dashboard-partner,App\User');

	Route::post('/control-panel/create-operation',[
		'uses' => 'PartnerController@postCreateOperation',
		'as' => 'dashboard.partner.create-operation.post'
	])->middleware('can:show-dashboard-partner,App\User');

	Route::get('/control-panel/show-operators',[
		'uses' => 'PartnerController@getShowOperatorsList',
		'as' => 'dashboard.partner.show-operators-list.get'	
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/create-operator',[
		'uses' => 'PartnerController@postCreateOperator',
		'as' => 'dashboard.partner.create-operator.post'
	])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/delete-operator',[
		'uses' => 'PartnerController@postDeleteOperator',
		'as' => 'dashboard.partner.delete-operator.post'
	])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/edit-operator',[
		'uses' => 'PartnerController@postEditOperator',
		'as' => 'dashboard.partner.edit-operator.post'
	])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/edit-operator-password',[
		'uses' => 'PartnerController@postEditOperatorPassword',
		'as' => 'dashboard.partner.edit-operator-password.post'
	])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/save-settings',[
		'uses' => 'PartnerController@postSaveSettings',
		'as' => 'dashboard.partner.save-settings.post'
	])->middleware('can:show-dashboard-partner-admin,App\User');


	Route::get('/control-panel/settings',[
		'uses' => 'PartnerController@getSettings',
		'as' => 'dashboard.partner.settings.get'	
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/delete-partner-bonus',[
		'uses' => 'PartnerController@postDeletePartnerBonus',
		'as' => 'dashboard.partner.delete-partner-bonus.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/add-partner-bonus',[
		'uses' => 'PartnerController@postAddPartnerBonus',
		'as' => 'dashboard.partner.add-partner-bonus.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/delete-partner-discount',[
		'uses' => 'PartnerController@postDeletePartnerDiscount',
		'as' => 'dashboard.partner.delete-partner-discount.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/add-partner-discount',[
		'uses' => 'PartnerController@postAddPartnerDiscount',
		'as' => 'dashboard.partner.add-partner-discount.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');
    /**
     * CONTROL PANEL REVIEWS
     */
	Route::get('/control-panel/show-reviews',[
		'uses' => 'PartnerController@getShowReviews',
		'as' => 'dashboard.partner.show-reviews.get'	
		])->middleware('can:show-dashboard-partner,App\User');

	Route::post('/control-panel/approve-review',[
		'uses' => 'PartnerController@postApproveReview',
		'as' => 'dashboard.partner.approve-review.post'	
		])->middleware('can:show-dashboard-partner,App\User');

	Route::post('/control-panel/disapprove-review',[
		'uses' => 'PartnerController@postDisapproveReview',
		'as' => 'dashboard.partner.disapprove-review.post'	
		])->middleware('can:show-dashboard-partner,App\User');

	/**
	 * BILLING
	 */
	Route::get('/control-panel/billing',[
		'uses' => 'PartnerController@getBillingPage',
		'as' => 'dashboard.partner.billing.get'	
		])->middleware('can:show-dashboard-partner,App\User');

	Route::post('/control-panel/add-invoice',[
		'uses' => 'PartnerController@postAddInvoice',
		'as' => 'dashboard.partner.add-invoice.post'
	])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::get('/pdf', 'PartnerController@createTestPDF');

	Route::post('/control-panel/partner/edit',[
		'uses' => 'PartnerController@postEditPartner',
		'as' => 'dashboard.partner.edit_partner.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/partner/edit-logo',[
		'uses' => 'PartnerController@postEditPartnerLogo',
		'as' => 'dashboard.partner.edit_partner_logo.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/partner/edit-background',[
		'uses' => 'PartnerController@postEditPartnerBackground',
		'as' => 'dashboard.partner.edit_partner_background.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/partner/load-gallery',[
		'uses' => 'PartnerController@postLoadGallery',
		'as' => 'dashboard.partner.load-gallery.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/partner/edit-gallery-item',[
		'uses' => 'PartnerController@postEditGalleryItem',
		'as' => 'dashboard.partner.edit-gallery-item.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/partner/delete-gallery-item',[
		'uses' => 'PartnerController@postDeleteGalleryItem',
		'as' => 'dashboard.partner.delete-gallery-item.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/partner/delete-partner-address',[
		'uses' => 'PartnerController@postDeletePartnerAddress',
		'as' => 'dashboard.partner.delete-partner-address.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::post('/control-panel/partner/add-partner-address',[
		'uses' => 'PartnerController@postAddPartnerAddress',
		'as' => 'dashboard.partner.add-partner-address.post'
		])->middleware('can:show-dashboard-partner-admin,App\User');

	Route::get('/control-panel/card/{card_number}/show',[
		'uses' => 'PartnerController@getCardNumberPage',
		'as' => 'dashboard.partner.show-card.get'	
		])->middleware('can:show-dashboard-partner,App\User');

	Route::get('/control-panel/operator/{operator_id}/show',[
		'uses' => 'PartnerController@getOperatorPage',
		'as' => 'dashboard.partner.show-operator.get'	
		])->middleware('can:show-dashboard-partner-admin,App\User');


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


	Route::post('/ajax/search-partner-list', [ 
		'uses' => 'AdminController@ajaxSearchPartnerList',
   		'as' => 'ajax.search-partner-list.post'
    ])->middleware('can:show-dashboard-admin,App\User');

    Route::post('/ajax/agent/search-partner-list', [ 
		'uses' => 'AgentController@ajaxSearchPartnerList',
   		'as' => 'ajax.agent.search-partner-list.post'
    ])->middleware('can:show-dashboard-agent,App\User');


    Route::post('/ajax/add-tag',[
    	'uses' => 'AdminController@ajaxAddTag',
    	'as' => 'ajax.add-tag.post'
    ]);
    Route::post('/ajax/delete-tag',[
    	'uses' => 'AdminController@ajaxDeleteTag',
    	'as' => 'ajax.delete-tag.post'
    ]);

});
Route::get('/logout', 'Auth\LoginController@logout');

/**
 * AJAX NON-AUTHORIZED
 */
Route::post('/ajax/check-contract-id',[
	'uses' => 'SiteController@ajaxCheckContractId',
	'as' => 'ajax.check-contract-id'
]);


Route::post('/ajax/search-in-categories',[
	'uses' => 'SiteController@ajaxSearchInCategories',
	'as' => 'ajax.search-in-categories'
]);
Route::get('/home', 'HomeController@index')->name('home');
