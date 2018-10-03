<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Unreleasedvouchers extends Model
{   
    
	protected $fillable = [
       'id', 'name',  'type', 'extension', 'uid'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'unreleased_vouchers';
	
	
	public function get_unreleased_vouchers($id = 0)
	{
		$record = DB::table('unreleased_vouchers')->where('id', $id)->first();
		return $record;
	}
	public function getfile($file = 0)
	{
		$record = DB::table('unreleased_vouchers')->where('source_file', $file)->first();
		return $record;
	}
	
	public function publish_voucher($file)
	{
		
		
	}
	
	public static function check_duplicate($type = 'voucher_id')
	{
		$result = DB::select("SELECT count(1) AS duplicate_count
FROM (
 SELECT $type FROM unreleased_vouchers
 GROUP BY $type HAVING COUNT($type) > 1
) AS t");
		
		return $result;
		
	}
	
	public static function remove_duplicate($type = 'voucher_id')
	{
		$result = DB::select("DELETE n1 FROM unreleased_vouchers n1, unreleased_vouchers n2 WHERE n1.id > n2.id AND n1.$type= n2.$type");
		return TRUE;
	}
	
	
}