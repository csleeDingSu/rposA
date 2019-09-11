<?php
namespace App\Http\Controllers\Auth;

use App\Helpers\VIPApp;
use App\Http\Controllers\Controller;
use App\Http\Controllers\weixinController;
use App\Mail\SendMail;
use App\Members;
use Auth;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Khsing\WechatAgent\WechatAgent;
use Mail;
use Session;
use Validator;
use \App\helpers\WeiXin as WX;


class MemberRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest:member');
        $this->wx = new WX();
    }

    protected function validatereg(Request $request)
    {
        
		return Validator::make($request, [
            'username' => 'required|string|min:4|max:50|exists:members,username',
            'email' => 'required|string|email|max:255|unique:members',
            'password' => 'required|string|min:6|confirmed',
        ],
		[
			'username.required' =>trans('auth.reg_username_empty'),
			'password.required' =>trans('auth.reg_password_empty'),
			'username.exists' =>trans('auth.username_notavailable'),
			'phone.required' =>trans('auth.reg_phone_empty'),
			'username.min' =>trans('auth.reg_username_not_min'),
			'password.min' =>trans('auth.reg_password_not_min'),
			'username.unique' =>trans('auth.username_notavailable'),
			'phone.unique' =>trans('auth.phone_notavailable'),
			'password.alpha_num' => trans('auth.alpha_num'),
			
		]);
		
		
		return $validator = $this->validate(
            $request,
            [
                'username' => 'required|string|min:4|max:50|exists:members,username',
                'password' => 'required|alphaNum|min:5|max:50',
            ],
			[
				'username.required' =>trans('auth.reg_username_empty'),
				'password.required' =>trans('auth.reg_password_empty'),
				'username.exists' =>trans('auth.username_notavailable'),
				'phone.required' =>trans('auth.reg_phone_empty'),
				'username.min' =>trans('auth.reg_username_not_min'),
				'password.min' =>trans('auth.reg_password_not_min'),
				'password.confirmed' =>trans('auth.password_not_same'),
				'username.unique' =>trans('auth.username_notavailable'),
				'phone.unique' =>trans('auth.phone_notavailable'),
				'password.alpha_num' => trans('auth.alpha_num'),
				
			]
        );
    }
	
	public function showRegisterForm($ref = FALSE)
	{

		$data = [];
		
		
		if (!empty($ref))
		{
			Session::forget('refcode');

			$data['ref']  = Members::CheckReferral($ref);
			
			$data['refcode'] = $ref;

			if (!empty($data['ref'])) {
				session(['refcode' => $ref]);	
			}
			
		}
		
		
		//return view('client/register',$data);
		// return view('common/register',$data);
		return view('auth.login', $data);
	}
    
    
    public function showAuthForm($ref = FALSE, Request $request)
	{

		$data = [];
		
		$agent = new WechatAgent;
		$goto = $request->input('goto');

        if ($agent->is("Wechat")) {
			return redirect('/weixin/'.\Config::get('app.url').'?refcode='.$ref.'&goto=' .$goto); 
		}
		
		
		if (!empty($ref))
		{
			Session::forget('refcode');

			$data['ref']     = Members::CheckReferral($ref);
			
			$data['refcode'] = $ref;

			if (!empty($data['ref'])) {
				session(['refcode' => $ref]);	
			}
			
		}

		//weixin_verify
        if ($this->wx->isWeiXin()) {
            $request = new Request;
            return $this->wx->index($request,'snsapi_userinfo',env('wabao666_domain'));
        } else {
        	//isVIP APP        	
			if (env('THISVIPAPP', false)) {
				return view('auth.login_vip',$data);    
			} else {
				return view('auth.login',$data);    
			}            
        }
	}
    
    public function doreg(Request $request)
    {
        $input = array();
        $referred_by = null;
		parse_str($request->datav, $input);
		$data = array_map('trim', $input);        
        
		if (empty($data['refcode']) )  $data['refcode'] = null;
		
		$input = [
             'username'   => $data['phone'],
			 //'email'   => $data['email'],
		     'password'   => $data['password'],
			 'password_confirmation'   => $data['confirmpassword'],
			 'refcode'   => $data['refcode'],
 			 'phone'   => $data['phone'],
              ];
		
		$validator = Validator::make($input, 
            [
               // 'username' => 'required|string|min:1|max:30|unique:members,username',
				'phone' => 'required|string|min:4|max:50|unique:members,phone',
				//'email' => 'required|email|min:4|max:50|unique:members,email',
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
		else {					
			if (!empty($data['refcode']))
			{
				$ref   = Members::CheckReferral($data['refcode']);
				
				if (empty($ref->id))
				{					
					$error = [trans('dingsu.unknow_ref_key')];
					return response()->json(['success' => false, 'message' => $error]);			 
				}				
				$referred_by = $ref->id;				
			}
			
			$affiliate_id =  unique_random('members', 'affiliate_id', 10);
			
			// Members::create([
			// 	'username' => $data['username'],
			// 	//'email' => $data['email'],
			// 	'password' => Hash::make($data['password']),
			// 	'affiliate_id' => $affiliate_id,
			// 	'referred_by'   => $referred_by,
			// ]);

			$member = Members::create([
				'username' => $data['phone'],
				'email' => $data['phone'] . '@email.com',
				'password' => Hash::make($data['password']),
				'affiliate_id' => $affiliate_id,
				'referred_by'   => $referred_by,
				'phone' => $data['phone'],
				//'wechat_name' => $data['username'],//(isset($data['wechat_name']) ? $data['wechat_name'] : null),
				'wechat_verification_status' => 1,
				'apikey' => unique_numeric_random('members', 'apikey', 8),
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
			/*
			Members::where('id', $id)
				->update(['current_life' => $setting->game_default_life]);
			*/
			//create Game Ledgers
			\App\Ledger::intiateledger($id);
			
			//add welcome bonus life
			\App\Ledger::life($id,102,'credit',$setting->game_default_life,'WBL', '');
			
			//Send Welcome Mail			
					
			//Mail::to($data['email'])->queue(new SendMail('welcomemail', $input)); //correct one
					
			//Generate Login Session
			Auth::guard('member')->attempt(['username' => $data['phone'], 'password' => $data['password']]);
			
			$user = Auth::guard('member')->user();
			$user->active_session = Session::getId();
			$user->save();
			
			// return response()->json(['success' => true]);
			return $this->getGameOrDefaultRoute();
					
        }
    }
	
	public function doregister(Request $request) {	

		
		$inputs = $request->input('datav');		
		$referred_by = null;
		foreach ($inputs as $key=>$val)
		{
			$data[$val['name']] = $val['value'];			
		}
		
		if (empty($data['refcode']) )  $data['refcode'] = null;
		
		$input = [
             'username'   => $data['username'],
			 // 'email'   => $data['email'],
		     'password'   => $data['password'],
			 'password_confirmation'   => $data['confirmpassword'],
			 'refcode'   => $data['refcode'],
			 'phone'   => $data['phone'],
 			 //'wechat_name'   => $data['username'],//$data['wechat_name'],
              ];
		
		$validator = Validator::make($input, 
            [
                'username' => 'required|string|min:1|max:50|unique:members,username',
				// 'email' => 'required|email|min:4|max:50|unique:members,email',
                'password' => 'required|alphaNum|min:5|max:50|confirmed',
                'phone' => 'required|string|min:4|max:50|unique:members,phone',
            ]
        );
		
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		else {					
			if (!empty($data['refcode']))
			{
				$ref   = Members::CheckReferral($data['refcode']);
				
				if (empty($ref->id))
				{					
					$error = [trans('dingsu.unknow_ref_key')];
					return response()->json(['success' => false, 'message' => $error]);			 
				}
				
				$referred_by = $ref->id;				
			}	
			
			$affiliate_id =  unique_random('members', 'affiliate_id', 10);
			
			Members::create([
				'username' => $data['username'],
				'email' => $data['phone'] . '@email.com',
				'password' => Hash::make($data['password']),
				'affiliate_id' => $affiliate_id,
				'referred_by'   => $referred_by,
				'phone' => $data['phone'],
				//'wechat_name' => $data['username'],//(isset($data['wechat_name']) ? $data['wechat_name'] : null),
				'wechat_verification_status' => 1,
				'apikey' => unique_numeric_random('members', 'apikey', 8),
			]);
			
			
			//Send Welcome Mail			
					
			//Mail::to($data['email'])->queue(new SendMail('welcomemail', $input)); //correct one
					
			//Generate Login Session
			Auth::guard('member')->attempt(['username' => $data['username'], 'password' => $data['password']]);
			$user = Auth::guard('member')->user();
			$user->active_session = Session::getId();
			$user->save();
			
            //return response()->json(['success' => true]);	
            return $this->getGameOrDefaultRoute();
			
		}		
	}
	
	
	public function api_register(Request $request) {
		
		
        $input = [
             'username'   => $request->username,
		     'password'   => $request->password,
			 'password_confirmation'   => $request->password_confirmation,
 			 'phone'   => $request->phone,
              ];
		
		 $validator = $this->validate($request, 
			[
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
		
		$affiliate_id =  unique_random('members', 'affiliate_id', 10);

		$member = \App\Members::create([
			'username' => $input['username'],
			'email' => $input['phone'] . '@email.com',
			'password' => Hash::make($input['password']),
			'affiliate_id' => $affiliate_id,
			//'referred_by'   => $referred_by,
			'phone' => $input['phone'],
			'wechat_verification_status' => 1,
			'apikey' => unique_numeric_random('members', 'apikey', 8),
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
			$user->active_session = Session::getId();
			$user->save();
			
			// return response()->json(['success' => true ]); 
			return $this->getGameOrDefaultRoute();
						
		} else {
			return response()->json( [ 'success' => 'false', 'error' => 'invalid username or password' ], 401 );
		}
	}

	public function getGameOrDefaultRoute()
	{
		/*
		//route to main screen
		$url = "/cs/" . env('voucher_featured_id','220');
		$rou = Session::get('re_route');
			
		if ($rou == 'yes')
		{
			//route to game
			$url = "/arcade";
			Session::forget('re_route');
			//Session::flush();
		}
		*/
		// $url = "/arcade";

		 //isVIP APP
        $this->vp = new VIPApp();
        if ($this->vp->isVIPApp()) {
           $url = "/vip";
        } else {
            $url = "/arcade";
        }
        
		return response()->json(['success' => true, 'url' => $url]);
	}
	
}







