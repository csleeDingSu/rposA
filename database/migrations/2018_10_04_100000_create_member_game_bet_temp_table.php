<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberGameBetTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('member_game_bet_temp', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('gameid',11)->nullable();
            $table->string('memberid',11)->nullable();
            $table->string('drawid',11)->nullable();
            $table->string('bet')->nullable();
            $table->string('betamt')->nullable();
            $table->string('level')->nullable();
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
        Schema::dropIfExists('member_game_bet_temp');
    }
}
