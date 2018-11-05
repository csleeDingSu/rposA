<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Admin extends Model
{
   
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	
	
	public static function get_setting()
	{
		$result = DB::table('settings')->first();
		
		return $result;
	}
	public static function update_setting($id,$data)
	{	
		
		 return $result = DB::table('settings')
            ->where('id', $id)
            ->update($data);
	}
	
	public static function list_faq()
	{
		$result = DB::table('faq')->get();
		
		return $result;
	}
	public static function get_faq($id = null)
	{
		$result = DB::table('faq')->where('id',$id)->first();
		
		return $result;
	}
	public static function create_faq($data)
	{	
		
		 return $result = DB::table('faq')
            ->insertGetId($data);
	}
	public static function update_faq($id,$data)
	{	
		
		 return $result = DB::table('faq')
            ->where('id', $id)
            ->update($data);
	}
	public static function delete_faq($id)
	{			
		 return DB::table('faq')->delete($id);
	}
	
}