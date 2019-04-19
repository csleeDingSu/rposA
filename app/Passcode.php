<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Passcode extends Model
{
   
    protected $table = 'passcode';
	public $consoleaction = '';
	public $cronid = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'goodsid', 'passcode',  'updated_at','goodsid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	public static function getcode($keyword)
	{
		return getcurl($keyword);
	}
	
}