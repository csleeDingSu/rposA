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
}






