<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassengerPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passenger_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('passenger_id')->unsigned();
            $table->string('phone',15);
            $table->foreign('passenger_id')->references('id')->on('passengers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('passenger_phones');
    }
}
