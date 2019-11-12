<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class CompanyAccount extends Model
{   
    
	protected $fillable = [
       'id', 
    ];
	
	protected $columns = array('id');
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'company_account';
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
	
	public function member()
    {
        return $this->belongsTo(\App\Member::class, 'member_id', 'id');
    }
	
	
}