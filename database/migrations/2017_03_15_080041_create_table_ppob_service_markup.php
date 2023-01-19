<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePpobServiceMarkup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppob_service_markups', function (Blueprint $table) {
            $table->smallInteger('ppob_service_id')->unsigned();
            $table->integer('idr_markup_id')->unsigned();
            $table->foreign('ppob_service_id')->references('id')->on('ppob_services');
            $table->foreign('idr_markup_id')->references('id')->on('idr_markups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ppob_service_markups');
    }
}
