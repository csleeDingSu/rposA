<?php
namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;


use Validator;

//use Illuminate\Foundation\Auth\ResetsPasswords;
//use Illuminate\Support\Facades\Password;


//use \Illuminate\Notifications\Notifiable;
//use DB;
use Carbon\Carbon;
use App\User;
use App\Members;
use Malahierba\Token\Token;
use Config;

use DirapeToken;

use App\Notifications\ResetPassword;

use Mail;
use App\Mail\SendMail;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
	//use ResetsPasswords;
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   	
	public function __construct()
    {
       // $this->middleware('auth')->only(['resetAuthenticated', 'getResetAuthenticatedView']);
        //$this->middleware('guest')->except(['resetAuthenticated', 'getResetAuthenticatedView']);
		
		//test
		$this->middleware('guest')->only(['resetAuthenticated', 'getResetAuthenticatedView']);
    }
	
	
	public function MembershowLinkRequestForm()
	{
				
		return view('common/resetpassword');
	}
	
	
	
	
	public function rules($type)
    {
        if ($type == 'username')
		{
			return [
            	'_username' => 'required|string|min:4|max:50',
        	];
		
		}
		return [
			'_username' => 'required|email',
		];
		
    }
	
	public function MemberInsertToken($model,$id,$token) 
	{
		$token_expiry = Config::get('app.tokens.reset_token');
		$date = Carbon::now()->addMinutes($token_expiry);
		$insdata = ['reset_password_code'=>$token,'reset_password_code_expiry'=>$date];
		
		$msg = Members::where('id', '=', $id)->update($insdata);
		
		if ($msg) return TRUE;
	}
	
	public function sendResetLinkEmail( Request $request )
	{
		
		// get our login input
		$login = $request->input('_username');
		// check login field
		$login_type = filter_var( $login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
		// merge our login field into the request with either email or username as key
		$request->merge([ $login_type => $login ]);
		$rules = self::rules($login_type);
		
		$input = [
             '_username'   => $request->input('_username'),
              ];
		
		$validator = Validator::make($input, $rules);
        
         if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		else {
			
			$result = Members::where($login_type, '=' ,$login)->first();
			if ($result)
			{
				//check user status 
				if ($result->member_status != 1)
				{
					//return response()->json(['success' => false, 'message' => trans('dingsu.user_inactive_error')]);
				}
				
				//Create Token
				$token = new Token($result, 'reset_password_code',1);
				$token_str = $token->get();
				
				if (self::MemberInsertToken('Members',$result->id,$token_str) )
				{
					$result->token = $token_str;
					
					
					$when = Carbon::now()->addMinutes(1);

					
					
					$users = 
						['name' => $result->firstname, 'email' => $result->email, 'token' => $token_str , 'reseturl' => url("/reset/{$token_str}") 
					];
					
					/*				
					Mail::send('emails.emailtest', ['title' => $result->email, 'data' => $users], function ($message)
					{

						$subject = 'Welcome to Dingsu';
						$message->subject($subject);
						$message->to('prem@dingsu.com');

					});
					*/
					
					$job = (new SendMail('resetpass', $users))->delay(0);
					
					Mail::to($result->email)->queue($job);
					
					//Mail::to($result->email)->queue(new SendMail('resetpass', $users))->delay(30); //correct one
					
					
					return response()->json(['success' => true, 'message' =>'']);
				}
				
				return response()->json(['success' => false, 'message' => trans('dingsu.token_insert_error')]);
				
				
			}
			
			
			return response()->json(['success' => false, 'message' => trans('dingsu.unknown_user')]);
		}
			
		
	}
	
}







