<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUplineCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airlines_commissions', function (Blueprint $table) {
            //
            $table->double('upline',12,2)->default(0)->after('member');
        });
        Schema::table('ppob_commissions', function (Blueprint $table) {
            //
            $table->double('upline',12,2)->default(0)->after('member');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('airlines_commissions', function (Blueprint $table) {
            //
        });
    }
}
