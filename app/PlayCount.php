<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PlayCount extends Model
{
   
    protected $guard = 'admin';
	
	protected $table = 'member_play_count';
	public $consoleaction = '';
	public $cronid = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at', 'play_date', 'member_id', 'game_id','play_count','result_status', 'updated_at',
    ];
	

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	
}