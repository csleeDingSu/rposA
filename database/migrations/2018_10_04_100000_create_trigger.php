<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER members_BEFORE_INSERT BEFORE INSERT ON `members` FOR EACH ROW
            BEGIN
                IF NEW.current_life IS NULL THEN
                    SET NEW.current_life = 3;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `members_BEFORE_INSERT`');   
    }
}
