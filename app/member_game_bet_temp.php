<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class member_game_bet_temp extends Model
{
    protected $table = 'member_game_bet_temp';

    protected $connection = 'mysql';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
