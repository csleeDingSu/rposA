<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersWechatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('members_wechat');
        
        Schema::create('members_wechat', function ($t) {

            $t->bigIncrements('id');
            $t->string('member_id', 255)->nullable();
            $t->string('wechat_id', 255)->nullable();
            $t->string('qrcode', 255)->nullable();
            $t->longText('content')->nullable();
            $t->integer('status', 1)->nullable();
            $t->string('approved_by', 255)->nullable();
            $t->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $t->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP'));
            $t->string('checksum', 255)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_wechat');
    }
}
