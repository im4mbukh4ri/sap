<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyColumnPpobPlnPasca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_pln_pasca', function (Blueprint $table) {
            //
            $table->string('golongan_daya',20);
            $table->double('nominal',12,2);
            $table->double('admin',12,2);
            $table->string('stand_meter');
            $table->string('period');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_pln_pasca', function (Blueprint $table) {

        });
    }
}
