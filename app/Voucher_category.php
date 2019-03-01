<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Voucher_category extends Model
{   
    
	
	
	protected $columns = array();
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'voucher_category';

    protected $primaryKey = 'id';

    protected $fillable = ['unr_voucher_id','category','voucher_id'];



    // public static function delete_tag($id)
	// {
    //     $result = DB::table('voucher_category') -> where('voucher_id', $id) ->delete($id);
				
	// 	return $result;
	// }





}