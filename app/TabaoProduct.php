<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TabaoProduct extends Model
{   
    protected $fillable = [   'id','pid','goodsId','title','dtitle','originalPrice','actualPrice','shopType','goldSellers','monthSales','twoHoursSales','dailySales','commissionType','desc','couponReceiveNum','couponLink','couponEndTime','couponStartTime','couponPrice','couponConditions','activityType','createTime','mainPic','marketingMainPic','sellerId','cid','discounts','commissionRate','couponTotalNum','haitao','activityStartTime','activityEndTime','shopName','shopLevel','descScore','brand','brandId','brandName','hotPush','teamName','itemLink','tchaoshi','detailPics','dsrScore','dsrPercent','shipScore','shipPercent','serviceScore','servicePercent','subcid','imgs','reimgs','tbcid'];	
			
    protected $table = 'taobao_collection_vouchers';	
	
	public static function getTableName()
    {
        return with(new static)->getTable();
    }
	
	
}






