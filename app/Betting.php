<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Betting extends Model
{   
    protected $fillable = [  ];	
			
    protected $table = 'view_betting';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
}






