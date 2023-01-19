<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTableFlightType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('airlines_transactions',function(Blueprint $table){
          $table->dropForeign('airlines_transactions_flight_type_id_foreign');
          $table->renameColumn('flight_type_id','flight_type');
        });

        Schema::rename('flight_types','trip_types');

        Schema::table('airlines_transactions',function(Blueprint $table){
          $table->foreign('flight_type')->references('id')->on('trip_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
