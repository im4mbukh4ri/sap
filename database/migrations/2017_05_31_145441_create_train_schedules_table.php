<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('train_name');
            $table->string('train_number');
            $table->char('origin',3);
            $table->char('destination',3);
            $table->timestamp('etd');
            $table->timestamp('eta');
            $table->foreign('origin')->references('code')->on('stations');
            $table->foreign('destination')->references('code')->on('stations');
        });
        Schema::create('train_schedule_fares',function(Blueprint $table){
          $table->bigInteger('id')->unsigned();
          $table->timestamps();
          $table->integer('train_schedule_id')->unsigned();
          $table->string('class',15);
          $table->string('subclass',15);
          $table->tinyInteger('seat_avb');
          $table->double('total_fare',12,2)->default(0);
          $table->double('price_adt',12,2)->default(0);
          $table->double('price_chd',12,2)->default(0);
          $table->double('price_inf',12,2)->default(0);
          $table->primary('id');
          $table->foreign('train_schedule_id')->references('id')->on('train_schedules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('train_schedules');
    }
}
