<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Receipt extends Model
{   
    protected $fillable = [ 'member_id','receipt','uuid'    ];	
			
    protected $table = 'receipt';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
	
	
	public function reason()
    {
        return $this->belongsTo(\App\Reason::class, 'reason_id' , 'id');
    }
		
	public function member()
    {
        return $this->belongsTo(\App\Member::class, 'member_id' , 'id');
    }
	
}






