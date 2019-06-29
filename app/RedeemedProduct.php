<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class RedeemedProduct extends Model
{
   
    protected $table = 'buy_product_redeemed';
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