<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTableFinance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppob_finances', function (Blueprint $table) {
            $table->dropColumn(['minor_unit','company_name','branch_name','item_merk_type','chasis_number','car_number',
                'last_paid_period','last_paid_due','osinstallmentamount','odinstallmentperiod','odpenaltyfee','billeradminfee',
                'miscfee','minpaymount','maxpaymount']);
            $table->string('period');
            $table->string('no_polisi')->nullable();
            $table->double('nominal',12,2);
            $table->double('admin',12,2);
            $table->string('ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppob_finances', function (Blueprint $table) {
            //
        });
    }
}
