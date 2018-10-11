<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use SoftDeletes; 
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
	
	public static function get_gamelist()
	{
		return Game::all();
	}
	
	public static function save_gamelevels($request)
	{		
		
	}
	
	public static function update_game($id)
	{
				
		DB::table('members')
            ->where('id', $id)
            ->update(['firstname' => 'fyname']);
	}
	
	public static function get_game($id)
	{
		$result = DB::table('games')->where('id', $id)->first();
		
		return $result;
	}
	//New
	public static function get_gamelevel($id)
	{
		$result = DB::table('game_levels')->where('game_id', $id)->orderBy('level_position', 'ASC')->get();
		
		return $result;
	}
	
	public static function get_level_by_id($id)
	{
		$result = DB::table('game_levels')->where('id', $id)->first();
		
		return $result;
	}
	
	
	public static function get_game_category($id = FALSE)
	{
		
		if (!empty($id))
		{
			$result = DB::table('game_category')->where('id', $id)->first();
		}
		else{
			$result = DB::table('game_category')->get();
		}
		
		return json_encode($result);
	}
	
	public static function get_game_options($id = FALSE)
	{
		if ($gameid == FALSE) return FALSE;
		
	}
	
	
	public static function insert_gameresult($chunk)
	{
		DB::table('game_result')->insert($chunk);
	}
	
	public static function get_gameresult($id)
	{
		$result =  DB::table('game_result')->select('id as result_id','game_id','game_level_id','created_at','expiry_time','game_result')->where('game_id', $id)->first();
		return $result;
	}
	
	public static function get_single_gameresult($id)
	{
		//$result = DB::table('game_result')->where('game_id', $id)->get();
		
		
		$result =  DB::table('game_result')->select('id as result_id','game_id','game_level_id','created_at','expiry_time','game_result')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function get_single_gameresult_by_gameid($id)
	{
		$result =  DB::table('game_result')->select('id as result_id','game_id','game_level_id','created_at','expiry_time','game_result')->where('game_id', $id)->first();
		
		return $result;
	}
	
	public static function archive_data($chunk)
	{		
		$chunk= json_decode( json_encode($chunk), true);
		
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
		$flights = DB::table('game_result')
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
				->select('games.game_name','game_category.id as categoryid', 'game_category.game_time as result_time','game_category.block_time as freeze_time')
				->join('game_category', 'games.game_category', '=', 'game_category.id')
				->where('games.id', $id)
				->get()->take(1);
		}
		
		return $result;
	}
	
	public static function add_play_history($data)
	{				
		DB::table('member_game_result')
            ->insert($data);
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
	
	public static function get_betting_history_grouped($gameid, $memberid)
	{				
		$result =  DB::table('member_game_result')->select('id','game_id','game_level_id','is_win','game_result as result','bet','bet_amount','player_level','created_at')->where('member_id',$memberid)->where('game_id',$gameid)->orderBy('created_at', 'DESC')->paginate(50);
		
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
	
	public static function get_player_level($gameid, $memberid)
	{
		 
		//$result =  DB::table('member_game_result')->select('is_win','player_level')->where('game_id', '=', $gameid)->where('member_id', '=', $memberid)->max('player_level');
		
		$result =  DB::table('member_game_result')->where('game_id', '=', $gameid)->where('member_id', '=', $memberid)->latest()->first();
		
		return $result;
		
	}
	
	
	public static function get_member_next_level($gameid, $memberid)
	{
		// $result =  DB::table('member_game_result')->where('game_id', '=', $gameid)->where('member_id', '=', $memberid)->latest()->first();
		
		$result = DB::table('member_game_result')->where('game_id', $gameid)->where('member_id', $memberid)->latest()->first();
		
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
	 **/
	public static function get_member_current_level($gameid, $memberid)
	{
		$result = DB::table('member_game_result')->where('game_id', $gameid)->where('member_id', $memberid)->latest()->first();
		
		if ($result)
		{
			$levelid = $result->game_level_id;
			
			if ($result->is_win ==1)
			{
				$levelid = '';
				$level   = self::get_game_current_level($gameid, $levelid);
				$level->is_reseted = TRUE;
			}
			else
			{
				//get next level ?
				//$level   = self::get_game_next_level($gameid, $levelid);
				
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
	
	public static function get_game_next_position($gameid, $levelid = false)
	{
		$current = self::get_game_current_level($gameid, $levelid);
		
		$queries = DB::enableQueryLog();
		//print_r(DB::getQueryLog());
		
		$next = DB::table('game_levels')->where('game_id', '=', $gameid)->where('game_level', '>', $current->position)->orderBy('game_level', 'ASC')->select('id as levelid','game_level as position')->first();
		
		if (!$next)
		{
			$next = self::get_game_current_level($gameid, '');
			$next->is_reseted = TRUE;
		}
		
		return $next;
		//print_r(DB::getQueryLog());
		
		
	}
	
	public static function get_game_current_level($gameid, $levelid = false)
	{
		if ($levelid)
		{
			$current = DB::table('game_levels')->where('id', '=', $levelid)->where('game_id', '=', $gameid)->select('id as levelid','game_level as position')->first();
		}
		else 
		{
			$current = DB::table('game_levels')->where('game_id', '=', $gameid)->where('game_level', '=', 1)->select('id as levelid','game_level as position')->first();		
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
		
	
}









