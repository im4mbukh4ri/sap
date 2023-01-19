<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlainesBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlines_codes',function (Blueprint $table){
            $table->char('code',2)->primary()->comment('code of airlines');
            $table->string('name')->comment('Name of airlines');
        });
        Schema::create('airlines_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airlines_transaction_id')->unsigned()->comment('FK to table airlines_transactions');
            $table->char('flight_type',1)->comment('o= one way, r= return');
            $table->string('pnr',8)->comment('Booking code from airlines');
            $table->char('airlines_code',2)->comment('Airlines code, FK to airlines_codes table');
            $table->char('origin',3)->comment('Origin airport');
            $table->char('destination',3)->comment('Destination airport');
            $table->dateTime('departure')->comment('departure time, etimation on schedule');
            $table->dateTime('arrived')->comment('arrived time, estimation on schedule');
            $table->double('paxpaid',12,2)->comment('Fare base per flight / Paxpaid ?');
            $table->string('status',20)->default('waiting-isued')->comment('Status transaction');
            $table->double('nta',12,2)->comment('NTA');
            $table->double('nra',12,2)->comment('NRA');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('airlines_transaction_id')->references('id')->on('airlines_transactions')
                ->onUpdate('cascade');
            $table->foreign('origin')->references('id')->on('airports')
                ->onUpdate('cascade');
            $table->foreign('destination')->references('id')->on('airports')
                ->onUpdate('cascade');
            $table->foreign('flight_type')->references('id')->on('flight_types')
                ->onUpdate('cascade');
            $table->foreign('airlines_code')->references('code')->on('airlines_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airlines_booking');
        Schema::dropIfExists('airlines_codes');
    }
}
