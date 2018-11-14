<?php
namespace App\ Http\ Controllers\ API;
use Illuminate\ Http\ Request;
use App\ Http\ Controllers\ Controller;
use App\ User;
use Illuminate\ Support\ Facades\ Auth;




use Laravel\Passport\HasApiTokens;

use Validator;
use App\ Member;
class AuthController extends Controller {
	public $successStatus = 200;
	/** 
	 * login api 
	 * 
	 * @return \Illuminate\Http\Response 
	 */
	public	function login() {
		
		if ( Auth::guard('member')->attempt( [ 'username' => request( 'username' ), 'password' => request( 'password' ) ] ) ) {
			$user = Auth::guard('member');
			$user = Member::where('phone' , request( 'username' ))->first();			
			
			$token = $user->createToken( 'APITOKEN' )->accessToken;
			return response()->json(['success' => true, 'token' => $token],$this->successStatus); 
			
		} else {
			return response()->json( [ 'success' => 'false', 'error' => 'Unauthorised' ], 401 );
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