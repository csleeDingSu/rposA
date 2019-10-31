<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CreditResell extends Model
{   
    protected $fillable = [   'member_id','amount','status_id' ,'barcode','image','point'  ];	
			
    protected $table    = 'ViewCreditResell';	
	
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





