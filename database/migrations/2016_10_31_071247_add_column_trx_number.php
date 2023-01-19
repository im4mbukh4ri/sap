<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTrxNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_transactions', function (Blueprint $table) {
            //
            $table->string('id_transaction',20)->after('id')->comment('generate by system');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_transactions', function (Blueprint $table) {
            //
        });
    }
}
