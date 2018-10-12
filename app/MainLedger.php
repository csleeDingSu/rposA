<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainLedger extends Model
{
    protected $table = 'mainledger';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
