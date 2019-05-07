<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpenDrawPreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('open_draw_pre', function ($t) {

            $t->bigIncrements('id');
            $t->longText('event_data')->nullable();
            $t->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $t->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP'));
            $t->timestamp('deleted_at')->nullable(); 

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('open_draw_pre');
    }
}
