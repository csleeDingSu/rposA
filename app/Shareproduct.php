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
      
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
	
}