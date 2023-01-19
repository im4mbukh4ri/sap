<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTablePpobPenalty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_pdam_penalty', function (Blueprint $table) {
            $table->dropColumn(['month_period','year_period']);
            $table->double('penalty',12,2);
            $table->double('misc_amount',12,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_pdam_penalty', function (Blueprint $table) {
            //
        });
    }
}
