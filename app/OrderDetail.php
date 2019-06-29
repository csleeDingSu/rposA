<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrderDetail extends Model
{
   
    protected $table = 'order_details';
	public $consoleaction = '';
	public $cronid = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
		
}