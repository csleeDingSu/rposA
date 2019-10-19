<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class CompanyBank extends Model
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
    protected $table = 'company_bankaccount';
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
	
	 
	
	
}