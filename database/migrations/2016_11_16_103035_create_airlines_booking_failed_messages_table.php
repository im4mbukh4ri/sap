<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlinesBookingFailedMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlines_booking_failed_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airlines_booking_id')->unsigned();
            $table->text('message');
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
        Schema::drop('airlines_booking_failed_messages');
    }
}
