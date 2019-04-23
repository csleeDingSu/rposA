<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Bonuslife extends Model
{
   
    protected $table = 'bonus_life_count';
	public $consoleaction = '';
	public $cronid = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'introduce_bonus_life', 'second_level_bonus_life',  'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
		
}