<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class view_buy_product_user_list extends Model
{
    protected $table = 'view_buy_product_user_list';

    protected $connection = 'mysql';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
