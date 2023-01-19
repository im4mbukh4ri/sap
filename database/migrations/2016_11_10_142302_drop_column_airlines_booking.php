<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnAirlinesBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airlines_booking', function (Blueprint $table) {
            //
            $table->dropForeign('airlines_booking_flight_type_foreign');
            $table->dropColumn('flight_type');
            $table->dropColumn('departure');
            $table->dropColumn('arrived');
            $table->dropColumn('pnr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('airlines_booking', function (Blueprint $table) {
            //
        });
    }
}
