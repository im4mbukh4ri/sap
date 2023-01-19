<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_agents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('FK to users table');
            $table->string('name')->nullable()->comment('Name of travel agent');
            $table->unsignedInteger('address_id')->comment('FK to addresses table');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')
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
        Schema::dropIfExists('travel_agents');
    }
}
