<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Alipay extends Model
{   
    protected $fillable = [  ];	
			
    protected $table = 'alipay';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function member()
    {
        return $this->belongsTo(\App\Member::class, 'member_id', 'id');
    }
}






