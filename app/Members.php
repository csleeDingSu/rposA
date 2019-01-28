<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;



class Members extends Model
{   
    use Notifiable;
	
	protected $fillable = [
        'username',
        'email',
		'password',
		'affiliate_id',
		'referred_by',
		'wechat_name',
		'phone',
		'wechat_verification_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'members';
	
	public static function save_member($request)
	{		
		print_r($request);
	}
	
	public static function update_member($id,$data)
	{	
		
		 return $result = DB::table('members')
            ->where('id', $id)
            ->update($data);
		/*
		DB::enableQueryLog();
		print_r(DB::getQueryLog());
		try {
				DB::table('members')
					->where('id', $id)
					->update($data);
				 return TRUE;
			}  catch (\Exception $ex) {

				 //dd($ex);
				 return response()->json(['success' => false, 'record' => '']);
			}
		*/
		
	}
	
	public static function get_member($id)
	{
		$result = DB::table('members')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function get_child($refid)
	{
		$result = Members::select('username','created_at','wechat_name','wechat_verification_status','member_status')->where('referred_by', $refid)->get();
		return $result;
	}
	
	public static function get_child_with_page($refid,$status = '',$limit = 50)
	{
		$result = Members::select('username','created_at','wechat_name','wechat_verification_status','member_status')->where('referred_by', $refid);
				
		if ($status != '') $result->where('wechat_verification_status', '=', $status);
		
		$out = $result->paginate($limit);
		return $out;
	}
	
	public static function get_view_member($id)
	{
		$result = DB::table('view_members')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function get_member_referral_list($id)
	{
		if (empty($id)) return [];
		
		$result = DB::table('members')->select('id','affiliate_id','username','firstname','firstname')->where('referred_by', $id)->get();
		
		return $result;
	}
	
	public static function CheckReferral($refid)
	{
		$result = DB::table('members')->select('id','affiliate_id','username','firstname','firstname','realname')->where('affiliate_id', $refid)->first();
		
		return $result;
	}
	
	
	public static function get_pending_wechat_members($limit = 100)
	{
		$result =  DB::table('members')->whereNotNull('wechat_name')->where('wechat_verification_status', 1)->paginate($limit);
		
		return $result;
	}
	
	public static function get_introducer_life($id = 1)
	{
		//$result = DB::table('settings')->where('id', $id)->pluck('introduce_life');
		$result = DB::table('settings')->select('introduce_life')->where('id', $id)->first();
		return $result;
	}
	
	public static function get_introducer_count($id)
	{
		$result = DB::table('view_member_introduce_count')->where('memberid', $id)->get();
		
		return $result;
	}
	
	public static function get_introducer_history($id)
	{
		$result = DB::table('members')->select('id','username','firstname','created_at','phone','introducer_life','wechat_verification_status')->where('referred_by', $id)->orderby('created_at','DESC')->get();
		
		return $result;
	}
	
	public static function get_wabao_coin_history($id)
	{
		$result = DB::table('view_wabao_point')->where('memberid', $id)->orderby('created_at','DESC')->get();
		
		return $result;
	}
}