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

//Route::group(['namespace' => 'Api', 'middleware' => ['auth:member']],function(){
Route::group(['namespace' => 'Api'],function(){
		
    Route::get('list-all-game/{id?}', 'GameController@listall')->name('api.game.listall');
	
	Route::get('game-setting/{id?}', 'GameController@get_game_setting')->name('api.game.setting');
	
	Route::post('wallet-detail/{id?}', 'GameController@get_wallet_details')->name('api.wallet.details');
	
	Route::any('update-game-result', 'GameController@update_game')->name('api.game.update');
	
	Route::post('view-drawresult', 'GameController@view_draw_result')->name('api.game.viewdraw');
	
	Route::get('view-result/{id?}', 'GameController@view_game_result')->name('api.game.viewresult');
	
	Route::get('result-history/{id?}', 'GameController@get_game_history')->name('api.game.history');
	
	Route::get('betting-history/{id?}', 'GameController@get_betting_history')->name('api.betting.history');
	
	Route::get('game-play-time/{id?}', 'GameController@get_game_time')->name('api.game.time');
	
 });	


Route::get('/generateresult', function() {
    $exitCode = Artisan::call('generate:gameresult');
	return 'result generated';
});



