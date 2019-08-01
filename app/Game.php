<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use SoftDeletes; 
use App\member_game_result;

class Game extends Model
{   
    protected $fillable = [
        'game_name',
        'game_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'games';
	
	protected $table_category = 'game_category';






		// -------------------------Game----------------------------------
		public static function get_gamelist()
		{
			return Game::all();
		}
	
		public static function save_game($chunk)
		{
			DB::table('games')->insert($chunk);
		}
	
		public static function get_game($id)
		{
			$result = DB::table('games')->where('id', $id)->first();
			
			return $result;
		}

		
	
		public static function get_gamelevel($id)
		{
			$result = DB::table('game_levels')->where('game_id', $id)->orderBy('level_position', 'ASC')->get();
			
			return $result;
		}
	
		public static function get_gamelevel_options($id)
		{
			$result = DB::table('game_levels_options')->get();
			
			return $result;
		}

	
		public static function update_gameinfo($id,$data)
		{	
			if (!empty($id))
			{
				return $result = DB::table('games')
				->where('id', $id)
				->update($data);
			}		 		
		}


		

	
		public static function save_level($chunk)
		{
			DB::table('game_levels')->insert($chunk);
		}
	
		public static function get_level_by_id($id)
		{
			$result = DB::table('game_levels')->where('id', $id)->first();
			
			return $result;
		}
	
		public static function update_level($id,$data)
		{	
			if (!empty($id))
			{
				return $result = DB::table('game_levels')
				->where('id', $id)
				->update($data);
			}		 		
		}
		
		public static function get_game_category($id = FALSE, $time = FALSE)
		{

			if (!empty($id))
			{
				$result = DB::table('game_category')->where('id', $id)->first();
			}
			else if (!empty($time))
			{
				//$now  = Carbon::now();
				//$to   = $now->addSeconds(5);
				$queries = DB::enableQueryLog();


				$result = DB::table('game_category')->Where('unix_next_run', '<=', $time['unix_next_run'])->orwhereBetween('next_run', [$time['now'], $time['to']])->get();
				//$queries = DB::enableQueryLog();
				//print_r(DB::getQueryLog());

				return $result;
			}
			else{
				$result = DB::table('game_category')->get();
			}

			return json_encode($result);
		}

	




	
		public static function save_gamecategory($chunk)
		{
			DB::table('game_category')->insert($chunk);
		}
		public static function edit_gamecategory($id = FALSE)
		{
			$result = DB::table('game_category')->where('id', $id)->first();
			
			return $result;
		}
	
		public static function update_gamecategory($id,$data)
		{	
			if (!empty($id))
			{
				return $result = DB::table('game_category')
				->where('id', $id)
				->update($data);
			}		 		
		}
	
		public static function delete_gamecategory($id)
		{
			$result = DB::table('game_category')->delete($id);
			return $result;
		}
	
		
		public static function delete_level_by_id($id)
		{
			$result = DB::table('game_levels')->delete($id);
			return $result;
		}




		// --------------------------------------------
	
	
	
	public static function save_gamelevels($request)
	{		
		
	}
	
	
	
	
	public static function get_game_options($id = FALSE)
	{
		if ($gameid == FALSE) return FALSE;
		
	}
	
	
	public static function insert_gameresult($chunk)
	{
		$id = DB::table('game_result')->insertGetId($chunk);
		return $id;
	}
	
	public static function get_gameresult($id,$now = FALSE)
	{
		//$now     = Carbon::now()->toDateTimeString();
		$now = date('Y-m-d H:i:s');
		$result =  DB::table('game_result')->select('id as result_id','game_id','game_level_id','created_at','expiry_time','game_result')->where('game_id', $id)->where('created_at', '<=', $now)->where('expiry_time', '>=', $now)->first();
		return $result;
	}
	
	public static function get_single_gameresult($id)
	{
		//$result = DB::table('game_result')->where('game_id', $id)->get();		
		
		$result =  DB::table('v_game_result')->select('id as result_id','game_id','game_level_id','created_at','expiry_time','game_result')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function get_single_gameresult_by_gameid($id,$now = FALSE)
	{
		//$queries = DB::enableQueryLog();			
		$result =  DB::table('game_result')->select('id as result_id','game_id','game_level_id','created_at','expiry_time','game_result')->where('game_id', $id)->where('created_at', '<=', $now)->where('expiry_time', '>=', $now)->first();		
		//print_r(DB::getQueryLog());
		return $result;
	}
	
	public static function get_future_result($id,$now = FALSE)
	{
		$result =  DB::table('game_result')->select('id as draw_id','game_id','created_at','expiry_time')->where('game_id', $id)->where('expiry_time', '>', $now)->skip(1)->take(5)->get();				
		return $result;
	}
	
	public static function archive_data($chunk)
	{		
		$chunk= json_decode( json_encode($chunk), true);
		unset($chunk['game_level_id']);
		try{
			//$queries = DB::enableQueryLog();
		    DB::table('game_result_history')->insert($chunk);
			//print_r(DB::getQueryLog());
		}
		catch(\Exception $e){
		   // do task when error
		   echo $e->getMessage();
		}
	}
	
	public static function force_delete($id)
	{
		$result = DB::table('game_result')
                ->where('game_id', $id)
                ->delete();
	}
	
	public static function listall($id)
	{
		$result = [];
		if (!empty($id))
		{			
			$result_g = DB::table('games')->where('id', $id)->get();			
			$result_l = self::get_gamelevel($id);
			$result   = self::merge_gamelevels($result_g, $result_l);
		}
		else 
		{
			$result_g = Game::all();
			$result_l = DB::table('game_levels')->get();
			
			$result = self::merge_gameslevels($result_g, $result_l);
		}
		return $result;
	}
	private static function merge_gamelevels($game, $levels)
	{
		$result = [];
		$level = [];
		$i = 1;
		foreach ($game as $key=>$value)
		{
			$result[$i] = (array) $value;
			
			foreach ($levels as $ky=>$val) {
				if ($val->game_id == $value->id)
				{
					$level[$val->id] = $val;						
				}
				$result[$i]['levels'] = $level;

			}
			$level = [];
			$i++;
		}
		
		return $result;
	}
	
	private static function merge_gameslevels($game, $levels)
	{
		$result = [];
		$level = [];
		$i = 1;
		foreach ($game as $key=>$value)
		{
			$result[$i] = $value;
			foreach ($levels as $ky=>$val) {
				if ($val->game_id == $value->id)
				{
					$level[$val->id] = $val;						
				}
				$result[$i]['levels'] = $level;
			}
			$level = [];
			$i++;
		}
		
		return $result;
	}
	
	
	public static function list_gamewithlevels($id)
	{
		$result = [];
		if (!empty($id))
		{
			$result = DB::table('games')
				->join('game_levels', 'games.id', '=', 'game_levels.game_id')
				->where('games.id', $id)
				->get();
		}
		
		return $result;
	}
	
	public static function gamesetting($id)
	{
		$result = [];
		if (!empty($id))
		{
			$result = DB::table('games')
				->select('game_category.win_ratio','games.game_name','game_category.id as categoryid', 'game_category.game_time as result_time','game_category.block_time as freeze_time')
				->join('game_category', 'games.game_category', '=', 'game_category.id')
				->where('games.id', $id)
				->first();
		}
		
		return $result;
	}
	
	public static function add_play_history($data, $filter = null)
	{				
      
      	// return member_game_result::firstOrCreate($filter, $data)->id;
		DB::table('member_game_result')->insert($data);
	}
	
	public static function get_game_history($gameid, $orderby = FALSE)
	{				
		$query = DB::table('game_result_history')->select('id as gameid','result_id as drawid','game_result as result')->where('game_id',$gameid);
		
		if ($orderby)
		{
			$query = $query->orderBy('id', $orderby);
		}
		
		return $query->paginate(30);
	}
	
	public static function get_betting_history($gameid)
	{				
		return $result =  DB::table('member_game_result')->select('id','gameid','game_level_id','is_win','game_result as result','bet','bet_amount')->where('game_id',$gameid)->paginate(20);
	}
	
	public static function get_betting_history_grouped($gameid, $memberid,$vip = FALSE)
	{				
		$table = 'member_game_result';
		if ($vip) $table = 'vip_member_game_result';
		
		$result =  DB::table($table)->select('id','game_id','game_level_id','is_win','game_result as result','bet','bet_amount','player_level','created_at','wallet_point','reward')->where('member_id',$memberid)->where('game_id',$gameid)->orderBy('created_at', 'DESC')->paginate(50);
		
		return $result;
		
		//@todo add osrting function
		
		$newOptions = [];
		if ($result)
		{
			foreach ($result as $key=>$val)
			{
				$level = $val->player_level;

  				$newOptions[$level][] = $val;
			}
			
			krsort($newOptions);
			
		}		
		return $newOptions;
	}
	
	/** Testing purpose**/
	private static function sort_paginationdata($result = [])
	{
		$result->getCollection()->transform(function ($value) {
				
			//print_r($value);
			$value = self::sort_paginationdata($value);
			return $value;
		});
		
		$newOptions = [];
		if ($result)
		{
			//$result = (array) $result;
			//krsort($result);
			foreach ($result as $key=>$val)
			{
				print_r($val);die();
				$level = $val->player_level;

  				$newOptions[$level][] = $val;
			}
			
			krsort($newOptions);			
		}
		return $newOptions;
	}
	
	public static function get_player_level($gameid, $memberid, $vip = FALSE)
	{
		 
		$table = 'member_game_result';
		if ($vip) $table = 'vip_member_game_result';
		
		$result =  DB::table($table)->where('game_id', '=', $gameid)->where('member_id', '=', $memberid)->latest()->first();
		
		return $result;		
	}
	
	
	public static function get_member_next_level($gameid, $memberid, $vip = FALSE)
	{
		// $result =  DB::table('member_game_result')->where('game_id', '=', $gameid)->where('member_id', '=', $memberid)->latest()->first();
		$table = 'v_member_game_result';
		if ($vip) $table = 'v_vip_member_game_result';
		$result = DB::table($table)->where('game_id', $gameid)->where('member_id', $memberid)->latest()->first();
		
		//print_r($result);
		
		if ($result)
		{
			$levelid = $result->game_level_id;
			
			$level = self::get_game_next_level($gameid, $levelid);
		}
		else 
		{
			$level = self::get_game_next_level($gameid, '');
		}
		
		return $level;
		
	}
	
	
	/**
	 * logic
	 * if the user win it will show first level
	 * if the user dont have any records in member_game_history it will show first level
	 * if the user have data and if he lose it will show the next level
	 *
	 * New function for game reset 
	 * if the user have data and if the latest reselt reseted it will return first level
	 
	 * 7-12-2018 added support to VIP
	 **/
	public static function get_member_current_level($gameid, $memberid, $vip = FALSE)
	{
		$table = 'v_last_member_game_result';
		if ($vip) $table = 'v_last_vip_member_game_result';
		
		// $result = DB::table($table)->where('game_id', $gameid)->where('member_id', $memberid)->latest()->first();
		$result = DB::table($table)->where('game_id', $gameid)->where('member_id', $memberid)->first();
		
		if ($result)
		{
			$levelid = $result->game_level_id;
			
			if ($result->is_win ==1 || $result->is_reset ==1)
			{
				$levelid = '';
				$level   = self::get_game_current_level($gameid, $levelid);
				$level->is_reseted = TRUE;
			}
			else
			{
				//Fixed for wrong ID position 
				$level   = self::get_game_next_position($gameid, $levelid);
			}
			
			
		}
		else 
		{
			$level = self::get_game_current_level($gameid, '');
		}
		
		return $level;		
	}
	/**
	 * 7-12-2018 added support to retrive bet amount & reward column
	 **/
	public static function get_game_next_position($gameid, $levelid = false)
	{
		$current = self::get_game_current_level($gameid, $levelid);
		
		$queries = DB::enableQueryLog();
		//print_r(DB::getQueryLog());
		
		$next = DB::table('game_levels')->where('game_id', '=', $gameid)->where('game_level', '>', $current->position)->orderBy('game_level', 'ASC')->select('id as levelid','game_level as position','bet_amount','point_reward')->first();
		
		if (!$next)
		{
			$next = self::get_game_current_level($gameid, '');
			$next->is_reseted = TRUE;
		}
		
		return $next;
		//print_r(DB::getQueryLog());
		
		
	}
	
	/**
	 * 7-12-2018 added support to retrive bet amount & reward column
	 **/
	public static function get_game_current_level($gameid, $levelid = false)
	{
		if ($levelid)
		{
			$current = DB::table('game_levels')->where('id', '=', $levelid)->where('game_id', '=', $gameid)->select('id as levelid','game_level as position','bet_amount','point_reward')->first();
		}
		else 
		{
			$current = DB::table('game_levels')->where('game_id', '=', $gameid)->where('game_level', '=', 1)->select('id as levelid','game_level as position','bet_amount','point_reward')->first();		
		}
		return $current;		
	}
	
	/**
	 * PremAdarsh
	 * @todo -: Add conditon to get id based on game_level position 
	 **/
	public static function get_game_next_level($gameid, $levelid = false)
	{
		if ($levelid)
		{
			$next = DB::table('game_levels')->where('id', '>', $levelid)->where('game_id', '=', $gameid)->select('id as levelid','game_level as position')->first();
		}
		else 
		{
			$next = DB::table('game_levels')->where('game_id', '=', $gameid)->where('game_level', '=', 1)->select('id as levelid','game_level as position')->first();		
		}
		return $next;		
	}
	
	public static function old9999get_game_next_level($gameid, $levelid = false)
	{
		//echo $levelid.'sd';
		//$queries = DB::enableQueryLog();
		
		//$next = DB::table('game_levels')->where('game_id', '=', $gameid)->where('game_level', '>', 'game_level')->where('id', '>', $levelid)->min('id');
		
		if ($levelid)
		{
			$next = DB::table('game_levels')->where('game_id', '=', $gameid)->where('id', '>', $levelid)->min('game_level');
		}
		else 
		{
			$next = DB::table('game_levels')->where('game_id', '=', $gameid)->min('game_level');		
		}
		
		//print_r($next);
		//die();
		return $next;
		//print_r(DB::getQueryLog());
		print_r($next);die();
		
	}
	
	
	public static function get_latest_result($gameid)
	{
		return $result = DB::table('game_result_history')->where('game_id', $gameid)->latest()->first();
	}
		
	public static function DeleteGameHistory($date)
	{
		$result = DB::table('game_result_history')
                ->where('created_at','<', $date)
                ->delete();		
	}
	
	public static function get_latest_member_result($memberid , $gameid, $vip = FALSE)
	{
		$table = 'member_game_result';
		if ($vip) $table = 'vip_member_game_result';
		
		return $result = DB::table($table)->where('game_id', $gameid)->where('member_id', $memberid)->latest()->first();		
	}
	
	
	public static function get_latest_game_result($memberid , $gameid, $vip = FALSE)
	{
		$table = 'member_game_result';
		if ($vip) $table = 'vip_member_game_result';
		$result = DB::table($table)->where('member_id', $memberid);
		if ($gameid) $result->where('game_id', $gameid);
		$out = $result->latest()->first();
		return $out;
	}
	
	public static function reset_member_game_level($memberid , $gameid, $vip = FALSE)	
	{
		$table = 'member_game_result';
		if ($vip) $table = 'vip_member_game_result';
		
		$level = self::get_latest_game_result($memberid , $gameid,$vip);
		
		if ($level)
		{
			DB::table($table)
            ->where('id', $level->id)
            ->update(['is_reset' => 1]);
		}
		
		return true;
	}
	
	//@todo:- get consecutive Limit from env
	// 31-12-2018 added count calculation to fix first consecutive lose
	public static function get_consecutive_lose($memberid , $gameid,$vip = FALSE)
	{
		$win = 0;
		$lmt = 6;
		$table = 'member_game_result';
		if ($vip) $table = 'vip_member_game_result';
		
		$result = DB::table($table)
				->select('is_win','is_reset')
                 ->where('member_id', $memberid)
				 ->where('game_id', $gameid)
				 ->orderBy('created_at', 'DESC')
                 ->limit($lmt)
				 ->get();
		
		$count = count($result);
		
		if ($count < $lmt) return '';		
		
		if ($result)
		{
			$i = 0 ; 
			foreach ($result as $row)
			{
				$win = $row->is_reset + $row->is_win + $win;
				$i++;
			}
		}
		
		//\Log::info(json_encode(['consecutive lose memberid' => [$memberid=>$win]], true));
		
		if ($win <= 0) return 'yes';
		return '';
		
		
		$c_lose = '';
		$consecutive_lose = DB::select("SELECT 
								m_id ,count
							FROM(
								SELECT
									m.member_id AS m_id,
											m.game_id AS g_id,
									m.created_at AS m_date,
									m.is_win,
									IF(m.is_win is null AND @b = m.member_id, @a := @a +1, @a := 0) AS count,
									@b := m.member_id
								FROM member_game_result m
							JOIN (
								SELECT 
									@a := 0, 
									@b := 0
								) AS t
							  ) AS TEMPff
							WHERE count >= ? and m_id = ? and g_id = ?
							GROUP BY m_id", [6,$memberid,$gameid]);
		
		if ($consecutive_lose)
		{
			$c_lose = 'yes';
		}
		
		return $c_lose;		
	}
	
	public static function add_vip_play_history($data)
	{				
		DB::table('vip_member_game_result')
            ->insert($data);
	}
	
	
	
	public static function get_current_result($gameid,$now = FALSE)
	{
		$result = DB::table('game_result')->where('game_id', $gameid)->where('created_at', '<=', $now)->where('expiry_time', '>=', $now)->first();
		
		if ($result) return $result->id;
		else return '1';
	}
	
	
	
	//new
	
	public static function get_game_bycategory($id)
	{
		$result = DB::table('games')->where('game_category', $id)->get();
		
		return $result;
	}
	
	public static function update_category($id, $data = [])
	{
		if ($id)
		{
			DB::table('game_category')
            	->where('id', $id)
            	->update($data);
		}
		
	}
	
	public static function get_expiredresult($time, $gameid = FALSE)
	{
		//$queries = DB::enableQueryLog();
		
		$result =  DB::table('game_result')->select('id as result_id','game_id','game_level_id','created_at','expiry_time','game_result')->where('unix_expiry_time', '<=', $time);
		
		if ($gameid) $result->where('game_id', '=', $gameid);
		
		$out = $result->get();
		
		
		//print_r(DB::getQueryLog());
		return $out;
	}
	
	public static function clean_expiredresult($time, $gameid = FALSE)
	{
		$result = DB::table('game_result')
                ->where('unix_expiry_time', '<=', $time);
		
		if ($gameid) $result->where('game_id', '=', $gameid);
		
        $result->delete();
	}
	
	
	public static function testins($chunk)
	{
		DB::table('test')->insert($chunk);
	}
	
	public static function IsFirstLife($memberid,$count = '1')
	{
		
		$result =  DB::table('member_game_result')->select(DB::raw('COUNT(CASE WHEN is_reset = 1 THEN 1 END) AS life'))->where('member_id',$memberid)->first();
		
		$user = \Auth::guard('member')->user();
		
		if (!empty($user->is_purged_gamelife))
		{
			$result->life = $result->life+1;
		}
		
		return $result->life;
	}
	
	
	public static function today_play_statistics($memberid, $gameid)
	{
		//DB::enableQueryLog(); 
		$date   = date('Y-m-d');
		//$date   = '2019-06-17';
		$result = DB::table('view_game_win_lose_by_date')->where('member_id', $memberid)->where('game_id', $gameid)->where('created_at', $date )->first();
		//dd(DB::getQueryLog());
		return $result;
	}
}









