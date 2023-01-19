<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnTicketDeposits extends Migration
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
            $table->double('nominal_request',12,2)->after('user_id');
            $table->double('unique_code',6,2)->after('nominal_request');
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
