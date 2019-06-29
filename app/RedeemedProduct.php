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

    public function order_detail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_id', 'id');
    }

    public function neworder_detail()
    {
        //return $this->belongsToMany(OrderDetail::class, 'id', 'order_id');

       // return $this->belongsToMany(OrderDetail::class, 'order_id', 'id');

        return $this->morphTo(OrderDetail::class, 'id', 'order_id');

        
    }

    public function shipping_detail()
    {
        return $this->belongsTo(ShippingDetail::class, 'order_id', 'id');
    }
	
		
}