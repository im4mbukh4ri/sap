<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_seats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wagon_code',10);
            $table->string('wagon_number',3);
            $table->string('seat',5);
        });
        Schema::create('train_passanger_seats',function(Blueprint $table){
          $table->integer('train_passanger_id')->unsigned();
          $table->integer('train_booking_id')->unsigned();
          $table->integer('train_seat_id')->unsigned();
          $table->foreign('train_passanger_id')->references('id')->on('train_passengers');
          $table->foreign('train_booking_id')->references('id')->on('train_bookings');
          $table->foreign('train_seat_id')->references('id')->on('train_seats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('train_passanger_seat');
        Schema::drop('train_seats');
    }
}
