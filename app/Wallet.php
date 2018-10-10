<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use SoftDeletes; 
class Wallet extends Model
{   
    protected $fillable = [
        'member_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'mainledger';
	
	protected $table_life = 'game_life';
	
	protected $table_history = 'ledger_history';
	
	
	public static function get_wallet_details($gameid, $memberid)
	{		
		//$queries = DB::enableQueryLog();
		//print_r(DB::getQueryLog());
		$result = [];
		if (!empty($memberid))
		{
			$result = DB::table('mainledger')
				->select('mainledger.current_point as point', 'game_life.remaining_life as life','mainledger.current_balance as balance','game_life.gameid')
				->join('game_life', 'mainledger.member_id', '=', 'game_life.member_id')
				->where('mainledger.member_id', $memberid);			
			if ($gameid)
			{
				$result = $result->where('game_life.gameid', $gameid);
				$result = $result->get()->take(1);
			}	
			else 
			{				
				$result = $result->get();
			}				
		}		
		return $result;
	}
	
	
	
}









