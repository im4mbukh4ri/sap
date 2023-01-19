<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePpobCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppob_commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->double('nra',12,2);
            $table->double('pusat',12,2);
            $table->double('bv',12,2);
            $table->double('member',12,2);
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ppob_commissions');
    }
}
