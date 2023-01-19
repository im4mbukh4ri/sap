<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSipBankId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_deposits', function (Blueprint $table) {
            //
            $table->dropColumn('received_bank');
            $table->integer('sip_bank_id')->unsigned()->after('user_id');
            $table->foreign('sip_bank_id')->references('id')->on('sip_banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_deposits', function (Blueprint $table) {
            //
        });
    }
}
