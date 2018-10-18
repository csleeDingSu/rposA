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

//Route::group(['namespace' => 'Api', 'middleware' => ['auth:api']],function(){
Route::group(['namespace' => 'Api'],function(){
		
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
	
	Route::post('resetlife', 'GameController@life_redemption')->name('api.game.resetlife');
	
	Route::post('update-wechatname', 'MemberController@update_wechat')->name('post.wechat.name');
	
 });	

//deprecated
Route::get('/generateresult', function() {
    //$exitCode = Artisan::call('generate:gameresult');
	return 'deprecated';
});



