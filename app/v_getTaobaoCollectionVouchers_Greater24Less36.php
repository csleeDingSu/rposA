<?php namespace App;

use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\SoftDeletes;

class v_getTaobaoCollectionVouchers_Greater24Less36 extends Model
{
    // use SoftDeletes;

    protected $table = 'v_getTaobaoCollectionVouchers_Greater24Less36';

    protected $softDelete = true;

    protected $connection = 'mysql';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
