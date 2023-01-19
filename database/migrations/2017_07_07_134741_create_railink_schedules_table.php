<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRailinkSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('railink_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('train_name');
            $table->string('train_number');
            $table->char('origin',3);
            $table->char('destination',3);
            $table->timestamp('etd');
            $table->timestamp('eta');
            $table->foreign('origin')->references('code')->on('railink_stations');
            $table->foreign('destination')->references('code')->on('railink_stations');
        });
        Schema::create('railink_schedule_fares',function(Blueprint $table){
          $table->bigInteger('id')->unsigned();
          $table->timestamps();
          $table->integer('railink_schedule_id')->unsigned();
          $table->string('class',15);
          $table->string('subclass',15);
          $table->tinyInteger('seat_avb');
          $table->double('total_fare',12,2)->default(0);
          $table->double('price_adt',12,2)->default(0);
          $table->double('price_chd',12,2)->default(0);
          $table->double('price_inf',12,2)->default(0);
          $table->primary('id');
          $table->foreign('railink_schedule_id')->references('id')->on('railink_schedules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('railink_schedules');
    }
}
