<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIdTypePpobService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('ppob_service_product',function (Blueprint $table){
            //$table->dropForeign('ppob_transactions_ppob_service_id_foreign');
            $table->dropForeign('ppob_service_product_ppob_service_id_foreign');
        });
        Schema::table('ppob_transactions',function (Blueprint $table){
            $table->dropForeign('ppob_transactions_ppob_service_id_foreign');
            $table->dropForeign('ppob_transactions_ppob_product_id_foreign');
            $table->dropColumn('ppob_product_id');

        });
        Schema::table('ppob_services', function (Blueprint $table) {
            $table->smallIncrements('id')->change();
        });
        Schema::table('ppob_transactions',function (Blueprint $table){
            $table->smallInteger('ppob_service_id')->unsigned()->change();
            $table->foreign('ppob_service_id')->references('id')->on('ppob_services');
        });
        Schema::drop('ppob_service_product');
        Schema::drop('ppob_products');
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
