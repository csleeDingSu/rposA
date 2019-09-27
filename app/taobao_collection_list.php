<?php namespace App;

use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\SoftDeletes;

class taobao_collection_list extends Model
{
    // use SoftDeletes;

    protected $table = 'taobao_collection_list';

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
