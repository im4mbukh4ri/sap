<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlinesCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlines_commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('airlines_booking_id');
            $table->double('nra',12,2);
            $table->double('pusat',12,2);
            $table->double('bv',12,2);
            $table->double('member',12,2);
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
        Schema::drop('airlines_commissions');
    }
}
