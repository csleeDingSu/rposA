<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MemberLedger extends Authenticatable
{
    use Notifiable;

    protected $guard = 'member_ledger';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'current_balance','current_point','current_betting','current_life'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
	
	
	protected $table = 'mainledger';
}