<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectAllTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collect_all_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('username',50);
            $table->string('nama_produk',100)->nullable();
            $table->double('market_price',12,2)->default(0);
            $table->double('smart_value',12,2)->default(0);
            $table->double('komisi',8,2)->default(0);
            $table->double('komisi_90',8,2)->default(0);
            $table->double('komisi_10',8,2)->default(0);
            $table->double('sip',8,2)->default(0);
            $table->double('smart_point',8,2)->default(0);
            $table->double('smart_cash',8,2)->default(0);
            $table->double('smart_upline',8,2)->default(0);
            $table->string('username_upline',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('collect_all_transactions');
    }
}
