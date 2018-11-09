<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class tips extends Model
{
    protected $table = 'tips';

    protected $connection = 'mysql';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
