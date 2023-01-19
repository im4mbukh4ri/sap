<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTablePpobPlnPra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_pln_pra', function (Blueprint $table) {
            //
            //$table->dropColumn(['category','data','status']);
            $table->string('golongan_daya',20);
            $table->double('nominal',12,2);
            $table->double('rp_token',12,2);
            $table->double('admin',12,2);
            $table->double('ppn',12,2);
            $table->double('ppj',12,2);
            $table->double('materai',12,2);
            $table->string('token');
            $table->string('reff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_pln_pra', function (Blueprint $table) {

        });
    }
}
