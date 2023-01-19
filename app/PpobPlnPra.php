<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobPlnPra extends Model
{
    protected $table="ppob_pln_pra";
    protected $fillable=['ppob_transaction_id','customer_name','kwh','golongan_daya','nominal','rp_token','admin','ppn','ppj','materai','token','reff'];

    public function ppob_transaction(){
        return $this->belongsTo('App\PpobTransaction');
    }
}
