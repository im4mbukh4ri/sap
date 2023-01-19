<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnKomisiFreePpob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_commissions', function (Blueprint $table) {
            $table->double('komisi',12,2)->after('nra');
            $table->double('free',12,2)->after('komisi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_commissions', function (Blueprint $table) {
            //
        });
    }
}
