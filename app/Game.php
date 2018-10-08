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
		//$result = DB::table('game_result')->where('game_id', $id)->get();
		
		
		$result =  DB::table('game_result')->select('id as result_id','game_id','game_level_id','created','expiry_time','raw_result','game_result')->where('game_id', $id)->get();
		
		return $result;
	}
	
	public static function get_single_gameresult($id)
	{
		//$result = DB::table('game_result')->where('game_id', $id)->get();
		
		
		$result =  DB::table('game_result')->select('id as result_id','game_id','game_level_id','created','expiry_time','raw_result','game_result')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function get_single_gameresult_by_gameid($id)
	{
		$result =  DB::table('game_result')->select('id as result_id','game_id','game_level_id','created','expiry_time','raw_result','game_result')->where('game_id', $id)->first();
		
		return $result;
	}
	
	public static function archive_data($chunk)
	{		
		$chunk= json_decode( json_encode($chunk), true);
		try{
		   DB::table('game_result_history')->insert($chunk);
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
		return $result =  DB::table('member_game_result')->select('id as gameid','game_level_id','is_win','game_result as result','bet','bet_amount')->where('game_id',$gameid)->paginate(20);
	}
	
}









