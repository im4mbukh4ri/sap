<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlinesBookingTransactionNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlines_booking_transaction_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airlines_booking_id')->unsigned();
            $table->string('transaction_number')->nullable();
            $table->timestamps();
            $table->foreign('airlines_booking_id')->references('id')->on('airlines_booking');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('airlines_booking_transaction_numbers');
    }
}
