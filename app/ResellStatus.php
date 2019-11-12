<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ResellStatus extends Model
{   
    protected $fillable = [   'name','color'    ];	
			
    protected $table = 'resell_status';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
}






