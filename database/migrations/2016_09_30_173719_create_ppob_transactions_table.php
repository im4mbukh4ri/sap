<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePpobTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppob_services',function (Blueprint $table){
            $table->unsignedTinyInteger('id');
            $table->string('name',50);
            $table->tinyInteger('parent_id');
            $table->timestamps();
            $table->primary('id');
        });
        Schema::create('ppob_products',function (Blueprint $table){
            $table->smallIncrements('id');
            $table->string('name',50);
        });
        Schema::create('ppob_service_product',function(Blueprint $table){
            $table->smallIncrements('id');
            $table->unsignedTinyInteger('ppob_service_id');
            $table->unsignedSmallInteger('ppob_product_id');
            $table->foreign('ppob_service_id')->references('id')->on('ppob_services')
                ->onUpdate('cascade');
            $table->foreign('ppob_product_id')->references('id')->on('ppob_products')
                ->onUpdate('cascade');
        });
        Schema::create('ppob_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->comment('FK to users table');
            $table->unsignedTinyInteger('ppob_service_id')->comment('FK to table ppob_services table, for index to make esier filter');
            $table->unsignedSmallInteger('ppob_product_id')->comment('FK to table ppob_products table');
            $table->string('number')->comment('Number of phone, pln, telkom, indovision, etc.');
            $table->double('qty')->default(1);
            $table->double('nominal',12,2)->default(0);
            $table->double('nta',12,2)->default(0);
            $table->double('nra',12,2)->default(0);
            $table->double('admin',12,2)->default(0);
            $table->double('paxpaid',12,2)->default(0);
            $table->string('status',50)->nullable();
            $table->string('transaction_number');
            $table->string('ref_number');
            $table->text('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade');
            $table->foreign('ppob_service_id')->references('id')->on('ppob_services')
                ->onUpdate('cascade');
            $table->foreign('ppob_product_id')->references('id')->on('ppob_products')
                ->onUpdate('cascade');
        });
        Schema::create('ppob_serial_numbers',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->string('serial_number')->nullable();
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');
        });

        Schema::create('ppob_phones',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->string('phone',20)->comment('phone number');
            $table->string('customer_name');
            $table->string('period');
            $table->string('code_area',5);
            $table->string('code_divre');
            $table->string('code_datel');
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');
        });

        Schema::create('ppob_pbjs',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->string('customer_name',50);
            $table->string('kode_cabang',20);
            $table->string('nama_cabang',50);
            $table->string('number_va',50);
            $table->boolean('status')->default(0);
            $table->text('response');
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');
        });
        Schema::create('ppob_pln_pasca',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->string('customer_name',50);
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');
        });
        Schema::create('ppob_tv_cables',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->string('customer_name',50);
            $table->string('month_year',20);
            $table->string('daya',8);
            $table->string('category',8);
            $table->string('stand_meter',50);
            $table->boolean('status')->default(0);
            $table->text('response');
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');
        });
        Schema::create('ppob_pdam',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->string('customer_name',50);
            $table->string('customer_address');
            $table->string('pdam_name',20);
            $table->string('info');
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');

        });
        Schema::create('ppob_finances',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->string('customer_name',50);
            $table->string('minor_unit',10);
            $table->string('company_name',25);
            $table->string('branch_name',20);
            $table->string('item_merk_type',50);
            $table->string('chasis_number',10);
            $table->string('car_number',10);
            $table->string('tenor',8);
            $table->string('last_paid_period',5);
            $table->string('last_paid_due',20);
            $table->string('osinstallmentamount',10);
            $table->string('odinstallmentperiod',10);
            $table->string('odpenaltyfee',10);
            $table->string('billeradminfee',8);
            $table->string('miscfee',8);
            $table->string('minpaymount',10);
            $table->string('maxpaymount',10);
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');
        });
        Schema::create('ppob_pln_pra',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->string('customer_name',50);
            $table->string('kwh',10);
            $table->string('category',4);
            $table->string('data',10);
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');
        });
        Schema::create('ppob_tag_months',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->boolean('month')->comment('month : 1 / 2 / 3 ');
            $table->double('bill',12,2);
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');

        });
        Schema::create('ppob_pdam_penalty',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ppob_transaction_id');
            $table->boolean('month')->comment('month : 1 / 2 / 3 ');
            $table->string('month_period',5);
            $table->string('year_period');
            $table->string('first_meter_read',10);
            $table->string('last_meter_read',10);
            $table->string('penalty',10);
            $table->string('misc_amount',10);
            $table->timestamps();
            $table->foreign('ppob_transaction_id')->references('id')->on('ppob_transactions')
                ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ppob_pdam_penalty');
        Schema::drop('ppob_tag_months');
        Schema::drop('ppob_pln_pra');
        Schema::drop('ppob_finances');
        Schema::drop('ppob_pdam');
        Schema::drop('ppob_tv_cables');
        Schema::drop('ppob_pln_pasca');
        Schema::drop('ppob_pbjs');
        Schema::drop('ppob_phones');
        Schema::drop('ppob_serial_numbers');
        Schema::drop('ppob_transactions');
        Schema::drop('ppob_service_product');
        //Schema::dropIfExists('ppob_products');
        //Schema::dropIfExists('ppob_services');
    }
}
