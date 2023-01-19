<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNumberSavedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_saveds', function (Blueprint $table) {
            $table->integer('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->smallInteger('service')->unsigned();
            $table->smallInteger('ppob_service_id')->unsigned();
            $table->string('name',50)->nullable();
            $table->string('number',50);
            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('service')->references('id')->on('ppob_services');
            $table->foreign('ppob_service_id')->references('id')->on('ppob_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('number_saveds');
    }
}
