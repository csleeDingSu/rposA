<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $table = 'share';

    protected $fillable = ['name','filename','status'];

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at'];

	public function scopeStatus($query, string $status) 
	{
      return $query->where('status', $status);
    }	
}
