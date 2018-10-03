<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
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
	
	public static function get_gamelist($id)
	{
		
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
	
	public static function get_gamelevel($id)
	{
		$result = DB::table('game_levels')->where('game_id', $id)->orderBy('level_position', 'ASC')->get();
		
		return $result;
	}
}