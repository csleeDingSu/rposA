<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ad_display extends Model
{
    protected $table = 'ad_display';

    protected $connection = 'mysql2';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
