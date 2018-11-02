<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class redeemed extends Model
{
    protected $table = 'redeemed';

    protected $connection = 'mysql';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
