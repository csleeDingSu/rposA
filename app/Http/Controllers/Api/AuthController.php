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
	
	public function register(Request $request) {
		
		
        $input = [
             'username'   => $request->username,
		     'password'   => $request->password,
			 'password_confirmation'   => $request->password_confirmation,
 			 'phone'   => $request->phone,
              ];
		
		
		 $validator = Validator::make($input,  [
                'username' => 'required|string|min:1|max:30|unique:members,username',
				'phone' => 'required|string|min:4|max:50|unique:members,phone',
				'password' => 'required|alphaNum|min:5|max:50|confirmed',                
            ],
			[
				'username.required' =>trans('auth.reg_username_empty'),
				'username.exists' =>trans('auth.username_notavailable'),
				'phone.required' =>trans('auth.reg_phone_empty'),
				'username.min' =>trans('auth.reg_username_not_min'),
				'password.required' =>trans('auth.reg_password_empty'),
				'password.min' =>trans('auth.reg_password_not_min'),
				'phone.min' =>trans('auth.phone_not_min'),
				'password.confirmed' =>trans('auth.password_not_same'),
				'username.unique' =>trans('auth.username_notavailable'),
				'phone.unique' =>trans('auth.phone_notavailable'),
				'password.alpha_num' => trans('auth.alpha_num'),
				
			]
        );
		
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$affiliate_id =  unique_random('members', 'affiliate_id', 10);

		$member = \App\Members::create([
			'username' => $data['username'],
			'email' => $data['phone'] . '@email.com',
			'password' => Hash::make($data['password']),
			'affiliate_id' => $affiliate_id,
			'referred_by'   => $referred_by,
			'phone' => $data['phone'],
			'wechat_verification_status' => 1,
		]);

		$id = $member->id;
		//Get Setting Life 
		$setting = \App\Admin::get_setting();


		$wallet = \App\Wallet::create([
				'current_life'    => $setting->game_default_life,
				'member_id'       => $id,
				'current_balance' => env('initial_balance',1200),
				'balance_before'  => env('initial_balance',1200)
			]);

		//update members table
		\App\Members::where('id', $id)
			->update(['current_life' => $setting->game_default_life]);
				
		
		if ( Auth::guard('member')->attempt( [ 'username' => request( 'username' ), 'password' => request( 'password' ) ] ) ) {
			$user = Auth::guard('member')->user();
			
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
			return response()->json( [ 'success' => 'false', 'error' => 'invalid username or password' ], 401 );
		}
	}
	
	
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
		
		if ($user)
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