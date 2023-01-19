<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnPpobTransactions extends Migration
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
            $table->dropColumn(['nominal','transaction_number','ref_number','message','serv']);
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
