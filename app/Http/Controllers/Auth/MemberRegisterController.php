<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Hash;
use Auth;
use Session;
use App\Members;
use Validator;
use DB;


use Mail;
use App\Mail\SendMail;
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
    }

    protected function validatereg(Request $request)
    {
        
		return Validator::make($request, [
            'username' => 'required|string|min:4|max:50',
            'email' => 'required|string|email|max:255|unique:members',
            'password' => 'required|string|min:6|confirmed',
        ]);
		
		
		return $validator = $this->validate(
            $request,
            [
                'username' => 'required|string|min:4|max:50',
                'password' => 'required|alphaNum|min:5|max:50',
            ]
        );
    }
	
	public function showRegisterForm($ref = FALSE)
	{
		$data = [];
		
		
		if (!empty($ref))
		{
			$data['ref']     = Members::CheckReferral($ref);
			
			$data['refcode'] = $ref;
			
		}
		
		
		return view('client/register',$data);
		return view('common/register',$data);
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
			 'email'   => $data['email'],
		     'password'   => $data['password'],
			 'password_confirmation'   => $data['confirmpassword'],
			 'refcode'   => $data['refcode'],
              ];
		
		$validator = Validator::make($input, 
            [
                'username' => 'required|string|min:4|max:50|unique:members,username',
				'email' => 'required|email|min:4|max:50|unique:members,email',
                'password' => 'required|alphaNum|min:5|max:50|confirmed',
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
				'email' => $data['email'],
				'password' => Hash::make($data['password']),
				'affiliate_id' => $affiliate_id,
				'referred_by'   => $referred_by,
			]);
			
			
			//Send Welcome Mail			
					
			Mail::to($data['email'])->queue(new SendMail('welcomemail', $input)); //correct one
					
			
			
			return response()->json(['success' => true]);			
		}		
	}
}







