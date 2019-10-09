<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rank extends Model
{   
    protected $fillable = [   'member_id','game_id','account_id','rank','credit'    ];	
			
    protected $table = 'member_rank';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
}






