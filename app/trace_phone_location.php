<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class trace_phone_location extends Model
{
    protected $table = 'trace_phone_location';

    protected $connection = 'mysql';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
