<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePpobServiceCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppob_service_commissions', function (Blueprint $table) {
            //
            $table->smallInteger('ppob_service_id')->unsigned();
            $table->integer('idr_commission_id')->unsigned();
            $table->foreign('ppob_service_id')->references('id')->on('ppob_services');
            $table->foreign('idr_commission_id')->references('id')->on('idr_commissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_service_commissions', function (Blueprint $table) {
            //
        });
    }
}
