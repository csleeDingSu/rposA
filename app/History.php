<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Support\Filterable;
use Carbon\Carbon;



class History extends Model
{   
    protected $fillable = [        'member_id','credit_type','current_balance','before_life','current_life','debit','credit','notes','balance_before','balance_after','ledger_type','uuid','before_vip_life','current_vip_life','before_vip_point','current_vip_point','ref_id','ref_type','','','',''
    ];	
	
    protected $table = 'ledger_history';	
	
	public static function add_ledger_history($data)
	{
		$history = new History();	
		$history->fill($data);
		$history->uuid = $uuid = unique_numeric_random((new static)->getTable(), 'uuid', 15);			
		$history->save();
		return $uuid;
	}
	
	public static function get_summary($memberid,$type = 'buyproduct')
	{
		$result = \DB::table('new_summary_report');
		
		if ($type == 'buyproduct')
		{
			//$result = $result->where('type','<>','basicpackage');
		}
		elseif($type == 'basicpackage')
		{
			//$result = $result->where('type','<>','buyproduct');
		}
		$result = $result->where('member_id', $memberid)->get();
		return $result;		
	}
}






