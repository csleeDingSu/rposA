<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Report extends Model
{
   
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public static function alla()
	{
	}
	
	public static function pending_wechat()
	{
		return $count = DB::table('members')->where('wechat_verification_status',1)->count();
	}
	public static function pending_vip_verification()
	{		
		return $count = DB::table('view_pending_vip')->count();		
	}
	
	public static function pending_redeem_verification()
	{		
		return $count = DB::table('view_pending_redeem')->count();		
	}
	
	public static function total_active_user()
	{		
		return $count = DB::table('members')->where('member_status','0')->count();	
	}
	
	public static function total_inactive_user()
	{		
		return $count = DB::table('members')->where('member_status','1')->count();	
	}
	
	public static function today_user_registration($date)
	{		
		return $count = DB::table('members')->where('created_at',$date)->count();	
	}
	
	public static function total_game_bet($date = FALSE, $vip = FALSE)
	{		
		$table = 'member_game_result';
		if ($vip) $table = 'vip_member_game_result';
		
		$balance = DB::table($table);		
		if ($date)
		{
			$balance->where('created_at',$date);	
		}	
		
		return $balance->sum('bet_amount');	
		
	}
	
	public static function total_game_lose($date = FALSE, $vip = FALSE)
	{		
		$table = 'member_game_result';
		if ($vip) $table = 'vip_member_game_result';
		
		$balance = DB::table($table);	
		if ($date)
		{
			$balance->where('created_at',$date);	
		}
		return $balance->where('is_win',null)->sum('bet_amount');	
	}
	
	public static function today_game_player($date,$vip = FALSE)
	{		
		$table = 'member_game_result';
		if ($vip) $table = 'vip_member_game_result';
		
		$balance = DB::table($table);	
		if ($date)
		{
			$balance->where('created_at',$date);	
		}
		return $balance->groupBy('member_id')->count();
	}
	
	public static function total_product_redeem($date = FALSE)
	{		
		$count = DB::table('redeemed');	
		if ($date)
		{
			$count->where('redeemed_at',$date);	
		}
		return $count->wherein('redeem_state' ,['2','1'])->count();
			
	}
	
	public static function total_package_redeem($date = FALSE)
	{		
		$count = DB::table('vip_redeemed');	
		if ($date)
		{
			$count->where('redeemed_at',$date);	
		}
		return $count->wherein('redeem_state' ,['2','3'])->count();
	}
	
	public static function game_win_lose($gameid = '101')
	{
		$row = DB::table('game_result_history')
			  ->where('game_id', '=', $gameid)
			  ->latest()->first();
			 // ->pluck('result_id');  // "5"
		
		//return $result = DB::table('game_result_history')->where('game_id', $gameid)->latest()->first();
		//print_r($row);die();
		//$row->result_id = '78734';
			//$row->result_id = '78817';
		$result = DB::table('member_game_result')->select("draw_id",'game_result'
			, DB::raw('count(case when is_win = 1 then 1 else null end) as win')
			, DB::raw('count(case when is_win is null then 1 else null end) as lose')
			, DB::raw('count(DISTINCT member_id) as played_users')
			)->where('draw_id', $row->result_id)->first();
		
		$result->draw_id = $row->result_id;
		$result->game_result = $row->game_result;
		return $result ;
		
	}
	
	public static function ledger_points($vip = FALSE)
	{		
		$field = 'current_point';
		if ($vip) $field = 'vip_point';
		
		$balance = DB::table('mainledger');
		
		return $balance->sum($field);	
		
	}
	
	public static function voucher_count($type = FALSE, $date = FALSE)
	{		
		$table = 'vouchers';
		if ($type) $table = 'unreleased_vouchers';
		
		$data = DB::table($table);		
		if ($date)
		{
			$data->where('created_at',$date);	
		}	
		
		return $data->count();		
		
	}
	
	public static function wabao_redeem_user()
	{	
		$result = DB::table('view_package_type_usercount')->select('count','package_type')->get();
		return $result ;		
	}
	
	 //DB::enableQueryLog();
		//$result = DB::table($table)->where('pass_access_flag','=','3')->select('id', 'product_detail_link', 'pass_access_flag')->limit($limit)->get($limit);
		//print_r(DB::getQueryLog()); 
	
	
	public static function update_data($data, $id = 1)
	{	
		
		 return $result = DB::table('dashboard')
            ->where('id', $id)
            ->update($data);
	}
	
	
	
}