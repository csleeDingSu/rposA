<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_status', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('name',45)->nullable();
            $table->string('description')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        DB::insert('insert into ref_status (`name`, `description`, `value`) values (?,?,?)', array('pending', 'pending', 0));
        DB::insert('insert into ref_status (`name`, `description`, `value`) values (?,?,?)', array('approved', 'approved', 1));
        DB::insert('insert into ref_status (`name`, `description`, `value`) values (?,?,?)', array('rejected', 'rejected', -1));
        DB::insert('insert into ref_status (`name`, `description`, `value`) values (?,?,?)', array('kiv', 'keep in view', 99));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_status');
    }
}
