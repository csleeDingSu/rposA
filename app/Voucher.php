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
		$result = DB::table('csv_title')->select('id', 'title')->get($limit);
				
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
	
	public function search($request)
	{
		if ($filters->has('name')) {
            $user->where('name', $filters->input('name'));
        }
	}
	public static function archived_vouchers_insert($chunk)
	{
		//$ddd = $chunk->toArray();
		//print_r($ddd);die();
		DB::table('archived_vouchers')->insert($chunk->toArray());
	}
	 
	
	
}