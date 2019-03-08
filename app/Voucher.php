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
		$result = DB::table('category')->select('id', 'parent_id','display_name')->get();
				
		return $result;
	}
	public static function get_maincategory()
	{
		$result = DB::table('category')->where('parent_id',0)->select('id','parent_id','display_name' )->get();
				
		return $result;
	}

	public static function get_subcategory($id)
	{
		$result = DB::table('category')->where('parent_id',$id)->select('id', 'parent_id','display_name' )->get();
				
		return $result;
	}

		public static function get_category_setting($id = null)
	{
		$result = DB::table('category')->where('id',$id)->first();
		
		return $result;
	}


	public static function delete_category_by_id($id)
	{
		$result = DB::table('category')->delete($id);
		return $result;
	}

	public static function delete_subcategory_by_id($id)
	{
		$result = DB::table('category')->delete($id);
		return $result;
	}
	public static function update_category_by_id($id, $data = [])
	{
		$result = DB::table('category')->where('id', $id)->update($data);
		return $result;
	}




	// public static function get_subcategory()
	// {
	// 	$result = DB::table('sub_category')->select('id', 'category', 'sub_category' )->get();
				
	// 	return $result;
	// }
	
	public static function tag_voucher($id, $data)
	{
		$result = DB::table('voucher_category')
		->where('unr_voucher_id', $id)
		->update($data);
		
		return $result;
	}

	public static function update_voucher_id($id, $voucher_id)
	{
        $ledger  = DB::table('voucher_category')
				   ->where('unr_voucher_id', $id)
				   ->update(['voucher_id' => $voucher_id]);
	}
	
	public static function get__unr_categorytag($id)
	{
		$result = DB::table('voucher_category')->where('unr_voucher_id', $id)-> select('unr_voucher_id', 'category')->get();
				
		return $result;
	}

	public static function get_categorytag($id)
	{
		$result = DB::table('voucher_category')->where('voucher_id', $id)-> select('voucher_id', 'category')->get();
				
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


	public static function get_voucher($id = null)
	{
		$result = DB::table('voucher')->where('id',$id)->first();
		
		return $result;
	}

	public static function get_vouchers($id = null)
	{
		$result = DB::table('voucher_category')->where('category',$id)->first();
		
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

	public static function vouchers_inserttag($chunk)
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