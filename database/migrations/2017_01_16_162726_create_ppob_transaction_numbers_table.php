<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePpobTransactionNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppob_transaction_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->string('transaction_number');
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
        Schema::drop('ppob_transaction_numbers');
    }
}
