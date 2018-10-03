<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Category extends Model
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
    protected $table = 'category';
	
	
	 
	
	
}