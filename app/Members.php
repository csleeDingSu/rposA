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
	
	public static function update_member($id)
	{
		
		
		DB::table('members')
            ->where('id', $id)
            ->update(['firstname' => 'fyname']);
	}
	
	public static function get_member($id)
	{
		$result = DB::table('members')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function CheckReferral($refid)
	{
		$result = DB::table('members')->select('id','affiliate_id','username','firstname','firstname','realname')->where('affiliate_id', $refid)->first();
		
		return $result;
	}
}