<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignUserIdHistoryDeposit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_deposits', function (Blueprint $table) {
            //
            //$table->integer('user_id')->unsigned()->change();
            //$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_deposits', function (Blueprint $table) {
            //
            //$table->dropForeign('history_deposits_user_id_foreign');
        });
    }
}
