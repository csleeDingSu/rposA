<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembersWechat extends Model
{
    protected $table = 'members_wechat';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
