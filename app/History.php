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
		return $history;
	}

	public static function get_point($memberid , $gameid = FALSE, $date = FALSE)
    {
		$result = \DB::table('view_betting_by_date')->where('member_id' , $memberid);
		if ($gameid)
		{
			$result = $result->where('game_id' , $gameid);
		}		
		if ($date)
		{			
			$result = $result->where('created_at',$date);
		}
		
		$result = $result->first();

		if ($result)
		{
			return $result->balance;
		}
		return '0';
    }

	
	public static function get_point_old($memberid , $gameid = FALSE, $date = FALSE)
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
	
	public static function get_summary($memberid,$type = 'buyproduct')
	{
		$result = \DB::table('new_summary_report')->select('*');		
		if ($type == 'buyproduct')
		{
			$result = $result->whereNotIn('type', ['basicpackage']);
		}
		elseif($type == 'basicpackage')
		{
			$result = $result->whereNotIn('type', ['buyproduct']);
		}
		$result = $result->where('member_id', $memberid)->orderby('created_at','DESC')->get();
		return $result;		
	}

	public static function get_summary_new($memberid,$type = '')
	{
		$result = \DB::table('s_summary_new')->select('*');		
		if ($type == 'redeem')
		{
			$result = $result->whereIn('type', ['softpin','buyproduct']);
		}
		elseif($type == 'resell')
		{
			$result = $result->where('type', 'creditresell');
		}
		elseif($type == 'recharge')
		{
			$result = $result->where('type', 'topup');
		}
		
		$result = $result->where('member_id', $memberid)->orderby('created_at','DESC')->get();
		return $result;		
	}

	public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
	
	public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'account_id', 'id');
    }
	
}






