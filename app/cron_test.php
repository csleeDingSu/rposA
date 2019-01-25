<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class cron_test extends Model
{
    protected $table = 'cron_test';

    protected $connection = 'mysql';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
