<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracePhoneLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('trace_phone_location', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('isp', 255)->nullable();
            $table->string('province', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('postcode',255)->nullable();
            $table->string('citycode',255)->nullable();
            $table->string('areacode',255)->nullable();
            $table->string('status',255)->nullable();
            $table->string('mobile',255)->nullable();
            $table->string('memberid',255)->nullable();
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
        Schema::dropIfExists('trace_phone_location');
    }
}
