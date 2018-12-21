<?php
namespace App\ Http\ Controllers\ API;
use Illuminate\ Http\ Request;
use App\ Http\ Controllers\ Controller;
use App\ User;
use Illuminate\ Support\ Facades\ Auth;




use Laravel\Passport\HasApiTokens;

use Validator;
use App\ Member;
use Carbon\ Carbon;

use Laravel\Passport\Passport;
class AuthController extends Controller {
	public $successStatus = 200;
	/** 
	 * login api 
	 * 
	 * @return \Illuminate\Http\Response 
	 */
	public	function login() {
		
		if ( Auth::guard('member')->attempt( [ 'username' => request( 'username' ), 'password' => request( 'password' ) ] ) ) {
			//$user = Auth::guard('member');
			$user = Member::where('phone' , request( 'username' ))->first();
			
			$this->revoke_token($user);		
			
			
			$tokenResult = $user->createToken('APITOKEN');
			$token = $tokenResult->token;
			$token->expires_at = Carbon::now()->addMinutes(1);
			$token->save();
			return response()->json([
				'success' => true,
				'access_token' => $tokenResult->accessToken,
				'token_type' => 'Bearer',
				'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
			]);
			
			return response()->json(['success' => true, 'token' => $token],$this->successStatus); 
			
		} else {
			return response()->json( [ 'success' => 'false', 'error' => 'Unauthorised' ], 401 );
		}
	}
	
	
	public function get_token() {
		
		$user = Member::where('id' , request( 'id' ))->first();
		
		if ($suer)
		{
			if ($user->active_session == request( 'token' ))
			{			
				//$this->revoke_token($user);	

				$tokenResult = $user->createToken('APITOKEN');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addMinutes(10);
				$token->save();
				return response()->json([
					'success' => true,
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
					'requested_time' => Carbon::now()->toDateTimeString()
				]);
				return response()->json(['success' => true, 'token' => $token],$this->successStatus); 
			}
		}
		
		
		return response()->json( [ 'success' => 'false', 'error' => 'Unauthorised' ], 401 );				
	}
	
	public	function logout() 
	{
		
	}
	
	public	function revoke_token($user) 
	{
		$userTokens = $user->tokens;
		foreach($userTokens as $token) {
			$token->revoke();   
		}
	}
	
	public	function revoke() 
	{
		$user = Member::where('id' , request( 'memberid' ))->first();
		$userTokens = $user->tokens;
		foreach($userTokens as $token) {
			$token->revoke();   
		}
	}
	
	public	function delete() 
	{
		$user = Member::where('id' , request( 'memberid' ))->first();
		$userTokens = $user->tokens;
		foreach($userTokens as $token) {
			$token->delete();   
		}
	}
	
	/** 
	 * details api 
	 * 
	 * @return \Illuminate\Http\Response 
	 */
	public	function details() {
		$user = Auth::guard('member');
		
		$uu = Auth::guard('member')->user();
		print_r($uu);die();
		
		
		return response()->json(['success' => $user], $this-> successStatus);
		if ($user)
		{
			return response()->json(['success' => true, 'data' => $user],$this->successStatus); 
		}
		return response()->json( [ 'success' => 'false' ], 401 );
	}
}