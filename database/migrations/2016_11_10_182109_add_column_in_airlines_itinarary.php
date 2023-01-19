<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInAirlinesItinarary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airlines_itineraries', function (Blueprint $table) {
            //
            //$table->char('depart_return_id',1)->after('pnr');
            $table->foreign('depart_return_id')->references('id')->on('depart_return');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('airlines_itineraries', function (Blueprint $table) {
            //
            $table->dropForeign('airlines_itineraries_depart_return_id_foreign');
        });
    }
}
