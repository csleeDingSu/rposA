<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class OpenDrawPre extends Model
{
    use SoftDeletes;

    protected $table = 'open_draw_pre';

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
