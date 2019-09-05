<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class History extends Model
{   
    protected $fillable = [        'member_id','game_id','account_id','debit','credit','notes','balance_before','balance_after','ledger_type','uuid',
    ];	
			
    protected $table = 'ledger_history_new';	
	
	public static function add_ledger_history($data)
	{
		$history = new History();	
		$history->fill($data);
		$history->uuid = $uuid = unique_numeric_random((new static)->getTable(), 'uuid', 15);			
		$history->save();
		return $uuid;
	}	
}






