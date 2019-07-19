<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeiXinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weixin', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('openid')->nullable();
            $table->string('nickname')->nullable();
            $table->string('sex')->nullable();
            $table->string('language')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('access_token')->nullable();
            $table->string('ticket')->nullable();
            $table->longtext('qrcode')->nullable();
            $table->longtext('headimgurl')->nullable();
            $table->longtext('response')->nullable();
            $table->longtext('response_qrcode')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weixin');
    }
}
