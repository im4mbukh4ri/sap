<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInCollectAllTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collect_all_transactions', function (Blueprint $table) {
            $table->bigInteger('id_transaksi')->after('updated_at');
            $table->string('produk',20)->after('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collect_all_transactions', function (Blueprint $table) {
            //
        });
    }
}
