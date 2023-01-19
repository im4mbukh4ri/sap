<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatusAirlinesCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airlines_codes', function (Blueprint $table) {
            //
            $table->boolean('status')->default(1)->comment('1 : OPEN , 0 : CLOSE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('airlines_codes', function (Blueprint $table) {
            //
        });
    }
}
