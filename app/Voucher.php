<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Voucher extends Model
{   
    
	protected $fillable = [
       'id', 
    ];
	
	protected $columns = array('id');
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'vouchers';
	
	public function scopeExclude($query,$value = array()) 
	{
		return $query->select( array_diff( $this->columns,(array) $value) );
	}
	
	public static function get_game($id)
	{
		$result = DB::table('games')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function get_csvtitle($limit = 5)
	{
		$result = DB::table('csv_title')->where('category','voucher')->select('id', 'title', 'is_mandatory')->get($limit);
				
		return $result;
	}
	
	public static function get_category()
	{
		$result = DB::table('category')->select('id', 'display_name')->get();
				
		return $result;
	}
	
	public static function delete_excel_upload($filename)
	{
		$result = DB::table('excel_upload')->where('filename', $filename)->delete();
				
		return $result;
	}
	
	public static function QueuedList($filename)
	{
		//$result = DB::table('excel_upload')->select('sys_field_id', 'file_title_loc_id')->where('filename', $filename)->get(3);
		$result = DB::table('excel_upload')->select('sys_field_id', 'file_title_loc_id')->where('filename', $filename)->get();
			
		return $result;
	}
	public static function check_duplicate($type = 'voucher_id')
	{
		$result = DB::select("SELECT count(1) AS duplicate_count
		FROM (
		 SELECT $type FROM vouchers
		 GROUP BY $type HAVING COUNT($type) > 1
		) AS t");
		
		return $result;
		
	}
	
	public static function remove_duplicate($type = 'voucher_id')
	{
		$result = DB::select("DELETE n1 FROM vouchers n1, vouchers n2 WHERE n1.id > n2.id AND n1.$type= n2.$type");
		return TRUE;
	}
	public function search($request)
	{
		if ($filters->has('name')) {
            $user->where('name', $filters->input('name'));
        }
	}
	public static function vouchers_insert($chunk)
	{
		//DB::insert($chunk->toArray());
		DB::table('vouchers')->insert($chunk->toArray());
	}
	public static function archived_vouchers_insert($chunk)
	{
		//$ddd = $chunk->toArray();
		//print_r($ddd);die();
		DB::table('archived_vouchers')->insert($chunk->toArray());
	}
	 
	public static function get_voucher_withoutpass($table = 'vouchers', $limit = 5)
	{	
        $result = DB::table($table)->where('pass_access_flag','0')->select('id', 'product_detail_link', 'pass_access_flag')->limit($limit)->get($limit);
		return $result;
	}
    
    public static function update_voucher($table = 'vouchers', $id, $data)
	{
        $ledger  = DB::table($table)
				   ->where('id', $id)
				   ->update($data);
    }
	
}