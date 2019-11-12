<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ViewCreditResell extends Model
{   
    protected $fillable = [    ];	
			
    protected $table    = 'view_credit_resell';	
	
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





