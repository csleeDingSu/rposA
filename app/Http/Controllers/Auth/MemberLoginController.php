<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Hash;
use Auth;
use Session;
use Larashop\Notifications\ResetPassword as ResetPasswordNotification;

use Validator;
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
	
	
	public function showLoginForm()
	{
		$data = array();
		// return view('client.login', $data);
		//return view('common.memberlogin', $data);
        return view('auth.login',$data);
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
		
		$input = [
             'username'   => $request['username'],			
		     'password'   => $request['password'],
              ];

        // if (preg_match('/^[0-9]{7}+$/', $request['username'])) {
        //    $rule = 'exists:members,phone';
        // }
        // else {
        //    $rule = 'exists:members,username';
        // }
		
		$validator = Validator::make($input, 
            [
                // 'username' => 'required|string|min:1|max:50',
                'password' => 'required|alphaNum|min:5|max:50',
                'username' => 'required|string|min:1|max:50|exists:members,username',
            ],
			[
                'username.required' =>trans('auth.username_empty'),
                'password.required' =>trans('auth.password_empty'),
                'password.min' =>trans('auth.password_not_min'),
                'username.exists' =>trans('auth.username_notexists'),
			]
        );
		
		if ($validator->fails()) {
            //2nd validation
            $validator = Validator::make($input, 
                [
                    'username' => 'required|string|min:1|max:50|exists:members,phone',
                ],
                [
                    'username.required' =>trans('auth.username_empty'),
                    'username.exists' =>trans('auth.username_notexists'),
                ]
            );

            if ($validator->fails()) {

                return response()->json(['success' => false, 'message' => $validator->errors()->all()],200);
            
            }

		}
               
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {            
            $this->fireLockoutEvent($request);
            return response()->json(['success' => false, 'message' => $this->sendLockoutResponse($request)]);
        }

        if ($this->attemptLogin($request)) {
            return response()->json(['success' => true, 'message' => $this->sendLoginResponse($request)]);
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
	
}
