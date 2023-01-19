<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnPpobServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_services', function (Blueprint $table) {
            //
            $table->boolean('status')->after('code')->default(1)->comment('status: 1=open , 0=close');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_services', function (Blueprint $table) {
            //
        });
    }
}
