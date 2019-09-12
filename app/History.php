<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class History extends Model
{   
    protected $fillable = [        'member_id','game_id','account_id','debit','credit','notes','balance_before','balance_after','ledger_type','uuid',
    ];	
			
    protected $table = 'ledger_history_new';
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
	
	public static function add_ledger_history($data)
	{
		$history = new History();	
		$history->fill($data);
		$history->uuid = $uuid = unique_numeric_random((new static)->getTable(), 'uuid', 15);			
		$history->save();
		return $uuid;
	}
	
	public static function get_point($memberid , $gameid = FALSE, $date = FALSE)
    {
		$result = \DB::table('a_point_by_date')->where('member_id' , $memberid);
		if ($gameid)
		{
			$result = $result->where('game_id' , $gameid);
		}		
		if ($date)
		{			
			$result = $result->where('point_date',$date);
		}
		
		$result = $result->sum('credit');
		return $result;
    }
	
	
}






