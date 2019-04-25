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

//Route::post('login', 'API\AuthController@login');
//Route::post('register', 'API\AuthController@register');

Route::post('temp_log', 'ShareProductController@temp_log');

Route::group(['namespace' => 'Api', 'middleware' => ['auth:api']],function(){
	Route::get('details', 'AuthController@details');
});

Route::any('gettoken', 'Api\AuthController@get_token');

Route::get('/test', function () {
    return response()->json([
        'success' => true
    ]);
})->middleware('auth:api');


Route::group(['namespace' => 'Api', 'middleware' => ['auth:api']],function(){
//Route::group(['namespace' => 'Api'],function(){
		
    Route::get('list-all-game/{id?}', 'GameController@listall')->name('api.game.listall');
	
	Route::get('game-setting', 'GameController@get_game_setting')->name('api.game.setting');
	
	Route::post('wallet-detail', 'GameController@get_wallet_details')->name('api.wallet.details');
	
	Route::any('update-game-result', 'GameController@update_game')->name('api.game.update');
	
	Route::post('view-drawresult', 'GameController@view_draw_result')->name('api.game.viewdraw');
	
	Route::get('view-result/{id?}', 'GameController@view_game_result')->name('api.game.viewresult');
	
	Route::get('result-history/{id?}', 'GameController@get_game_history')->name('api.game.history');
	
	Route::get('betting-history', 'GameController@get_betting_history')->name('api.betting.history');
	
	//Route::get('game-play-time/{id?}', 'GameController@get_game_time')->name('api.game.time'); //deprecated
	
	Route::get('get-latest-result', 'GameController@get_latest_result')->name('api.game.latestresult');
	
	Route::post('resetlife', 'GameController@redeem_life')->name('api.game.resetlife');
	
	Route::post('update-wechatname', 'MemberController@update_wechat')->name('post.wechat.name');
			
	Route::get('/product-list', 'ProductController@list_product_by_point')->name('api.product.list');
	
	Route::get('/redeem-history', 'ProductController@get_redeem_history')->name('api.redeem.history');
	
	Route::post('/request-redeem', 'ProductController@request_redeem')->name('api.redeem.request');	
	
	Route::get('/referral-list', 'MemberController@member_referral_list')->name('api.referral.list');
	
	Route::get('child-list', 'MemberController@child_list')->name('child.list');

	Route::any('update-game-result-temp', 'GameController@update_game_temp')->name('api.game.update_temp');

	Route::any('get-game-result-temp', 'GameController@get_update_game_temp')->name('api.game.get.update_temp');
    
    Route::post('change-game-notification', 'GameController@change_game_notification')->name('change.game.notification');
    Route::get('get-game-notification', 'GameController@get_game_notification')->name('get.game.notification');
	
	Route::post('/request-vip-upgrade', 'ProductController@request_vip')->name('api.vip.request');
		
	Route::post('/redeem-vip', 'ProductController@redeem_vip')->name('api.vip.redeem');	
	
	Route::post('/reset-vip', 'GameController@vip_life_redemption')->name('api.vip.reset');
	
	Route::post('/check-redeem', 'ProductController@vip_redeem_condition')->name('api.vip.redeem_condition');
	
	Route::any('/master-call', 'GameController@master_out')->name('api.master.call');
	
	Route::any('/master-call-nobet', 'GameController@master_withoutbet')->name('api.master.withoutbet');
	
	Route::any('/member-referral-count', 'MemberController@get_introducer_count')->name('api.referral.count');
	
	Route::any('/member-referral-list', 'MemberController@get_introducer_history')->name('api.referral.list');
	
	Route::any('/member-point-list', 'MemberController@get_wabao_coin_history')->name('api.point.list');
	
	Route::any('/wabao-fee', 'ProductController@wabaofee')->name('api.wabaofee'); //new
	
	Route::get('/redeem-hn', 'ProductController@get_redeem_history_new')->name('api.redeem.historynew');
	
	Route::post('/buy-basic-package', 'BasicPackageController@request_package_upgrade')->name('api.basicpackage.request');
	
	
	
	
 });

//without token
Route::group(['namespace' => 'Api'],function()
{
	Route::get('/package-list', 'ProductController@list_package')->name('api.package.list');
	Route::get('/get-passcode', 'ProductController@passcode')->name('get_passcode');
	
	Route::get('/basic-package-list', 'BasicPackageController@list_package')->name('api.basicpackage.list');
	
	Route::get('/basic-package-redeem-history', 'BasicPackageController@get_redeem_history')->name('api.basicredeem.history');
	
});

//cron_test
Route::get('/cron_test', 'TestController@cron_test')->name('cron_test');
