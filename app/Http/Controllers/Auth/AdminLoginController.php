<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Hash;
use Auth;
use Session;

class AdminLoginController extends Controller
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
    protected $redirectTo = 'admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
		//$this->middleware('guest')->except('logout');
    }
	
	
	protected function authenticated(Request $request, $user)
	{
	
		/*print_r($user); die();
		if ( $user->isAdmin() ) {
			return redirect()->route('admin/dashboard');
		}
		*/

	 	return redirect('admin/dashboard');
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
	
	
	protected function attemptLogin(Request $request)
    {
        
		$credentials = $request->only('username', 'password');
		
		$username = $credentials['username'];
		$password = $credentials['password'];
		
		
		$credentials['user_status'] = 1; 
		
		
		if (Auth::guard('admin')->attempt(['username' => $username, 'password' => $password], $request->remember)) {
			// if successful, then redirect to their intended location
			//return redirect()->intended(route('admin.dashboard'));
			return redirect('admin/dashboard');
		  }
		  // if unsuccessful, then redirect back to the login with the form data
		  //return redirect()->back()->withInput($request->only('username'));
         $request->session()->put('login_error', trans('auth.failed'));
			throw ValidationException::withMessages(
				[
					'error' => [trans('auth.failed')],
				]
			);
	
	
		/*
		
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
		*/
		
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
	
	
	
}
