<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ResellHistory extends Model
{   
    protected $fillable = [ 'cid','status_id','amount'  ];	
			
    protected $table = 'resell_history';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function status()
    {
        return $this->belongsTo(\App\ResellStatus::class, 'status_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(\App\Member::class, 'buyer_id', 'id');
    }
}






