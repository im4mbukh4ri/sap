<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnFlightType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airlines_transactions', function (Blueprint $table) {
            //
            $table->dropForeign('airlines_transactions_flight_type_foreign');
            $table->renameColumn('flight_type','trip_type_id');
            $table->foreign('trip_type_id')->references('id')->on('trip_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('airlines_transactions', function (Blueprint $table) {
            //
        });
    }
}
