<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class ShippingDetail extends Model
{
   
    protected $table = 'shipping_details';
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