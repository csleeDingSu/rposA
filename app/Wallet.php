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
	
	
	public static function get_wallet_details($id)
	{
		$result = [];
		if (!empty($id))
		{
			$result = DB::table('mainledger')
				->select('mainledger.current_level as level', 'mainledger.current_point as point','mainledger.current_balance as balance', 'game_life.remaining_life as life')
				->join('game_life', 'mainledger.member_id', '=', 'game_life.member_id')
				->where('mainledger.member_id', $id)
				->get()->take(1);
		}
		
		return $result;
	}
	
	
}









