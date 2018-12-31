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
	
	public static function list_tips()
	{
		$result = DB::table('tips')->get();
		
		return $result;
	}
	public static function get_tips($id = null)
	{
		$result = DB::table('tips')->where('id',$id)->first();
		
		return $result;
	}
	public static function create_tips($data)
	{	
		
		 return $result = DB::table('tips')
            ->insertGetId($data);
	}
	public static function update_tips($id,$data)
	{	
		
		 return $result = DB::table('tips')
            ->where('id', $id)
            ->update($data);
	}
	public static function delete_tips($id)
	{			
		 return DB::table('tips')->delete($id);
	}
	
	public static function list_banner()
	{
		$result = DB::table('banner')->get();
		
		return $result;
	}
	public static function get_banner($id = null)
	{
		$result = DB::table('banner')->where('id',$id)->first();
		
		return $result;
	}
	public static function create_banner($data)
	{	
		
		 return $result = DB::table('banner')
            ->insertGetId($data);
	}
	public static function update_banner($id,$data)
	{	
		
		 return $result = DB::table('banner')
            ->where('id', $id)
            ->update($data);
	}
	public static function delete_banner($id)
	{			
		 return DB::table('banner')->delete($id);
	}
	
	public static function list_redeem_condition()
	{
		$result = DB::table('redeem_condition')->get();
		
		return $result;
	}
	public static function get_redeem_condition($id = null)
	{
		$result = DB::table('redeem_condition')->where('id',$id)->first();
		
		return $result;
	}
	public static function create_redeem_condition($data)
	{	
		
		 return $result = DB::table('redeem_condition')
            ->insertGetId($data);
	}
	public static function update_redeem_condition($id,$data)
	{	
		
		 return $result = DB::table('redeem_condition')
            ->where('id', $id)
            ->update($data);
	}
	public static function delete_redeem_condition($id)
	{			
		 return DB::table('redeem_condition')->delete($id);
	}
	
	public static function check_redeem_condition($seq = FALSE)
	{			
		if (!$seq) $seq = 1;
		
		$result = DB::table('redeem_condition')->where('position',$seq)->first();
		DB::enableQueryLog();
		//if (!$result) 
			$result = DB::table('redeem_condition')->max('position');
		print_r(DB::getQueryLog());     
		return $result;
	}
	
}