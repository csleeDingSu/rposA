<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Draw extends Model
{
   
    protected $table = 'draw_result';
	public $consoleaction = '';
	public $cronid = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'game_id', 'result', 
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
}