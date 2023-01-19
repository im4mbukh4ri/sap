<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnServicePpobTransactions extends Migration
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
            $table->unsignedSmallInteger('service')->after('user_id');
            $table->foreign('service')->references('id')->on('ppob_services');
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
