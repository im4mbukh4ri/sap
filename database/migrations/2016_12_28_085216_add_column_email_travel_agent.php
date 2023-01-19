<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEmailTravelAgent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travel_agents', function (Blueprint $table) {
            $table->string('email',100)->nullable()->after('name')->comment('Email travel agent');
            $table->string('url_logo',100)->nullable()->after('email')->comment('Travel logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travel_agents', function (Blueprint $table) {
            //
            $table->dropColumn('email');
            $table->dropColumn('url_logo');
        });
    }
}
