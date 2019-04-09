<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Shareproduct extends Model
{
   
    protected $table = 'share_product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      
'voucher_name',
'category',
'subcategory',
'voucher_code',
'quantity',
'used_vouchers',
'view_impressions',
'expiry_datetime',
'product_name',
'product_picurl',
'product_detail_link',
'product_category',
'taobao_guest_link',
'product_price',
'month_sales',
'income_ratio',
'commision',
'seller_name',
'seller_id',
'seller_platform',
'voucher_id',
'available_voucher',
'current_available_voucher',
'coupon_denomination',
'voucher_starttime',
'voucher_expiry',
'voucher_link',
'product_voucher',
'ads_link',
'source_file',
'status',
'voucher_price',
'discount_ratio',
'discount_price',
'voucher_pass',
'pass_access_flag',
'is_featured',
'share_product',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
	
}