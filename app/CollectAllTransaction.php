<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectAllTransaction extends Model
{
    //
    /*
     * $table->timestamps();
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
     */
    protected $fillable=['created_at','updated_at','id_transaksi','username','produk','nama_produk','market_price','smart_value','komisi','komisi_90','sip',
    'smart_point','smart_cash','smart_upline','username_upline'];
}
