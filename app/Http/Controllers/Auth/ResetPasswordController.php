<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;


use Carbon\Carbon;
use App\User;
use App\Members;
use Malahierba\Token\Token;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Config;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
	
	public function CheckResetToken($token = FALSE, $provider)
	{
		$result = [];
		$data   = '';
		$id = '';
		if ($provider = 'members')
		{
			$result = Members::where('reset_password_code', '=' ,$token)->first();
		}
		else 
		{
			$result = User::where('reset_password_code', '=' ,$token)->first();
		}
		
		
		if ($result)
		{
			$token_expiry = Config::get('app.tokens.reset_token');
			$expiry_time  = Carbon::parse($result->reset_password_code_expiry);
			
			$now = Carbon::now();
			
			if ($now >= $expiry_time )
			{
				$data = 'token_expired_error';
			}	
			$id = $result->id;
		}
		else 
		{
			$data = 'no_token_found';
		
		}
		
		return array('id'=>$id,'msg'=>$data);
	}
	
	public function UpdatePassword($id,$password)
	{
		$result   = [];
	
		$password = Hash::make($password);
			
		$insdata = ['reset_password_code'=>null,'reset_password_code_expiry'=>null ,'password'=>$password];
		
		if ($provider = 'members')
		{
			$result = Members::where('id', '=', $id)->update($insdata);
		}
		else 
		{
			$result = User::where('id', '=', $id)->update($insdata);
		}
				
		if ($result) return TRUE;
	}
	
	public function MembershowResetForm($token)
	{
		$result = self::CheckResetToken($token, 'members');
		
		$data['error_msg'] = $result['msg'];		
		
		if (!empty($result['id']))
		{		
			return view('common/updatepassword');
		}		
		return view('common/norecord' , $data);
	}
	
	
	
	
	
	public function resetpassword(Request $request)
	{
		$token = $request->reset_token;
		$rules = [
			'password'   => 'required|min:6|max:50|confirmed',
		];
		
		$validator = Validator::make(Input::only('password','password_confirmation'), $rules);		
		
         if ($validator->fails()) {
			
			 return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		else 
		{
			
			$result = self::CheckResetToken($token, 'members');
		
			$data['error_msg'] = $result['msg'];
			
			//print_r($result['id']);
			
			if (empty($result['id']))
			{
				return response()->json(['success' => false, 'message' => $data['error_msg']]);
			}			
			
			
			$result = Members::where('reset_password_code', '=' ,$token)->first();
			
			self::UpdatePassword($result->id,$request->password);
			
			
			return response()->json(['success' => true, 'message' => '']);
			
		}
		
	}
	
	
	
}
