<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTablePpobPhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_phones', function (Blueprint $table) {
            //
            $table->dropColumn(['phone','code_area','code_divre','code_datel']);
            $table->double('nominal',12,2);
            $table->double('admin',12,2);
            $table->string('ref');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_phones', function (Blueprint $table) {
            //
        });
    }
}
