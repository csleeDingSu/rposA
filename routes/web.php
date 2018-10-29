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
/*
Route::get('/', function()
{
    return view('client/home');
});
*/

// Route::get('/home', function () {
//     return view('client/home');
// });
$this->get('/home', 'Api\VoucherController@index')->name('api.vlist'); //cs20181003 - temp fix redirect to /home

$this->get('/ads', 'Api\ProductController@index')->name('api.client.ad');
//$this->get('/ads', 'Api\ProductController@index')->name('api.client.adold');

//Member routes
Route::group(['middleware' => 'sso'], function()
{

	Route::get('/details/{id?}', 'VoucherController@get_voucher_detail')->name('get.voucher.detail');

	Route::get('/arcade', 'ClientController@member_access_game')->name('client.arcade');

	$this->post('/member_update_wechatname', 'ClientController@member_update_wechatname');

	Route::get('/wheel', function () {
		return view('client/wheel');
	});

	Route::get('/results', function () {
		return view('client/results');
	});

	Route::get('/history', function () {
		return view('client/history');
	});

	// Route::get('/profile', function () {
	//     return view('client/member');
	// });
	Route::get('/profile', 'ClientController@member_profile')->name('client.profile');

	Route::get('/redeem', function () {
		return view('client/redeem');
	});
	/*
	Route::get('/register', function () {
		return view('client/register');
	});

	Route::get('/login', function () {
		return view('client/login');
	});
	*/
	Route::get('/validate', function () {
		return view('client/validate');
	});

	Route::get('/share', function () {
		return view('client/share');
	});

	Route::get('/verify', function () {
		return view('client/verify');
	});
	
	
	
	Route::get('/referral-list', 'ClientController@member_referral_list')->name('client.referral.list');


});
//Member routes end


$this->get('cs/{id?}', 'Api\VoucherController@show')->name('api.vclist');

$this->get('/', 'Api\VoucherController@index')->name('api.vlist');



$this->get('register/{token?}', 'Auth\MemberRegisterController@showRegisterForm')->name('member.register');
$this->post('/doregister', 'Auth\MemberRegisterController@doregister')->name('submit.member.register');

//Auth Routes

//Auth::routes();
 Route::prefix('admin')->group(function() {
    Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('adminlogin');
    Route::post('login', 'Auth\AdminLoginController@login')->name('adminlogin.submit');
    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
 });

  Route::group(['prefix' => 'member','namespace' => 'Auth', 'middleware' => ['guest']],function(){
// //Route::prefix('member')->group(function() {
     Route::get('login', 'MemberLoginController@showLoginForm')->name('login');
     Route::post('login', 'MemberLoginController@login')->name('memberlogin.submit');
    	
	// Password Reset Routes...
    $this->get('password-reset', 'ForgotPasswordController@MembershowLinkRequestForm')->name('member.reset.password');
	$this->post('password-reset', 'ForgotPasswordController@sendResetLinkEmail')->name('submit.reset.password');
    $this->post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    $this->get('reset/{token}', 'ResetPasswordController@MembershowResetForm')->name('member.reset.token');
    $this->post('resetpassword', 'ResetPasswordController@resetpassword')->name('member.update.password');
  });

$this->get('login', 'Auth\MemberLoginController@showLoginForm')->name('login');
//Auth Routes END





//Member routes
Route::group(['prefix' => 'member','middleware' => 'auth:member'],function(){
	
	Route::get('/', 'MemberController@index');
	
});
//Member routes end



//Admin
Route::group(['middleware' => 'auth:admin'], function()
{
    	
	//Game rotes
	Route::get('/game', 'GameController@get_game_list');
	Route::get('/game/index', 'GameController@dashboard');
	Route::get('/game/list', 'GameController@get_game_list');
	
	Route::get('/game/new', 'GameController@new_game');
	Route::post('/game/new', 'GameController@save_game');
	
	
	Route::get('/game/edit/{id}', 'GameController@edit_game');
	Route::post('/game/edit/{id}', 'GameController@update_game');
	
	Route::get('/game/addlevel/{id}', 'GameController@add_level');


	//redeem route
	//Route::get('/redeem', 'RedeemController@getRedeemList')->name('redeemlist');
	//Route::post('/redeem/import-pins', 'ImportController@PostpinImport')->name('pin.import');
	

		

	
	//Member route
	Route::get('/member/index', 'MemberController@dashboard');
	Route::get('/member/dashboard', 'MemberController@dashboard')->name('memberdashboard');
	Route::get('/member', 'MemberController@member_list');
	Route::get('/member/list', 'MemberController@member_list')->name('memberlist');
	
	Route::get('/member/add', 'MemberController@add_member');
	Route::post('/member/add', 'MemberController@save_member');
	
	Route::get('/member/edit/{id}', 'MemberController@edit_member');
	Route::post('/member/edit/{id}', 'MemberController@update_member');
	
	
	//Route::post('/member/delete/{id}', 'MemberController@delete_member');
	//Route::get('/member/delete/{id}', 'MemberController@delete_member');
	Route::delete('/member/delete/{id}', 'MemberController@delete_member');
	//Route::get('/member/edit', 'MemberController@change_password');
	//Route::get('/member/edit', 'MemberController@verify_wechat');	
	//Route::post('/member/edit', 'MemberController@delete_member');
	
	Route::get('/member/pending-verification', 'MemberController@list_pending_wechat_account');
	
	Route::post('/member/update-verification', 'MemberController@verify_wechat_account')->name('ajaxapprovewechat');
	
	Route::post('/member/reject-verification', 'MemberController@reject_wechat_verification')->name('post.wechat.reject');
	
	
	//Admin Routes
	///Route::any('/', ['uses' => 'AdminController@dashboard'])->name('admindashboard');
	///Route::get('/', 'AdminController@dashboard');
	//Route::get('/', function() { return Redirect::to("AdminController/dashboard"); });
	Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admindashboard');
	
	
	//Voucher Routes
	Route::get('/voucher/', 'VoucherController@get_voucher_list');
	Route::get('/voucher/list', 'VoucherController@get_voucher_list');
	Route::get('/voucher/unreleased', 'VoucherController@get_unreleasedvoucher_list');	
	
	Route::get('/voucher/category', 'VoucherController@get_category');
	Route::get('/voucher/category/add', 'VoucherController@add_category');
	Route::post('/voucher/category/add', 'VoucherController@save_category');	
	Route::get('/voucher/category/edit/{id}', 'VoucherController@edit_category');
	Route::post('/voucher/category/edit/{id}', 'VoucherController@edit_category');	
	Route::post('/voucher/category/delete/{id}', 'VoucherController@delete_category');	
	
	Route::get('/voucher/edit/{id}', 'VoucherController@edit_voucher');
	Route::post('/voucher/edit/{id}', 'VoucherController@update_voucher');
	
	Route::delete('/voucher/delete/{id}', 'VoucherController@destroy');
	Route::delete('/voucher/ur-delete/{id}', 'VoucherController@destroy_unr_voucher');
	
	Route::delete('/voucher/bulkupdate', 'VoucherController@bulkdata_update');
	Route::delete('/voucher/bulk-unreleased-update', 'VoucherController@bulkdata_unrv_update')->name('unrv_update');
	
	Route::get('/voucher/edit/{id}', 'VoucherController@edit_voucher');
	Route::get('/voucher/addlevel/{id}', 'VoucherController@add_level');
	
	Route::get('/voucher/import', 'ImportController@getImport')->name('import');
	
	Route::post('/voucher/import', 'ImportController@parseImport')->name('importparse');
	Route::post('/voucher/importprocess', 'ImportController@ProcessparseImport')->name('importpost');
	
	
	Route::get('/voucher/testimport', 'ImportController@testparseImport')->name('testimport');
	Route::post('/voucher/testimport', 'ImportController@testProcessparseImport')->name('testimportpost');
	
	Route::get('/voucher/download', 'ImportController@downloadExcel');
	
	
	Route::post('/voucher/publishvoucher/{id}', 'VoucherController@publishvoucher');
	
	Route::post('/voucher/unreleased', 'VoucherController@post_unreleasedvoucher_list');
	
	Route::post('/voucher/publishfile/{id}', 'VoucherController@publishfile');
	 
	Route::get('/voucher/un-duplicate-finder', 'VoucherController@check_unrvoucher_duplicate')->name('ajaxfindunrvoucherduplicate');
	Route::get('/voucher/vo-duplicate-finder', 'VoucherController@check_voucher_duplicate')->name('ajaxfindvoucherduplicate');
	
	Route::delete('/voucher/remove-unr-duplicate/', 'VoucherController@remove_unrvoucher_duplicate');
	Route::delete('/voucher/remove-vor-duplicate/', 'VoucherController@remove_voucher_duplicate');
	
	
	Route::get('/voucher/show/{id}', 'VoucherController@show_voucher')->name('showvoucher');
	Route::get('/voucher/show-unrv/{id}', 'VoucherController@show_unreleased_voucher')->name('showunreleasedvoucher');
	
	Route::post('/voucher/ajaxupdate-unrv-voucher', 'VoucherController@ajax_unrv_update_voucher')->name('ajax_unrv_updatevoucher');
	Route::post('/voucher/ajaxupdatevoucher', 'VoucherController@ajax_update_voucher')->name('ajaxupdatevoucher');
	
	
	//product
	Route::get('/product/', 'ProductController@list_product')->name('product.list.all');
	Route::get('/product/list', 'ProductController@list_product')->name('product.list');
	Route::get('/product/ajaxlist', 'ProductController@ajax_list_product')->name('product.ajax.list');
	
	Route::get('/product/add', 'ProductController@add_product')->name('product.add');
	Route::get('/product/edit/{id?}', 'ProductController@edit_product')->name('product.edit');
	
	Route::post('/product/add', 'ProductController@save_product')->name('product.save');
	Route::post('/product/edit/{id?}', 'ProductController@update_product')->name('product.update');
	
	
	//softpins
	Route::get('/product/softpins', 'ProductController@list_pins')->name('pin.list');
	Route::post('/product/addpins', 'ProductController@save_pins')->name('pin.create');
	
	Route::get('/product/import', 'ImportController@getPinImport')->name('import');
	Route::post('/product/import-pins', 'ImportController@PostpinImport')->name('pin.import');
	Route::post('/product/importprocess', 'ImportController@PinProcessImport')->name('pin.process.import');
	
	//Route::delete('/product/remove-softpins', 'ProductController@remove_pin')->name('pin.remove');
	
	
	Route::delete('/product/remove-softpins', 'ProductController@remove_pin')->name('pin.remove');
	
	
	
	//redeem
	Route::get('/product/pending-redeem', 'ProductController@get_pending_redeemlist')->name('redeem.pending.list');
	Route::delete('/product/confirm-redeem', 'ProductController@confirm_redeem')->name('pin.redeem.confirm');
	Route::delete('/product/reject-redeem', 'ProductController@reject_redeem')->name('pin.redeem.reject'); 
	
	
	
	//new product 
	
	Route::get('/product/product-new', 'ProductController@show_product')->name('ad.product.show'); 	
	
	Route::get('/product/ad-edit/{id?}', 'ProductController@edit_ad_product')->name('ad.product.edit');	
	Route::post('/product/ad-edit/{id?}', 'ProductController@update_ad_product')->name('ad.postproduct.edit');
	
	Route::get('/product/ad-add', 'ProductController@add_ad_product')->name('ad.product.add');
	Route::post('/product/ad-add', 'ProductController@save_ad_product')->name('ad.product.save');
	
	Route::delete('/product/ad-delete', 'ProductController@delete_ad_product')->name('ad.product.delete');
	
	// ad import 
	Route::get('/product/ad-import', 'ImportController@getAdImport')->name('ad.get.import');
	Route::post('/product/ad-import-pins', 'ImportController@PostAdImport')->name('ad.post.import');
	Route::post('/product/ad-importprocess', 'ImportController@AdProcessImport')->name('ad.process.import');
});
//END

Route::get('/admin', 'AdminController@index');
Route::get('/member', 'ClientController@index');
Route::get('/client/profile', 'ClientController@member_profile')->name('client.profile.page');

Route::get('/clearcache', function() {
    $exitCode = Artisan::call('cache:clear');
	return 'cache:cleared';
});


Route::get('logout', 'Auth\LoginController@logout');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');




