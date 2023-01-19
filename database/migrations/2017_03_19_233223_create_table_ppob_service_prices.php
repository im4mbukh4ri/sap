<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePpobServicePrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppob_service_prices', function (Blueprint $table) {
            $table->smallInteger('ppob_service_id')->unsigned();
            $table->integer('idr_price_id')->unsigned();
            $table->foreign('ppob_service_id')->references('id')->on('ppob_services');
            $table->foreign('idr_price_id')->references('id')->on('idr_prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ppob_service_prices');
    }
}
