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

    public function product()
    {
        return $this->morphTo(BuyProduct::class, 'product_id', 'id');
        return $this->belongsTo(BuyProduct::class, 'product_id', 'id');
    }

    public function order_detail()
    {
        return $this->hasmany(OrderDetail::class, 'order_id', 'id');
    }

    public function neworder_detail()
    {
        return $this->hasmany(OrderDetail::class, 'order_id', 'id');

        return $this->hasmany(OrderDetail::class, 'id', 'order_id');

       // return $this->belongsToMany(OrderDetail::class, 'order_id', 'id');

        return $this->morphTo(OrderDetail::class, 'order_id', 'id');

        
    }

    public function shipping_detail()
    {
        return $this->hasmany(ShippingDetail::class, 'order_id', 'id');
    }
	
		
}