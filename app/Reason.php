<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reason extends Model
{   
    protected $fillable = [ 'name'    ];	
			
    protected $table = 'receipt_reason';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
	
}






