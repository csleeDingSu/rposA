<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Notification extends Model
{
   
    protected $table = 'notifications';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','title','notifiable_type','notifiable_id','data','read_at','created_at','updated_at'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	
	public function ledger()
    {
        return $this->belongsTo(History::class, 'notifiable_id', 'id');
    }
	
	public function member()
    {
        return $this->belongsTo(\App\Member::class, 'member_id', 'id');
    }
	
	public function scopewithMember($query,$phone = FALSE)
    {
        return $query->with('member')->where('phone', $phone);
    }
	
	
}