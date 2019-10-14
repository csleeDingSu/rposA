<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RankNew extends Model
{   
    protected $fillable = [   'member_id','game_id','rank','total_bet','win','lose'    ];
			
    protected $table = 'member_rank_new';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
}






