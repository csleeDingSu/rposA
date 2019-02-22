<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Redis extends Model
{
    protected $table = 'redis';

    protected $connection = 'mysql';

    protected $fillable = ['member_id'];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
