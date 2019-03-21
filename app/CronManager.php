<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class CronManager extends Model
{
   
    protected $guard = 'admin';
	
	protected $table = 'cron_manager';
	public $consoleaction = '';
	public $cronid = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cron_name', 'status', 'last_run', 'unix_last_run', 'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	
	public static function cron($id, $action)
	{
		$consoleaction = 'cron:dispatch';
		$argvm = [];
		$cron = CronManager::find($id);
		if ($cron)
		{
			
			switch($cron->cron_name)
			{				
				case 'voucher_update_pass':
					$argvm = ['type'=> 'voucher_update_pass'];
					break;
				case 'unreleasedvoucher_update_pass':
					$argvm = ['type'=> 'unreleasedvoucher_update_pass'];
					break;						
			}
			
			//Only cron will inititate if its already stoped.
			if ($action == 4)
			{				
				if ($cron->status == 3)
				{
					\Artisan::call($consoleaction,$argvm);
					$action = 1;
				}
				else return '99';
			}
			$cron->update(array("status" => $action));
			return $action;
		}
		return '99';
	}
	
	public static function getcron($type = FALSE)
	{
		$cron = [];
		switch($type)
		{
			case 'voucher_update_pass':
				$cron['name']   = 'voucher_update_pass';
				$cron['limit']  = 100;
				$cron['action'] = 'generate:vpass';
				$cron['argvm']  = ['type'=> 'vo'];
			break;
			case 'unreleasedvoucher_update_pass':
				$cron['name']   = 'unreleasedvoucher_update_pass';
				$cron['limit']  = 100;
				$cron['action'] = 'generate:vpass';
				$cron['argvm']  = ['type'=> 'uv'];
			break;		
		}
		return $cron;
	}
	
	
	
}