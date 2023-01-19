<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRailinkStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('railink_stations', function (Blueprint $table) {
          $table->char('id',3)->primary();
          $table->string('name')->comment('Station name');
          $table->string('city')->comment('Station city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('railink_stations');
    }
}
