<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WalletHistory extends Model
{   
    protected $fillable = [        'member_id','game_id','account_id','debit','credit','notes','balance_before','balance_after','ledger_type','uuid','is_batched',
    ];	
			
    protected $table = 'ledger_history';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }

}






