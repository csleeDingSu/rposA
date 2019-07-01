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
    protected $fillable = [ 'order_id','shipping_method','address','unit_detail','city','zip',
						    'country','tracking_number','notes','tracking_partner','contact_numer',
						    'alternative_contact_number','receiver_name'
						  ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
		
}