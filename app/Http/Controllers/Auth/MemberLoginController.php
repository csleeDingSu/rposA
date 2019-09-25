<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\VIPApp;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\ Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Larashop\Notifications\ResetPassword as ResetPasswordNotification;
use Session;
use Validator;
use Jenssegers\Agent\Agent;

class MemberLoginController extends Controller
{
   
	
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:member');
    }
	
	
	protected function authenticated(Request $request, $user)
	{
	 	$user = Auth::guard('member')->user();
		$user->active_session = Session::getId();
	    $user->save();
		return redirect('/');
	}
	
	
	public function showLoginForm($slug = FALSE)
	{
		$data = array();
        $data['slug'] = $slug;
		// return view('client.login', $data);
		//return view('common.memberlogin', $data);
        
        //isVIP APP         
        if (env('THISVIPAPP', false)) {
            // return view('auth.login_vip',$data);
            $agent = new Agent();
            // var_dump($agent->isSafari());
            // dd($agent);

        	if ($agent->isAndroidOS()) {
        		$data['RunInApp'] = empty($_SERVER['HTTP_X_REQUESTED_WITH']) ? false : true;	
        	} else {
        		$data['RunInApp'] = true;
        	}
			
            // return view('auth.login_new',$data);  
            return view('auth.login_vip_new',$data);        
        } else {
            return view('auth.login',$data);    
        }
	}

    public function showLoginFormApp()
    {
        if (Auth::Guard('member')->check()){
            return redirect('/');
        } else {
        	$agent = new Agent();
			
			if ($agent->isAndroidOS()) {
        		$data['RunInApp'] = empty($_SERVER['HTTP_X_REQUESTED_WITH']) ? false : true;	
        	} else {
        		$data['RunInApp'] = true;
        	}

            // return view('auth/login_new', $data);
            return view('auth/login_vip_new', $data);
        }
        
    }
	
	/**
     * Check either username or email.
     * @return string
     */
    public function username()
    {
        $username  = request()->get('username');
        $fieldName = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldName => $username]);
        return $fieldName;
    }
	
	public function validatelogin(Request $request)
	{
		
		$validator = $this->validate(
            $request,
            [
                'username' => 'required|string|min:4|max:50',
                // 'phone' => 'required|string|min:4|max:50',
                'password' => 'required|alphaNum|min:5|max:50',
            ]
        );
		
		
	}
	
	
	protected function attemptLogin(Request $request)
    {
        
		$credentials = $request->only('username', 'password');
        $username = $credentials['username'];
		$password = $credentials['password'];
		$credentials['user_status'] = 1; 

        //1st try username
        $array = ['username' => $username, 'password' => $password];
        $bRes = Auth::guard('member')->attempt($array, $request->remember);
        if (!$bRes) {
            //2nd try phone number
            $array = ['phone' => $username, 'password' => $password];
            $bRes = Auth::guard('member')->attempt($array, $request->remember);
        }
		
		if ($bRes) {
			// if successful, then redirect to their intended location			
			return redirect('/');
		 }
		  // if unsuccessful, then redirect back to the login with the form data
		 $request->session()->put('login_error', trans('auth.failed'));
			throw ValidationException::withMessages(
				[
					'error' => [trans('auth.failed')],
				]
			);
			
    }
	
	/**
     * @param Request $request
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $request->session()->put('login_error', trans('auth.failed'));
        throw ValidationException::withMessages(
            [
                'error' => [trans('auth.failed')],
            ]
        );
    }
    

    
    public function dologin(Request $request) {		
        
        
        $username = $request->username; 

		$input = [
            $username = $request->username,
            $password = $request->password, 
              //'username'   => $request['username'],			
		      //'password'   => $request['password'],
              ];

        // if (preg_match('/^[0-9]{7}+$/', $request['username'])) {
        //    $rule = 'exists:members,phone';
        // }
        // else {
        //    $rule = 'exists:members,username';
        // }

        $rules = [ 
            'username' =>                                                                   
                'required|string|min:1|max:50', 
                Rule::exists('members', 'username')                     
                ->where(function ($query) use ($username) {                      
                    $query->where('phone', $username);   
                    }),                                                           
            'password' => 'required|alphaNum|min:5|max:50'

        ];
        
        //$validator = Validator::make($input, $rules
        $validator = $this->validate($request, $rules
            ,
			[
                'username.required' =>trans('auth.username_empty'),
                'password.required' =>trans('auth.password_empty'),
                'password.min' =>trans('auth.password_not_min'),
                'password.alpha_num' => trans('auth.alpha_num'),
			]
        );
		

               
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {            
            $this->fireLockoutEvent($request);
            return response()->json(['success' => false, 'message' => $this->sendLockoutResponse($request)]);
        }

        if ($this->attemptLogin($request)) {
			
            //route to main screen
			// $url = "/cs/" . env('voucher_featured_id','220');
			// $rou = Session::get('re_route');
			
			// if ($rou == 'yes')
			// {
   //              //route to game
			// 	$url = "/arcade";
			// 	Session::forget('re_route');
			// 	//Session::flush();
			// }

            //isVIP APP
            $this->vp = new VIPApp();
            if ($this->vp->isVIPApp()) {
               $url = "/vip";
            } else {
                $url = "/arcade";
            }
			
            return response()->json(['success' => true, 'url' => $url, 'message' => $this->sendLoginResponse($request)]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
		
    }
	
	
	public function login(Request $request) {
		
		
		$this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
		
    }
	
	/**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
	
	public function apilogin(Request $request) 
	{	
                
        $username = $request->username; 
		$password = $request->password; 
		$apikey   = $request->apikey; 
/*
		$input = [
            'username' => $request->username,
            'password' => $request->password, 
			'apikey'   => $request->apikey, 
              ];

        $rules = [ 
            'username' =>                                                                   
                'required|string|min:1|max:50', 
                Rule::exists('members', 'username')                     
                ->where(function ($query) use ($username,$apikey) {                      
                    $query->where('phone', $username)->where('apikey', $apikey);   
                    }),                                                           
            'password' => 'required|alphaNum|min:5|max:50',
			'apikey'   => 'required|string|min:1|max:50', 			

        ];
		$validator = Validator::make($input, $rules
            ,
			[
                'username.required' =>trans('auth.username_empty'),
                'password.required' =>trans('auth.password_empty'),
                'password.min' =>trans('auth.password_not_min'),
                'password.alpha_num' => trans('auth.alpha_num'),
			]
        );
		
		
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'message' => $validator->errors()]);
		}
		*/
		$record = \App\Members::where('apikey', $apikey)->first();
		
		if ($record)
		{
			if ( $record->key_expired_at <= now() )
			{
				return response()->json(['success' => false,'message'=>[trans('auth.key_expired')] ]);
			}			
			return response()->json(['success' => true, 'data' => $record]);			
		}		
		return response()->json(['success' => false,'message'=>[trans('auth.unknown_apikey')] ]);
		
		/*
		$array = ['username' => $username, 'password' => $password, 'apikey' => $apikey];
		
		$bRes = Auth::guard('member')->attempt($array);
		
		if (!$bRes)
		{	
			return response()->json(['success' => false,'message'=>[trans('auth.failed')] ]);
		}
						
		$user = Auth::guard('member')->user(); 
		
		if ( $user->key_expired_at <= now() )
		{
			return response()->json(['success' => false,'message'=>[trans('auth.key_expired')] ]);
		}
		
		$user =  $user->makeVisible('password')->toArray();
		
		return response()->json(['success' => true, 'data' => $user]);
		*/
    }
	
	public function wechat_auth(Request $request) 
	{		
		//\Auth::logout();
		\Auth::guard('member')->logout();
		
		\Log::info(json_encode(['wechat auth' => $request->all()], true));
        
        $forceupdate = '';
		$changephone = '';
		$url         = "/cs/220";
        $openid      = $request->openid; 
		$wechatname  = html_entity_decode($request->nickname);
		$referred_by = null;		
		$goto = $request->input('goto');

		if (!empty( $request->refcode) )  
		{
			$referred_by = $request->refcode;	
		
			$ref         = \App\Members::CheckReferral($referred_by);

			if (!empty($ref->id))
			{					
				$referred_by = $ref->id;	 
			}	
			else
			{
				$referred_by = null;
			}			
		}
			
		
		\Log::debug(json_encode(['request' => $request->all()], true));
		
		/*
		if( preg_match('/micromessenger/i', strtolower($_SERVER['HTTP_USER_AGENT'])) ) { 
			\Log::debug(json_encode(['wechat' =>'not in wechat browser'], true));
			dd('use wechat to login');
		}
		*/		
		
		
		//$openid     = 'adsfsafsdfdsaf2423'; 
		//$wechatname = '67rfdsf';	
				
		if (empty($wechatname))
		{
			return response()->json(['success' => false,'message'=>[trans('auth.empty_wechatname')] ]);
		}
		if (empty($openid))
		{
			return response()->json(['success' => false,'message'=>[trans('auth.empty_openid')] ]);
		}
		
		$record = \App\Members::where('openid', $openid)->first();
		
		if ($record)
		{
			if ( $record->openid != $openid  )
			{
				//return response()->json(['success' => false,'message'=>[trans('auth.openid_mismatch')] ]);
				$forceupdate = 'yes';
			}
			//To fix old register
			if (!empty($record->phone))
			{
				$changephone = '';
				/*if ( $record->phone != $wechatname  )
				{
					return response()->json(['success' => false,'message'=>[trans('auth.wechatname_mismatch')] ]);
				}*/
			}
			else
			{
				$changephone = 'yes';
			}
			
			\Log::debug(json_encode(['existing user' => $openid ], true));
		}
		else
		{
            //temporary disable - error when wechatname content with symbol
			 $preg = \App\Members::where('phone', $wechatname)->first();
			 if ($preg)
			 {
			 	return response()->json(['success' => false,'message'=>[trans('auth.user_already_exists')] ]);
			 }
			
			\Log::debug(json_encode(['new user' => $openid ], true));
			
            //register
			$setting = \App\Admin::get_setting();
			
			$user = \App\Members::create([
										  'wechat_verification_status' => '1',
										  'openid'       => $openid ,
										  'wechat_name'  => $wechatname,
										  'gender'       => $request->sex,
										  'profile_pic'  => $request->headimgurl ,
										  'current_life' => $setting->game_default_life,
										  'referred_by'  => $referred_by,
										  'affiliate_id' => unique_random('members', 'affiliate_id', 10) 
										 ]);			
			
			$wallet = \App\Wallet::create([
					'current_life'    => $setting->game_default_life,
					'member_id'       => $user->id,
					'current_balance' => env('initial_balance',120),
					'balance_before'  => env('initial_balance',120)
				]);
			
		}

        //update wechat info
        if (!empty($openid)) {
            $filter = ['openid' => $openid];
            $array = ['openid' => $openid, 'wechat_name' => $wechatname, 'gender' => $request->sex, 'profile_pic' => $request->headimgurl];
            \App\Members::updateOrCreate($filter, $array)->id;    
        }
        
		$user = \App\Members::where('openid', $openid)->first();		
		
		//create login session
		//Auth::guard('member')->loginUsingId($user->id, true);
		//print_r(Auth::guard('member')->user());
		//update loggedin userdata
		//$user = Auth::guard('member')->user();
		if ($changephone)
		{
			//$user->phone        = $wechatname;
			//$user->username     = $wechatname;
			//$user->openid       = $openid;
		}
		
		$user->openid          = $openid;
		$user->gender          = $request->sex;
		$user->profile_pic     = $request->headimgurl;
		$user->activation_code = $otp = unique_random('members', 'activation_code', 15);
		$user->activation_code_expiry = Carbon::now()->addMinutes(10);
		
		$url = '/wechat-login/'.$otp . '/' . $goto;
		
		// $user->save(); //not working -- fail to save

        //temporary use this
        $endTime = Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s');
        $filter = ['openid' => $openid];
        $array = ['openid' => $openid, 'activation_code' => $otp, 'activation_code_expiry' => $endTime];
        \Log::debug(json_encode(['endtime' => $endTime], true));

        \App\Members::updateOrCreate($filter, $array)->id; 		
		
		\Log::debug(json_encode(['redirect to ' => $url ], true));
		
		return response()->json([
			'success'      => true,			
			'url' => $url
		]);
		
		
		/*
		//create token
		$tokenResult = $user->createToken('APITOKEN');
		$token = $tokenResult->token;
		$token->expires_at = Carbon::now()->addMinutes(10);
		$token->save();
		
		//re route 
		$rou = Session::get('re_route');
			
		if ($rou == 'yes')
		{
			$url = "/arcade";
			Session::forget('re_route');
			//Session::flush();
		}
		//return redirect($url);
		//dd(Auth::check());
		return response()->json([
			'success'      => true,
			'data'         => $user->only(['id', 'username', 'phone', 'email','wechat_name','created_at']),
			'access_token' => $tokenResult->accessToken,
			'token_type'   => 'Bearer',
			'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
			'is_auth'      => Auth::check(),
			'url' => $url
		]);
		*/
    }
	
	
	//deprecated
	public function otp_login($otp = FALSE) {		
			dd('deprecated');
		
		$url	= '';
		
		\Log::warning(json_encode(['otp' => $otp], true));
/*
		if( !preg_match('/micromessenger/i', strtolower($_SERVER['HTTP_USER_AGENT'])) ) {
			\Log::debug(json_encode(['wechat' =>'not in wechat browser'], true));
			dd('use wechat to login');
		}
		*/
		
		
		if (empty($otp))
		{
			\Log::warning(json_encode(['unauthorised_login' => 'empty OTP'], true));
			return redirect($url);
		}
		
		$record = \App\Member::where('activation_code', $otp)->first();
		
		if ($record)
		{
			if ($record->wechat_verification_status == 1)
			{
				//\Log::warning(json_encode(['unauthorised_wechat_login' => 'wechat verification failed'], true));
				//dd('waiting for admin verification');
			}
			
			if (Carbon::parse($record->activation_code_expiry)->gt(Carbon::now()))
			{
				\Auth::guard('member')->loginUsingId($record->id,true);
				
				$user = Auth::guard('member')->user();
				$user->active_session  = Session::getId();
				$user->activation_code = null;
				$user->activation_code_expiry = '';
				$user->save();	
				
				\Log::debug(json_encode(['wechat_login' => 'verified and redirect to game'], true));
				return redirect('/arcade');			
			}
			\Log::warning(json_encode(['unauthorised_wechat_login' => 'expired OTP'], true));
			return redirect($url);
		}
		\Log::warning(json_encode(['unauthorised_wechat_login' => 'unknown OTP'], true));
		
		return redirect($url);		
    }
	
}
