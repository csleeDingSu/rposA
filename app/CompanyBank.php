<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class CompanyBank extends Model
{   
    
	protected $fillable = [
        'bank_detail', 'account_name', 'account_number', 'bank_name', 'phone', 'resell_point', 'name', 
    ];
	
	protected $columns = array('id');
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'company_bankaccount';
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
	
	public function member()
    {
        return $this->belongsTo(\App\Member::class, 'member_id', 'id');
    }
	
	
}