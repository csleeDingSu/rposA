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
use Illuminate\Http\Request; 
//re route
Route::group( [ 'middleware' => 'reroute' ], function () {
	Route::get( '/member/re-route')->name( 'do_re-route' );
} );



//redis example 
Route::any('/master-call', 'RedisGameController@master_out')->name('api.redis.master.call'); //deprecated 
	
Route::any('/master-call-nobet', 'RedisGameController@master_withoutbet')->name('api.redis.master.withoutbet');

Route::any('/userbetting', 'RedisGameController@userbetting')->name('api.redis.userbetting');

Route::get('new-open-draw/{drawid?}', function ($drawid) {
	Artisan::call('draw:initiate', ['drawid' => $drawid]);
	dd( 'draw open to all connected members' );
} );

Route::get('generateresult/{drawid}', function ($drawid) {
	Artisan::call('generate:br', ['drawid' => $drawid]);
	dd( 'result generated' );
} );


Route::get('generatevipresult/{drawid}', function ($drawid) {
	Artisan::call('generate:vip_result', ['drawid' => $drawid]);
	dd( 'result generated' );
} );


Route::get('open-draw/{drawid?}', function ($drawid) {
	//if (empty($drawid) $drawid = 0;
	Artisan::call('game:opendraw', ['drawid' => $drawid]);
	dd( 'draw open to all connected members' );
} );

Route::get('open-draw-pre/{drawid?}', function ($drawid) {
	//if (empty($drawid) $drawid = 0;
	Artisan::call('game:open_draw_pre', ['drawid' => $drawid]);
	dd( 'open_draw_pre to all connected members' );
} );

Route::get('open-draw-temp/{drawid?}', function ($drawid) {
	//if (empty($drawid) $drawid = 0;
	Artisan::call('game:open_draw_temp', ['drawid' => $drawid]);
	dd( 'open_draw_temp to all connected members' );
} );

Route::get('many', function () {
    return view('redis.many');
});

Route::get('r-auth', function () {
    return view('redis.auth');
});
Route::get('token', 'TokenController@token');
Route::get('admintoken', 'TokenController@admintoken');
//end



//language route

Route::get('locale/{locale}', function ($locale) {

	Session::put('locale', $locale);

	return redirect()->back();
} );

//Member routes without member guard
Route::group( [ 'middleware' => 'sso' ], function () {
	
	$this->get( '/home', 'Api\VoucherController@index' )->name( 'api.vlist' ); //cs20181003 - temp fix redirect to /home

	$this->get( '/ads', 'Api\ProductController@index' )->name( 'api.client.ad' );

	Route::any( '/intro', function () {
		return view( 'client/intro' );
	});

	Route::get( '/details/{id?}', 'VoucherController@get_voucher_detail' )->name( 'get.voucher.detail' );

	//old game screen
	Route::get( '/arcade_old', 'ClientController@member_access_game' )->name( 'client.arcade' );
	//switched to new game screen
	Route::get( '/arcade', 'ClientController@member_access_game_node' )->name( 'client.arcade_node' );

	Route::get( '/vip', 'ClientController@member_access_vip_node' )->name( 'client.vip' );

	Route::get( '/faq', function () {

		$faqs = DB::table( 'faq' )->select( 'id', 'title', 'content' )->orderBy( 'id', 'desc' )->get();

		return view( 'client/faq', compact( 'faqs' ) );
	} );

	Route::any( '/tips', 'ClientController@tips' )->name( 'client.tips' );
	
	$this->get( 'cs/{id?}', 'Api\VoucherController@show' )->name( 'api.vclist' );

	$this->get( '/', 'Api\VoucherController@index' )->name( 'api.vlist' );

	$this->get( '/search/{strSearch?}', 'Api\VoucherController@search' )->name( 'api.slist' );
	
	$this->get( '/newsearch/{strSearch?}', 'Api\VoucherController@newsearch' )->name( 'api.newsearch' );

	$this->get( '/firstwin', 'Api\VoucherController@put_first_win' )->name( 'api.firstwin' );

	Route::any( '/invitation_list', 'ClientController@invitation_list' )->name( 'client.invitation_list' );

	Route::any( '/round', 'ClientController@round' )->name( 'client.round' );

	Route::get( '/customer_service', function () {
		return view( 'client/customer_service' );
	} );
	
} );

//Member routes with member guard
Route::group( [ 'middleware' => [ 'auth:member', 'sso' ] ], function () {
	
	Route::get('/share', 'ClientController@share')->name('show.link.share');
	Route::get('/nshare', 'ClientController@sharetest')->name('show.link.sharetest');
		
	Route::get( '/allhistory', function () {
		return view( 'client/allhistory' );
	} );

	Route::get( '/summary', function () {
		return view( 'client/summary' );
	} );	
	
	Route::get( '/results', function () {
		return view( 'client/results' );
	} );

	Route::get( '/history', function () {
		return view( 'client/history' );
	} );

	Route::get( '/redeem', function () {
		return view( 'client/redeem');
	} );

	Route::get( '/redeem/{slug}', function ($slug = '') {
		return view( 'client/redeem', compact('slug'));
	} );

	Route::get( '/validate', function () {
		return view( 'client/validate' );
	} );

	Route::get( '/membership', function () {
		return view( 'client/membership');
	} );

	Route::get( '/purchase', function () {
		return view( 'client/purchase');
	} );

	Route::any( '/buy', 'BuyProductController@buy' );

	Route::post( '/confirm', 'BuyProductController@confirm' );

	Route::get( '/vipmember', function () {
		return view( 'client/vipmember');
	} );

	Route::get( '/purchasepoint', function () {
		return view( 'client/purchasepoint');
	} );

	$this->post( '/member_update_wechatname', 'ClientController@member_update_wechatname' );

	Route::get( '/verify', function () {
		return view( 'client/verify' );
	} );
	
	Route::get( '/referral-list', 'ClientController@member_referral_list' )->name( 'client.referral.list' );
	Route::get( '/profile', 'ClientController@member_profile' )->name( 'client.profile' );
	
	
	
	Route::get( '/client/profile', 'ClientController@member_profile' )->name( 'client.profile.page' );

	Route::any( '/membership/buy/vip', 'PaymentController@membership_buy_vip' )->name( 'client.membership.buy.vip' );

	Route::any( '/payment', 'PaymentController@payment' )->name( 'client.payment' );

} );

//Member routes end


Route::get( '/member', 'ClientController@index' )->name( 'client.main' );



//Auth Routes
//Auth::routes();
Route::prefix( 'admin' )->group( function () {
	Route::get( 'login', 'Auth\AdminLoginController@showLoginForm' )->name( 'adminlogin' );
	Route::post( 'login', 'Auth\AdminLoginController@login' )->name( 'adminlogin.submit' );
	Route::get( 'dashboard', 'ReportController@dashboard' )->name( 'admin.dashboard' );
} );

Route::group( [ 'prefix' => 'member', 'namespace' => 'Auth', 'middleware' => [ 'guest' ] ], function () {
	Route::get( 'login', 'MemberLoginController@showLoginForm' )->name( 'memberlogin' );
	Route::get( 'login/{slug}', 'MemberLoginController@showLoginForm' )->name( 'memberregister' );
	Route::post( 'login', 'MemberLoginController@login' )->name( 'memberlogin.submit' );

	// Password Reset Routes...
	$this->get( 'password-reset', 'ForgotPasswordController@MembershowLinkRequestForm' )->name( 'member.reset.password' );
	$this->post( 'password-reset', 'ForgotPasswordController@sendResetLinkEmail' )->name( 'submit.reset.password' );
	$this->post( 'password/email', 'ForgotPasswordController@sendResetLinkEmail' );
	$this->get( 'reset/{token}', 'ResetPasswordController@MembershowResetForm' )->name( 'member.reset.token' );
	$this->post( 'resetpassword', 'ResetPasswordController@resetpassword' )->name( 'member.update.password' );
	
	
} );


Route::group( [ 'namespace' => 'Auth', 'middleware' => [ 'guest' ] ], function () {
	//register
	$this->get( 'register/{token?}', 'MemberRegisterController@showRegisterForm' )->name( 'member.register' );
	$this->post( '/doregister', 'MemberRegisterController@doregister' )->name( 'submit.member.register' );
	$this->get( 'vregister/{token?}', function () {
		// return File::get(public_path() . '/vwechat/index.html');
		return view( 'client/angpao' );
	} );
	$this->get( 'vvregister/{token?}', function () {
		return view( 'client/vwechat' );
		// return File::get(public_path() . '/vwechat/index.html');
	} );

} );


$this->get( 'login', 'Auth\MemberLoginController@showLoginForm' )->name( 'login' );
//Auth Routes END



//Admin
Route::group( [ 'middleware' => 'auth:admin' ], function () {
		
	//Game rotes
	Route::get('/game', 'GameController@get_game_list')->name('gamelist');
	Route::get('/game/list', 'GameController@get_game_list');
	Route::get('/game/index', 'GameController@dashboard');
	Route::get('/game/category', 'GameController@get_gamecategory_list')->name('gamecategorylist');
	Route::get('/game/delete/{id}', 'GameController@delete_game');
	
	Route::get('/game/add', 'GameController@new_game');
	Route::get('/game/edit/{id}', 'GameController@edit_game')->name('editgame');
	Route::get('/game/addlevel/{id}', 'GameController@add_level');
	Route::get('/game/level/edit/{id}', 'GameController@edit_level');
	Route::get('/game/category/add/', 'GameController@add_gamecategory');
	Route::get('/game/category/edit/{id}', 'GameController@edit_gamecategory');	
	
	Route::post('/game/add', 'GameController@save_game');
	Route::post('/game/edit/{id}', 'GameController@update_gamedetails');
	Route::post('/game/addlevel/{id}', 'GameController@save_level');
	Route::post('/game/level/edit/{id}', 'GameController@update_level');
	Route::post('/game/category/add/', 'GameController@save_gamecategory');
	Route::post('/game/category/edit/{id}', 'GameController@update_gamecategory');


	Route::delete('/game/delete/{id}', 'GameController@delete_game');
	Route::delete('/game/level/delete/{id}', 'GameController@delete_level');
	Route::delete('/game/category/delete/{id}', 'GameController@delete_gamecategory');

	Route::get('/setting', 'GameController@get_setting_list');
	Route::get('/setting/add', 'GameController@add_setting');
	Route::get('/setting/edit/{id}', 'GameController@edit_setting');
	Route::post('/setting/delete/{id}', 'GameController@edit_setting');	
	
	//Member route
	Route::get( '/member/index', 'MemberController@dashboard' );
	Route::get( '/member/dashboard', 'MemberController@dashboard' )->name( 'memberdashboard' );
	Route::get( '/member/list', 'MemberController@member_list' )->name( 'memberlist' );
	Route::get( '/member/add', 'MemberController@add_member' );
	Route::post( '/member/add', 'MemberController@save_member' );
	Route::get( '/member/edit/{id}', 'MemberController@edit_member' );
	Route::post( '/member/edit/{id}', 'MemberController@update_member' );
	Route::delete( '/member/delete/{id}', 'MemberController@delete_member' );
	Route::get( '/member/pending-verification', 'MemberController@list_pending_wechat_account' );
	Route::post( '/member/update-verification', 'MemberController@verify_wechat_account' )->name( 'ajaxapprovewechat' );
	Route::post( '/member/reject-verification', 'MemberController@reject_wechat_verification' )->name( 'post.wechat.reject' );
	Route::post( '/member/change-status', 'MemberController@change_status' )->name( 'ajaxchange.member.status' );
	Route::post( '/member/change-password', 'MemberController@change_password' )->name( 'ajaxchange.member.resetpass' );
	Route::get( '/member/get-childs', 'MemberController@child_list' )->name( 'ajax.child.members' );
	
	

	//Voucher Routes
	Route::get( '/voucher/', 'VoucherController@listvoucher' );
	//Route::get( '/voucher/list', 'VoucherController@get_voucher_list' );
	//Route::get( '/voucher/list', 'VoucherController@listvoucher' );


	Route::get( '/voucher/unreleased', 'VoucherController@get_unreleasedvoucher_list' )->name( 'unreleasedvoucherlist' );
	//Route::get( '/voucher/category', 'VoucherController@get_category' );
	//Route::get( '/voucher/category/add', 'VoucherController@add_category' );
	//Route::post( '/voucher/category/add', 'VoucherController@save_category' );
	Route::get( '/voucher/category/edit/{id}', 'VoucherController@edit_category' );
	Route::post( '/voucher/category/edit/{id}', 'VoucherController@edit_category' );
	Route::post( '/voucher/category/delete/{id}', 'VoucherController@delete_category' );
	Route::get( '/voucher/edit/{id}', 'VoucherController@edit_voucher' );
	Route::post( '/voucher/edit/{id}', 'VoucherController@update_voucher' );
	Route::delete( '/voucher/delete/{id}', 'VoucherController@destroy' );
	Route::delete( '/voucher/ur-delete/{id}', 'VoucherController@destroy_unr_voucher' );
	Route::delete( '/voucher/bulkupdate', 'VoucherController@bulkdata_update' );
	Route::delete( '/voucher/bulk-unreleased-update', 'VoucherController@bulkdata_unrv_update' )->name( 'unrv_update' );
	Route::get( '/voucher/edit/{id}', 'VoucherController@edit_voucher' );
	// Route::get( '/voucher/addlevel/{id}', 'VoucherController@add_level' );

	// setting
	Route::get( '/voucher/edit/{id}', 'VoucherController@edit_voucher' );
	Route::get( '/voucher/edit/{id}', 'VoucherController@edit_voucher' );

	//faq
	Route::get( '/voucher/list', 'VoucherController@listvoucher' )->name( 'voucher.list' );
	Route::get( '/voucher/category/add', 'AdminController@getvoucher' )->name( 'voucher.get' );
	Route::post( '/voucher/category/add', 'AdminController@savevoucher' )->name( 'voucher.create' );
	Route::post( '/voucher/category/edit', 'AdminController@editvoucher' )->name( 'voucher.edit' );
	Route::delete( '/voucher/category/delete/{id}', 'AdminController@delete_voucher' )->name( 'voucher.remove' );
	

	




	//import voucher
	Route::get( '/voucher/import', 'ImportController@getImport' )->name( 'import' );
	//Route::post( '/voucher/import', 'ImportController@parseImport' )->name( 'importparse' );
	Route::post( '/voucher/importprocess', 'ImportController@ProcessparseImport' )->name( 'importpost' );

	Route::post( '/voucher/publishvoucher/{id}', 'VoucherController@publishvoucher' );
	//Route::post( '/voucher/unreleased', 'VoucherController@post_unreleasedvoucher_list' );
	Route::post( '/voucher/publishfile/{id}', 'VoucherController@publishfile' );
	Route::get( '/voucher/un-duplicate-finder', 'VoucherController@check_unrvoucher_duplicate' )->name( 'ajaxfindunrvoucherduplicate' );
	Route::get( '/voucher/vo-duplicate-finder', 'VoucherController@check_voucher_duplicate' )->name( 'ajaxfindvoucherduplicate' );
	Route::delete( '/voucher/remove-unr-duplicate/', 'VoucherController@remove_unrvoucher_duplicate' );
	Route::delete( '/voucher/remove-vor-duplicate/', 'VoucherController@remove_voucher_duplicate' );
	Route::get( '/voucher/show/{id}', 'VoucherController@show_voucher' )->name( 'showvoucher' );
	Route::get( '/voucher/show-unrv/{id}', 'VoucherController@show_unreleased_voucher' )->name( 'showunreleasedvoucher' );
	Route::post( '/voucher/ajaxupdate-unrv-voucher', 'VoucherController@ajax_unrv_update_voucher' )->name( 'ajax_unrv_updatevoucher' );
	Route::post( '/voucher/ajaxupdatevoucher', 'VoucherController@ajax_update_voucher' )->name( 'ajaxupdatevoucher' );
	Route::post( '/voucher/ajaxupdate-unr-vouchertag', 'VoucherController@ajax_update_unr_tag' )->name( 'ajaxupdateunrvouchertag' );
	Route::post( '/voucher/ajaxupdatevouchertag', 'VoucherController@ajax_update_tag' )->name( 'ajaxupdatevouchertag' );
	Route::get( '/voucher/category/add', 'AdminController@getvoucher' )->name( 'voucher.get' );

	//setting
	Route::get( '/voucher/setting', 'VoucherController@listvouchersetting' )->name( 'voucher.setting' );
	Route::get( '/voucher/setting/category/edit/{id}', 'VoucherController@edit_category' )->name( 'voucher.edit_category' );
	Route::post( '/voucher/setting/category/add_category', 'VoucherController@add_cate' )->name( 'voucher.add_cate' );
	Route::post( '/voucher/setting/category/add_sub_category', 'VoucherController@add_subcate' )->name( 'voucher.add_subcate' );
	Route::delete( '/voucher/setting/category/delete/{id}', 'VoucherController@delete_category' )->name( 'voucher.remove_category' );
	Route::delete( '/voucher/setting/category/delete_sub_category/{id}', 'VoucherController@delete_subcategory' )->name( 'voucher.remove_subcategory' );
	//Route::post('/voucher/favorite', 'VoucherController@add_subcate')->name( 'voucher.add_subcate' );
	Route::post( '/voucher/setting/category/edit/{id}', 'VoucherController@update_category' )->name( 'voucher.update_category' );
	
	
	//product
	Route::get( '/product/', 'ProductController@list_product' )->name( 'product.list.all' );
	Route::get( '/product/list', 'ProductController@list_product' )->name( 'product.list' );
	Route::get( '/product/ajaxlist', 'ProductController@ajax_list_product' )->name( 'product.ajax.list' );
	Route::get( '/product/add', 'ProductController@add_product' )->name( 'product.add' );
	Route::get( '/product/edit/{id?}', 'ProductController@edit_product' )->name( 'product.edit' );
	Route::post( '/product/add', 'ProductController@save_product' )->name( 'product.save' );
	Route::post( '/product/edit/{id?}', 'ProductController@update_product' )->name( 'product.update' );

	//softpins
	Route::get( '/product/softpins', 'ProductController@list_pins' )->name( 'pin.list' );
	Route::post( '/product/addpins', 'ProductController@save_pins' )->name( 'pin.create' );
	Route::get( '/product/import', 'ImportController@getPinImport' )->name( 'import.softpin' );
	Route::post( '/product/import-pins', 'ImportController@PostpinImport' )->name( 'pin.import' );
	Route::post( '/product/importprocess', 'ImportController@PinProcessImport' )->name( 'pin.process.import' );
	Route::delete( '/product/remove-softpins', 'ProductController@remove_pin' )->name( 'pin.remove' );

	//redeem
	Route::get( '/product/pending-redeem', 'ProductController@get_pending_redeemlist' )->name( 'redeem.pending.list' );
	Route::delete( '/product/confirm-redeem', 'ProductController@confirm_redeem' )->name( 'pin.redeem.confirm' );
	Route::delete( '/product/reject-redeem', 'ProductController@reject_redeem' )->name( 'pin.redeem.reject' );
	Route::get( '/product/redeem-history', 'ProductController@get_redeemhistory' )->name( 'redeem.history.list' );

	//Ads 
	Route::get( '/product/product-new', 'ProductController@show_product' )->name( 'ad.product.show' );
	Route::get( '/product/ad-edit/{id?}', 'ProductController@edit_ad_product' )->name( 'ad.product.edit' );
	Route::post( '/product/ad-edit/{id?}', 'ProductController@update_ad_product' )->name( 'ad.postproduct.edit' );
	Route::get( '/product/ad-add', 'ProductController@add_ad_product' )->name( 'ad.product.add' );
	Route::post( '/product/ad-add', 'ProductController@save_ad_product' )->name( 'ad.product.save' );
	Route::delete( '/product/ad-delete', 'ProductController@delete_ad_product' )->name( 'ad.product.delete' );
	Route::delete( '/product/ad-delete-all', 'ProductController@clean_ad_product' )->name( 'ad.product.clean' ); //truncate
	
	Route::delete( '/product/remove-image', 'ProductController@delete_ad_image' )->name( 'ad.remove.image' );

	// ad import 
	Route::get( '/product/ad-import', 'ImportController@getAdImport' )->name( 'ad.get.import' );
	Route::post( '/product/ad-import-pins', 'ImportController@PostAdImport' )->name( 'ad.post.import' );
	Route::post( '/product/ad-importprocess', 'ImportController@AdProcessImport' )->name( 'ad.process.import' );

	//ledger
	//Route::get( '/ledger/get-life', 'LedgerController@get_life' )->name( 'get.ledger.life' ); //deprecated
	//Route::post( '/ledger/adjust-life', 'LedgerController@adjust_life' )->name( 'post.ledger.adjustlife' ); //deprecated
	
	Route::get( '/ledger/get-ledger', 'LedgerController@get_wallet' )->name( 'get.ledger.detail' );
	Route::post( '/ledger/adjust-wallet', 'LedgerController@adjust_life_point' )->name( 'post.ledger.adjustwallet' );
	
	

	//User 
	Route::get( '/user', 'AdminController@userlist' );
	Route::get( '/user/list', 'AdminController@userlist' )->name( 'userlist' );
	Route::get( '/user/add', 'AdminController@add_user' );
	Route::post( '/user/add', 'AdminController@create' );
	Route::get( '/user/edit/{id}', 'AdminController@edit_user' );
	Route::post( '/user/edit/{id}', 'AdminController@update' );
	Route::delete( '/user/delete/{id}', 'AdminController@destroy' );
	Route::post( '/user/change-status', 'AdminController@change_status' )->name( 'post.user.status' );
	Route::post( '/user/change-password', 'AdminController@change_password' )->name( 'post.user.resetpass' );
	Route::get( '/user/profile', 'AdminController@profile' );
	Route::post( '/user/profile', 'AdminController@update_profile' );
	Route::post( '/user/update-password', 'AdminController@update_password' );

	//faq
	Route::get( '/admin/faq', 'AdminController@listfaq' )->name( 'faq.list' );
	Route::get( '/admin/get-faq', 'AdminController@getfaq' )->name( 'faq.get' );
	Route::post( '/admin/add-faq', 'AdminController@savefaq' )->name( 'faq.create' );
	Route::post( '/admin/edit-faq', 'AdminController@editfaq' )->name( 'faq.edit' );
	Route::delete( '/admin/delete-faq', 'AdminController@delete_faq' )->name( 'faq.remove' );
	
	//tips
	Route::get('/admin/tips', 'AdminController@listtips')->name('tips.list');
	Route::get('/admin/get-tips', 'AdminController@gettips')->name('tips.get');
	Route::post('/admin/add-tips', 'AdminController@savetips')->name('tips.create');
	Route::post('/admin/edit-tips', 'AdminController@edittips')->name('tips.edit');
	Route::delete('/admin/delete-tips', 'AdminController@delete_tips')->name('tips.remove');
	
	//Admin Routes	
	Route::get( '/admin/dashboard', 'ReportController@dashboard' )->name( 'admindashboard' );
	Route::get( '/admin', 'ReportController@dashboard' );
	
	//settings
	Route::get( '/admin/settings', 'AdminController@setting' )->name( 'site.settings' );
	Route::post( '/admin/settings', 'AdminController@update_setting' )->name( 'site.submit.settings' );
	
	//banner
	Route::get('/admin/banner', 'AdminController@listbanner')->name('banner.list');
	Route::get('/admin/get-banner', 'AdminController@getbanner')->name('banner.get');
	Route::post('/admin/add-banner', 'AdminController@savebanner')->name('banner.create');
	Route::post('/admin/edit-banner', 'AdminController@editbanner')->name('banner.edit');
	Route::delete('/admin/delete-banner', 'AdminController@delete_banner')->name('banner.remove');		
	Route::delete( '/banner/remove-image', 'AdminController@delete_banner_image' )->name( 'banner.remove.image' );
	
	//Package	
	Route::get('/package/', 'ProductController@list_package')->name('package.list.all');
	Route::get('/package/list', 'ProductController@list_package')->name('package.list');	
	Route::post('/package/add', 'ProductController@save_package')->name('package.save');
	Route::get('/package/get-package', 'ProductController@getpackage')->name('package.get');	
	Route::delete('/package/delete', 'ProductController@delete_package')->name('package.remove');
	
	Route::get('/package/get-quantity', 'ProductController@get_quantity')->name('get.package.quantity');	
	Route::post('/package/adjust-quantity', 'ProductController@adjust_quantity')->name('post.package.adjustquantity');
	
	//Vip redeem list	
	Route::get('/package/redeem-list', 'ProductController@list_redeem_package')->name('package.redeem.list');
	Route::get('/package/redeem-history', 'ProductController@list_redeem_history')->name('package.redeem.history');
	
	
	Route::post('/package/confirm-vip', 'ProductController@confirm_vip')->name('package.redeem.confirm');	
	Route::post('/package/reject-vip', 'ProductController@reject_vip')->name('package.redeem.reject');
	
	//reports
	Route::get('/report/redeem_product', 'ReportController@redeem_product')->name('report.redeem.product');
	Route::get('/report/point_report', 'ReportController@ledger_report')->name('report.point.report');
	Route::get('/report/redeem_life', 'ReportController@redeem_life')->name('report.redeem.life');
	
	
	Route::get('/package/get-gameinfo', 'ReportController@gameinfo')->name('get.gameinfo');
	
	
	//redeem condition
	Route::get('/admin/redeem-condition', 'AdminController@listredeem_condition')->name('list.redeemcondition');
	Route::get('/admin/get-redeem-condition', 'AdminController@get_redeem_condition')->name('get.redeemcondition');
	Route::post('/admin/add-redeem-condition', 'AdminController@saveredeem_condition')->name('create.redeemcondition');
	Route::post('/admin/edit-redeem-condition', 'AdminController@update_redeem_condition')->name('edit.redeemcondition');
	Route::delete('/admin/delete-redeem-condition', 'AdminController@delete_redeem_condition')->name('remove.redeemcondition');
	
	
	//cron manager	
	Route::get('/admin/cron-list', 'AdminController@cronlist')->name('list.cronmanager');
	Route::get('/admin/get-cron', 'AdminController@get_cron')->name('get.cron');
	Route::post('/admin/edit-cron', 'AdminController@edit_cron')->name('update.cron');
	
	//Share product
	Route::get('/share-product', 'VoucherController@shareproductlist')->name('shareproductlist');	
	Route::delete('/share-product/update', 'VoucherController@update_shareproduct')->name('shareproduct_update');	
	Route::delete( '/share-product/delete/{id}', 'VoucherController@delete_shareproduct' )->name( 'delete_shareproduct' );
	
	
	
	//Basic Package	 basicpackage
	Route::get('/basicpackage/', 'BasicPackageController@list_basicpackage')->name('basicpackage.list.all');
	Route::get('/basicpackage/list', 'BasicPackageController@list_basicpackage')->name('basicpackage.list');	
	Route::post('/basicpackage/add', 'BasicPackageController@save_basicpackage')->name('basicpackage.save');
	Route::get('/basicpackage/get-package', 'BasicPackageController@getbasicpackage')->name('basicpackage.get');	
	Route::delete('/basicpackage/delete', 'BasicPackageController@delete_basicpackage')->name('basicpackage.remove');
	
	Route::get('/basicpackage/get-quantity', 'ProductController@get_basicpackage_quantity')->name('get.basicpackage.quantity');	
	Route::post('/basicpackage/adjust-quantity', 'ProductController@adjust_basicpackage_quantity')->name('post.basicpackage.adjustquantity');
	
	Route::get('/basicpackage/redeem-list', 'BasicPackageController@list_redeem_basicpackage')->name('basicpackage.redeem.list');
	Route::get('/basicpackage/redeem-history', 'BasicPackageController@list_basicredeem_history')->name('basicpackage.redeem.history');	
	
	Route::post('/basicpackage/confirm-vip', 'BasicPackageController@confirm_basicpackage')->name('basicpackage.redeem.confirm');	
	Route::post('/basicpackage/reject-vip', 'BasicPackageController@reject_basicpackage')->name('basicpackage.redeem.reject');
	
	Route::get('/report/draw-details', 'ReportController@list_gameplayed')->name('draw-details');
	Route::get('/report/redeem-count', 'ReportController@list_redeemed')->name('redeem-count');
	
	Route::get( '/report/get-redeem-childs', 'ReportController@get_redeem_members' )->name( 'ajax_redeem_members' );
	
	Route::get( '/report/get-played-childs', 'ReportController@get_played_members' )->name( 'ajax_played_members' );
	
	Route::get( '/report/played-member', 'ReportController@played_details' )->name( 'played_details' );
	
	Route::get( '/report/ledger', 'ReportController@ledger_details' )->name( 'ledger_details' );
	
	
	Route::get('/get-wallet/{id?}', function ( $id = 0) {
		$data = \DB::table('view_members')->where('id',$id)->get();
		return view('reports.ledger.members', ['result' => $data])->render();
	})->name( 'ajax_wallet_members' );
	
	Route::get('/view-ledger-trx/{id?}', function ( Request $request) {
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
		$order_by = 'DESC';
		//\DB::enableQueryLog();
		$result   =  \DB::table('view_ledger_details')->where('created_at', 'like', $request->cdate . '%' )->where('member_id',$request->id);
		//->where('created_at',$request->cdate)
				
		$result   =  $result->orderby('created_at',$order_by)->get();
		return view('reports.ledger.ledger', ['result' => $result])->render(); 
	})->name( 'ajax_ledger_trx' );
	
	
	Route::get( '/basicpackage/backorder', 'BasicPackageController@backorder' )->name( 'basicpackage_backorder' );	
	
	Route::post('/basicpackage/confirm-backorder', 'BasicPackageController@confirm_backorder')->name('store_basicpackage_backorder');
	
	
	
	//Buy product 
	Route::get('/buyproduct/', 'BuyProductController@list_product')->name('buyproduct_listall');
	Route::get('/buyproduct/list', 'BuyProductController@list_product')->name('buyproduct_list');	
	Route::post('/buyproduct/save', 'BuyProductController@save_product')->name('buyproduct_save');
	Route::get('/buyproduct/get-package', 'BuyProductController@getBuyProduct')->name('buyproduct_get');	
	Route::delete('/buyproduct/delete', 'BuyProductController@delete_product')->name('buyproduct_remove');	
	Route::get('/buyproduct/get-quantity', 'BuyProductController@get_product_quantity')->name('get_buyproduct_quantity');	
	Route::post('/buyproduct/adjust-quantity', 'BuyProductController@adjust_product_quantity')->name('post_buyproduct_adjustquantity');	
	//redeem list	
	Route::get('/buyproduct/redeem-list', 'BuyProductController@list_redeem_product')->name('buyproduct_redeem_list');
	Route::get('/buyproduct/redeem-history', 'BuyProductController@list_product_history')->name('buyproduct_redeem_history');
	
	Route::post('/buyproduct/redeem-confirm', 'BuyProductController@confirm_product')->name('buyproduct_redeem_confirm');	
	Route::post('/buyproduct/redeem-reject', 'BuyProductController@reject_product')->name('buyproduct_redeem_reject');


	Route::get('/buyproduct/render-card', 'BuyProductController@render_card_detail')->name('render_card_detail');
	

} );
//END

Route::get('/mytest', 'AdminController@mytest')->name('mytest');

Route::get('nlogin/{token?}', 'Auth\MemberRegisterController@showAuthForm')->name('render.member.register');
Route::any('nlogin', 'Auth\MemberLoginController@dologin')->name('submit.member.login');
Route::post('nreg', 'Auth\MemberRegisterController@doreg')->name('submit.member.newregister');

Route::post('api-register', 'Auth\MemberRegisterController@api_register')->name('api.member.newregister');

Route::get( '/clearcache', function () {
	$exitCode = Artisan::call( 'cache:clear' );
	return 'cache:cleared';
} );


Route::get( 'logout', 'Auth\LoginController@logout' );

Route::post( 'logout', 'Auth\LoginController@logout' )->name( 'logout' );

Route::get( '/share_product/{id?}', 'ShareProductController@index' )->name( 'share.product' );

Route::get( '/new_share_product/{id?}', 'ShareProductController@new_share_product' )->name( 'new.share.product' );
Route::get( '/new_share_product2/{id?}', 'ShareProductController@new_share_product2' )->name( 'new.share.product2' );

Route::any( '/share_product_api', function () {
		return view( 'client/share_product_api2' );
	});

Route::any('asyncmysqlevent/{api}/{drawid}', function ($api, $drawid) {
	$url = env('APP_URL', 'wabao666.com') . "/$api/$drawid";
    // var_dump($url);
    $client = new \GuzzleHttp\Client();
    // Send an asynchronous request.
    $request = new \GuzzleHttp\Psr7\Request('GET', $url);
    $promise = $client->sendAsync($request)->then(function ($response) {
    //echo 'I completed! ' . $response->getBody();
     echo 'Completed!';
	});
    $promise->wait();
});

Route::any('MP_verify', function () {
	// var_dump(public_path());
		// die('dasdsa');
		// return '/mp/MP_verify_ZDL0jybF5U5fGlLy.txt';
	echo \File::get(public_path() . '/mp/MP_verify_ZDL0jybF5U5fGlLy.txt');
});

Route::any( '/weixin/{type?}', 'weixinController@index' )->name( 'weixin.index' );
Route::any( '/weixin/getUserInfo', 'weixinController@getUserInfo' )->name( 'weixin.getUserInfo' );
