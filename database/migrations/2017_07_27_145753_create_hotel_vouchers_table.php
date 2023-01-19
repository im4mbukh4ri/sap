<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_transaction_id')->unsigned();
            $table->string('transaction_number',100)->nullable();
            $table->string('res',100)->nullable();
            $table->string('voucher',100)->nullable();
            $table->foreign('hotel_transaction_id')->references('id')->on('hotel_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotel_vouchers');
    }
}
