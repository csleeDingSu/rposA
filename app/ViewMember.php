<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Support\Filterable;


class ViewMember extends Model
{   
    protected $fillable = [       
    ];	
	
    protected $table = 'view_members';	
	
	public function parentuser()
	{
		return $this->belongsTo('App\Member','referred_by','id');
	}
}






