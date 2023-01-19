<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique()->comment('Username for login');
            $table->string('name')->comment('Name of member');
            $table->string('email')->comment('Not unique because 1 person / email can have many member');
            $table->string('password')->comment('Use Bcryp hashing');
            $table->string('role',10)->comment('Role login : admin, silver, gold, platinum,free');
            $table->decimal('deposit',12,2)->default(0)->comment('Deposit fo member');
            $table->string('gender',1)->nullable()->comment('Gender of member, value: L,P');
            $table->date('birth_date')->nullable()->comment('Birth date of member');
            $table->boolean('actived')->default(0)->comment('For user (member) activation if needed');
            $table->boolean('suspended')->default(0)->comment('For suspend user (member)');
            $table->integer('upline')->default(1)->comment('Member upline, default is 1 ( SIP Company)');
//            $table->string('referral',10)->nullable()->comment('Refferal number for Silver, Gold, Platinum member');
            $table->rememberToken()->comment('For reset password');
            $table->boolean('login_status')->default(0)->comment('Status login member, 0 for false (offline), 1 for true (Online)');
            $table->timestamps();
            $table->softDeletes()->comment('Optional if there are delete memeber feature but data not lost');
        });

        Schema::create('user_referrals',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('referral',10)->nullable()->comment('Refferal number for Silver, Gold, Platinum member');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade');

        });

        Schema::create('user_bank',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('FK to users table');
            $table->string('bank_name',50)->comment('Name of bank');
            $table->string('number',50)->comment('Account number');
            $table->string('owner_name')->comment('Name of bank account');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::drop('user_bank');
        Schema::drop('user_referals');
        Schema::drop('users');
    }
}
