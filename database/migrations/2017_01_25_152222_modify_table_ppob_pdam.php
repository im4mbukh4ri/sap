<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTablePpobPdam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_pdam', function (Blueprint $table) {
            //
            $table->dropColumn(['customer_address','info']);
            $table->string('period');
            $table->double('nominal',12,2);
            $table->double('admin',12,2);
            $table->string('ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_pdam', function (Blueprint $table) {
            //
        });
    }
}
