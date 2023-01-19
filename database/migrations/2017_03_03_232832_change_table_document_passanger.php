<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableDocumentPassanger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_passengers', function (Blueprint $table) {
            //
	    $table->char('nationality_id',2);
	    $table->char('issued_country_id',2);
	    $table->foreign('nationality_id')->references('id')->on('countries');
	    $table->foreign('issued_country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_passangers', function (Blueprint $table) {
            //
        });
    }
}
