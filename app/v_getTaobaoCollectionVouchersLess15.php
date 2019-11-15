<?php namespace App;

use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\SoftDeletes;

class v_getTaobaoCollectionVouchersLess15 extends Model
{
    // use SoftDeletes;

    protected $table = 'v_getTaobaoCollectionVouchersLess15';

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
