<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class LedgerType extends Model
{
   
    protected $table = 'ledger_types';
	public $consoleaction = '';
	public $cronid = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'type', 'name',  'status','updated_at',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	
	public static function ledger_types()
	{
		return $this->belongsTo('App\User');
	}
}