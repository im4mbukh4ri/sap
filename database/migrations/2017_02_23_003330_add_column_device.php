<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('airlines_transactions', function (Blueprint $table) {
            $table->string('device',20)->nullable();
        });
        Schema::table('ppob_transactions', function (Blueprint $table) {
            $table->string('device',20)->nullable();
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
