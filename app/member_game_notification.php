<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class member_game_notification extends Model
{
   
    protected $guard = 'member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	 protected $table  = 'member_game_notification';
	
}