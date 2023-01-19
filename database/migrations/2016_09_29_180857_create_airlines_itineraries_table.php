<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlinesItinerariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlines_itineraries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('airlines_booking_id')->comment('FK to airlines_booking table');
            $table->string('pnr',8)->comment('Booking code from airlines');
            $table->boolean('leg')->comment('');
            $table->string('flight_number',6);
            $table->string('class',6);
            $table->char('std',3);
            $table->char('sta',3);
            $table->dateTime('etd');
            $table->dateTime('eta');
            $table->timestamps();
            $table->foreign('airlines_booking_id')->references('id')->on('airlines_booking')
                ->onUpdate('cascade');
            $table->foreign('std')->references('id')->on('airports')
                ->onUpdate('cascade');
            $table->foreign('sta')->references('id')->on('airports')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airlines_itineraries');
    }
}
