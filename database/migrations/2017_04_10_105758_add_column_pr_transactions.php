<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPrTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airlines_booking', function (Blueprint $table) {
            $table->double('pr',8,2)->default(0)->after('nra');
        });
        Schema::table('ppob_transactions', function (Blueprint $table) {
            $table->double('pr',8,2)->default(0)->after('nra');
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
