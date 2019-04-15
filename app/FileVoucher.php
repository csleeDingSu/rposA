<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class FileVoucher extends Model
{
   
    protected $table = 'voucher_files';
	public $consoleaction = '';
	public $cronid = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name', 'status',  'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
		
}