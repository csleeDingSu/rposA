<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('pay_orderid')->nullable();
            $table->string('pay_amount')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('pay_response_amount')->nullable();
            $table->string('pay_final_amount')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('trade_state')->nullable();
            $table->longtext('pay_params')->nullable();
            $table->longtext('pay_response')->nullable();
            $table->longtext('query_response')->nullable();
            $table->longtext('callback_response')->nullable();
            $table->longtext('notify_response')->nullable();
            $table->longtext('redirect_response')->nullable();
            $table->longtext('qrcode_response')->nullable();
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
        Schema::dropIfExists('payment_transaction');
    }
}
