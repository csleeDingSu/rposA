<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RejectedResell extends Model
{   
    protected $fillable = [   'member_id','point','amount','status_id'  ,'image','passcode','buyer_id','is_locked','locked_time','reason','barcode','type','ledger_history_id','buyer_name','is_autobuy' ];

			
    protected $table    = 'credit_resell_rejected';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function member()
    {
        return $this->belongsTo(\App\Member::class, 'member_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(\App\Member::class, 'buyer_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(\App\ResellStatus::class, 'status_id', 'id');
    }
}





