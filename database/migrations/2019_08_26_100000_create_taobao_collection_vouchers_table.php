<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaobaoCollectionVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('taobao_collection_vouchers', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->bigInteger('pid',11)->nullable();
            $table->bigInteger('goodsId',11)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('dtitle', 255)->nullable();
            $table->string('originalPrice', 11)->nullable();
            $table->string('actualPrice',11)->nullable();
            $table->string('shopType',11)->nullable();
            $table->string('goldSellers',11)->nullable();
            $table->string('monthSales',11)->nullable();
            $table->string('twoHoursSales',11)->nullable();
            $table->string('dailySales',11)->nullable();
            $table->string('commissionType',11)->nullable();
            $table->longtext('desc')->nullable();
            $table->string('couponReceiveNum',11)->nullable();
            $table->longtext('couponLink',11)->nullable();
            $table->string('couponEndTime',11)->nullable();
            $table->string('couponStartTime',11)->nullable();
            $table->string('couponPrice',11)->nullable();
            $table->string('couponConditions',11)->nullable();
            $table->string('activityType',11)->nullable();
            $table->string('createTime',11)->nullable();
            $table->longtext('mainPic')->nullable();
            $table->longtext('marketingMainPic')->nullable();
            $table->string('sellerId',11)->nullable();
            $table->string('cid',11)->nullable();
            $table->string('discounts',11)->nullable();
            $table->string('commissionRate',11)->nullable();
            $table->string('couponTotalNum',11)->nullable();
            $table->string('haitao',11)->nullable();
            $table->string('activityStartTime',11)->nullable();
            $table->string('activityEndTime',11)->nullable();
            $table->string('shopName',255)->nullable();
            $table->string('shopLevel',11)->nullable();
            $table->string('descScore',11)->nullable();
            $table->string('brand',11)->nullable();
            $table->string('brandId',11)->nullable();
            $table->string('brandName',255)->nullable();
            $table->string('hotPush',11)->nullable();
            $table->string('teamName',11)->nullable();
            $table->string('itemLink',11)->nullable();
            $table->string('tchaoshi',11)->nullable();
            $table->longtext('detailPics')->nullable();
            $table->string('dsrScore',11)->nullable();
            $table->string('dsrPercent',11)->nullable();
            $table->string('shipScore',11)->nullable();
            $table->string('shipPercent',11)->nullable();
            $table->string('serviceScore',11)->nullable();
            $table->string('servicePercent',11)->nullable();
            $table->longtext('subcid')->nullable();
            $table->longtext('imgs')->nullable();
            $table->string('reimgs',255)->nullable();
            $table->string('tbcid',11)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable(); 
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taobao_collection_vouchers');
    }
}
