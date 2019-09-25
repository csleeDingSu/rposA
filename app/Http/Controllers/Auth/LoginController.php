<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Hash;
use Auth;
use Session;
use Tymon\JWTAuth\Facades\JWTAuth;
class LoginController extends Controller
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
    protected $redirectTo = '/member';
	protected $guard      = 'members';
	

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	
	protected function authenticated(Request $request, $user)
	{
	
		/*print_r($user); die();
		if ( $user->isAdmin() ) {
			return redirect()->route('admin/dashboard');
		}
		*/

	 	return redirect('/home');
	}
	
	
	public function showLoginForm()
	{
		$data = array();
		return view('common.login', $data);
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
                'password' => 'required|alphaNum|min:5|max:50',
            ]
        );
		
		
	}
	
	public function Membervalidatelogin(Request $request)
	{
		
		$validator = $this->validate(
            $request,
            [
                'username' => 'required|string|min:4|max:50',
                'password' => 'required|alphaNum|min:5|max:50',
            ]
        );
		
		
	}
	
	protected function attemptLogin(Request $request)
    {
        
		$credentials = $request->only('username', 'password');
		
		$username = $credentials['username'];
		$password = $credentials['password'];
		/*$level    = $credentials['level'];
		
		switch($level)
		{
			case 'member':
				$tablename = 'member';
			break;
			case 'admin':
				$tablename = 'users';
			break;	
		}
		*/
		
		$credentials['user_status'] = 1; 
		/*
		if (Auth::guard('members')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        	// if successful, then redirect to their intended location
        	return redirect()->intended(route('admin.dashboard'));
      	} 
		*/
		if (!Auth::attempt([ 'username' => $username, 'password' => $password])) {
			$request->session()->put('login_error', trans('auth.failed'));
			throw ValidationException::withMessages(
				[
					'error' => [trans('auth.failed')],
				]
			);
		}
		else 
		{
			return redirect('admin/dashboard');
		}
		
		
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
	
	public function logout(Request $request, \Tymon\JWTAuth\JWTAuth $auth)
    {
        $token = $request->bearerToken();		
		
		$user = Auth::guard('member')->user();
		Auth::logout();
		$this->guard()->logout();
		$request->session()->flush();		
		$request->session()->regenerate();
		if ($user)
		{
			$claims = ['userid' => $user->id];
			$token = $auth->fromUser($user, $claims);
			JWTAuth::setToken($token)->invalidate();
			event(new \App\Events\EventUserLogout($user->id));			
		}

		// $request->session()->forget(['refcode']);
		Session::forget('refcode');

		$isApp = env('THISVIPAPP', false);
		if ($isApp) {
			return redirect('/app-login');
		} else {
			return redirect('/');	
		}        
    }
	
}
