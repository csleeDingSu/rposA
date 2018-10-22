<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class member_game_result extends Model
{
    protected $table = 'member_game_result';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
