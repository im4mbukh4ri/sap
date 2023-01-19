<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTablePpobBpjs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_bpjs', function (Blueprint $table) {
            //$table->dropColumn(['number_va','status','response']);
            $table->double('admin',12,2);
            $table->double('nominal',12,2);
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
        Schema::table('ppob_bpjs', function (Blueprint $table) {
            //
        });
    }
}
