<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_passengers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment("Name of train passenger");
            $table->string('identity_number')->comment('Number of identity.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('train_passengers');
    }
}
